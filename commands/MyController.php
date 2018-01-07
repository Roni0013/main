<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use yii\console\Controller;
use app\models\files;
use app\models\filestodb;
use app\models\sqlfromzip;
/**
 * Description of MyController
 *
 * @author roni
 */
class MyController extends Controller {

    const FTP_PATH = 'ftp.zakupki.gov.ru';
    const FTP_LOGIN = 'free';
    const FTP_PASSW = 'free';
    public static $autoinc ;
    public static $isFirst = FALSE;
//    public static $fileNumber = 1;

    public function getXmlArray($xmlText) {
        $xmlObject = new xmlToArrayParser($xmlText);
        $xmlArray = $xmlObject->array;
        unset($xmlObject);
        return $xmlArray;
    }

    public function getXmlBits($xmlText, $tag='') {

        $xmltextBits = [];
        $xmlText = preg_replace('/oos:/', '', $xmlText);
        $xmlText = preg_replace('/ns2:/', '', $xmlText);
        $xmlText = preg_replace('/<signature>.*?<\/signature>/', '', $xmlText);
        $xmlText = preg_replace('/<consRegistryNum>.*?<\/consRegistryNum>/', '', $xmlText);
        $xmlText = preg_replace('/<organizationRole>.*?<\/organizationRole>/', '', $xmlText);
        $xmlText = preg_replace('/&apos;/', '', $xmlText);
        $xmlText = preg_replace('/\'/', '"', $xmlText);
        $xmlText = preg_replace('/\\\/', '"', $xmlText);

        preg_match_all('/(?s)<' . $tag . '>.*?<\/' . $tag . '>/', $xmlText, $xmltextBits);
        return $xmltextBits[0];
    }

    public static function delArrays($arr) {
        $result = [];
        foreach ($arr as $key => $value) {
            if (!is_array($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    protected function path() {
        return '';
    }

    public function manyActions () {
        return [];
    }

    protected function openFTP() {
        $urlFtp = self::FTP_PATH;
        print_r($urlFtp . "\n");
        $connectHandle = FALSE;
        $connectHandle = ftp_connect($urlFtp);
        return $connectHandle;
    }

     public function actionCopyfiles() {
        $ftpHandle = $this->openFTP();
//      перечислить адреса для каждой таблицы
        foreach ($this->path() as $keyPath=>$valuePath) {
                if (($ftpHandle) and ( ftp_login($ftpHandle, self::FTP_LOGIN, self::FTP_PASSW))) {
                    echo "Соединились\n";
                    $listFtpFiles[$keyPath][] = ftp_nlist($ftpHandle, $valuePath);
                    $listFtpFiles[$keyPath][] = ftp_nlist($ftpHandle, $valuePath . 'currMonth/');
                    $listFtpFiles[$keyPath][] = ftp_nlist($ftpHandle,$valuePath . 'prevMonth/');
        //            print_r ($this->path()."\n");
        //            print_r ($this->path() . "currMonth\n");
        //            print_r ($this->path() . "prevMonth\n");
                  echo "списки файлов получены \n";
        //          создает новую папку
                    if (!is_dir($this->pathResource()[$keyPath])) {
                        mkdir($this->pathResource()[$keyPath]);
                        echo "папка создана\n";
                    } else {
                        echo "папка существует \n";
                    }
        //          все папки
                    foreach ($listFtpFiles[$keyPath] as $list) {
        //          все файлы
                        foreach ($list as $ftpFullName) {
                            if ((basename($ftpFullName) == 'currMonth') or ( basename($ftpFullName) == 'prevMonth')) {
                                continue;
                            }
                            $fileName = basename($ftpFullName);
                            $pathTo = $this->pathResource()[$keyPath] . $fileName;
        //                    print_r($fileName."\n");
        //                    $remoteSize = ftp_size($ftpHandle, $ftpFullName);
        //                    $localSize =filesize($pathTo);
                            if (file_exists($pathTo) and ( ftp_size($ftpHandle, $ftpFullName) === filesize($pathTo))) {
        //                        echo "   отказ \n";
                                continue;
                            } else {
        //                        echo "удаленный размер $remoteSize ==  $localSize";
                                if (ftp_get($ftpHandle, $pathTo, $ftpFullName,FTP_BINARY)) {
                                    echo "$fileName скопирован \n";
                                } else {
                                    echo "$fileName не скопирован \n";
                                }
                            }
                        }
                    }
                } else {
                    echo 'Ошибка FTP';
                }
        }
    }

    public function actionUpdate($tableName = '', $parametr = '') {
        $request = \yii::$app->request->getParams()[0];
        if (!isset($paramToExec)) {
            $paramToExec= str_replace('update', 'tofile', $request);
        }
        if (empty($tableName)) {
            echo "Укажите название таблицы \n";
            print_r (array_keys($this->pathDestination()));
            die;
        }
        $className = substr($paramToExec,0, strpos($paramToExec, '/'));
        $pathFolder=$this->pathResource()[$tableName];
//        print_r($tableName);
        if ($parametr == '0') {
            echo "Внимание!!! Будет произведен сброс через 5 секунд!!! \n";
            sleep(5);
            echo "Старт \n";
            $this->resetFiles($tableName);         //для каждого контроллера и таблицы свой сброс
            files::deleteAll(['tablename'=>$tableName]);
            $fileObj = new files();
            $fileObj->setAttributes(['tablename' => $tableName,'number'=>'0']);
            $fileObj->save();
            unset ($fileObj);

        } elseif ($parametr>0) {
            echo "поиск sql под номером $parametr для таблицы $tableName\n";

            $fileTable= files::find()->where(['tablename'=>$tableName,'number'=>$parametr])->asArray()->limit(1)->one();
            $zipFile=$fileTable['zipfile'];
            exec('rm -f temp/*');
            self::unZip($pathFolder . $zipFile);
            exec ('rm -f temp/*.sig');
            $commandTofile = "php yii $className/$tableName $parametr";
            print_r($commandTofile."\n");
            exec($commandTofile);
            filestodb::deleteAll(['tablename'=>$tableName,'number'=>$parametr]);
            exit;
        }

        $query = files::find()->where(['tablename'=>$tableName])->asArray()->all();
//      список zip файлов из таблицы
        $zipsFilesCache= array_column($query, 'zipfile');
        $numbers= array_column($query, 'number');
//        print_r ($numbers); die;
//        определение начального номера файла для sql файлов
        if (!empty($numbers) and (is_array(($numbers)))) {
            $fileNumber = max ($numbers)+1;
        } else {
            $fileNumber =1;
        }
        if ($fileNumber == 0) $fileNumber = 1;
//            echo "$tableName"; die;

            $pathTempFolder = 'temp/';


            $listZipFiles = scandir($pathFolder);
            $currentIndexZip = 1;
            $allZips = count($listZipFiles);
            array_shift($listZipFiles);
            array_shift($listZipFiles);
    //        перебрать zip файлы
            foreach ($listZipFiles as $zipFile) {
    //          если zip файл уже есть в кэш таблицы то continue
                if ((isset($zipsFilesCache)) and (in_array($zipFile, $zipsFilesCache))) {
                    continue;
                }

                //удалить sql файл под номером $fileNumber
                $this->delSqlFile($tableName, $fileNumber);
                exec('rm -f temp/*');
                self::unZip($pathFolder . $zipFile);
                $startTime = microtime(TRUE);
                    $commandTofile = "php yii $className/$tableName $fileNumber";
                    print_r($commandTofile."\n");
                    exec($commandTofile);
                $endTime = microtime(TRUE);
                $time = ($endTime - $startTime);
                $sec=$time % 60 ;
                $min = (int)($time /60);
                echo " $tableName.sql создан из $zipFile  за $min минут $sec секунд \n";
                // запомнить zip файл
                $fileObj= new files;
                $fileObj->setAttributes(['tablename'=> $tableName,'zipfile'=>$zipFile,'number'=>$fileNumber ]);
                $fileObj->save();
                unset ($fileObj);
    //            echo "$zipFile    $className.$fileNumber.sql";

                $currentIndexZip++;
                $fileNumber++;
            }
//        $pathDest=$this->pathDestination();
//        $this->putToFile($pathDest, ';');
    }

    private static function unZip($fileName, $pathTo = 'temp'){
        $zip= new \ZipArchive();
        if ($zip->open($fileName) === TRUE ) {
            $zip->extractTo($pathTo);
            $zip->close();
        }
        unset ($zip);
    }

    public function getStrVal($values, $intCount = 0) {
        if (!self::$isFirst) {
            $stroka = " (";
        } else {
            $stroka = ", \n (";
        }

        $i = 1;
        foreach ($values as $value) {
            if (!is_array($value)) {
                if ($value == '') {
                    $value = 'NULL';
                }
                if (($i > $intCount) and ( $value <> 'NULL')) {
                    $stroka .= "'" . $value . "',";
                } else {
                    $stroka .= $value . ",";
                    $i++;
                }
            }
        }
        $stroka = rtrim($stroka, ',');
        $stroka .= ")";
        return $stroka;
    }

    public function getStrFirstLine ($values) {
        $stroka='(';
        foreach ($values as $value) {
            $stroka .= $value . ',';
        }
        $stroka = rtrim($stroka, ',');
        $stroka .= ')';
        return $stroka;
    }

    public function putToFile($fileName, $valuesLine) {
        if (!file_put_contents($fileName, $valuesLine, FILE_APPEND)) {
            die('ошибка записи');

        }
    }

    public function pathDestination() {
        return '';
    }

    public function pathResource (){
        return '';
    }

    //удалить временный файл, обнулить id
    public function resetFiles($tableName) {

    }
    //удалить не доработанный sql файл
    public function delSqlFile($tableName,$number) {

    }
//    удалить дубликаты записей с номером $number из таблицы $tablename
    public function delDoubleIds($tablename, $number) {
    }

    public function textArrays() {
        $fileNames = scandir('temp');
        array_shift($fileNames);
        array_shift($fileNames);
//        заполнить массив xmlBits
        $xmlBits = [];
        foreach ($fileNames as $fileName) {
            $xmlBits[] = $this->getXmlArray ('temp/'.$fileName);
        }
//        print_r ($xmlBits); die;
        return $xmlBits;
    }


    //вставка sql файлов в БД
    public function actionTodb($tableName = '',$parametr = 0) {
        $request = \yii::$app->request->getParams()[0];
        $className = substr($request, 0, strpos($request, '/'));
        if (empty($tableName)) {
            echo "Укажите название таблицы \n";
            print_r (array_keys($this->pathDestination()));
            die;
        }
//        $tableNames = array_keys($this->pathDestination());
//        sort ($tableNames);
        //если один, то обнулить таблицу filestodb удалить все записи из БД
        if ($parametr == 0) {
//            foreach ($tableNames as $tableName) {
                filestodb::deleteAll(['tablename' => $tableName]);
//            }
        }
//        для каждой таблицы
//        foreach ($tableNames as $tableName) {
            $dbConfig = \yii::$app->db;
            $user = $dbConfig->username;
            $passwd = $dbConfig->password;
            $dbName = substr($dbConfig->dsn, strrpos($dbConfig->dsn, '=') + 1);
//            echo "$dbName"; die;
            //      взять все номера файлов из zip таблицы которые обработаны
            $queryNumber = files::find()->where(['tablename' => $tableName])->asArray()->all();
            //      список zip файлов из таблицы
            $sqlNumberCache = array_column($queryNumber, 'number');
            if (!isset($sqlNumberCache)) {
                echo "Вставлять нечего \n";
                exit;
            }
            //       взять все номера  файлов, которые уже вставлены в БД
            $queryBd = filestodb::find()->where(['tablename' => $tableName])->asArray()->all();

            $sqlFilesDb = array_column($queryBd, 'number');
            //найти разницу в массивах
            $sqlDiffFiles = array_diff($sqlNumberCache, $sqlFilesDb);
            if (!isset($sqlDiffFiles)) {
                echo "Вставлять нечего \n";
                exit;
            }
            sort($sqlDiffFiles);
//            print_r ($sqlDiffFiles); die;
            //      всю эту разницу вставить в БД
//            print_r($sqlDiffFiles);
            foreach ($sqlDiffFiles as $sqlNumb) {
                //перед вставкой удалить все записи с данным номером файла $sqlNumb
                $this->delDoubleIds($tableName, $sqlNumb);
                $fileTodb = new filestodb();
                //       сформировать путь до sql файла
                $pathExec = dirname($this->pathDestination()[$tableName]) . '/' . $tableName . $sqlNumb . '.sql';

                if (file_exists($pathExec)) {
                    $command = "mysql -u $user -p$passwd $dbName < $pathExec";
                    echo "Вставка $tableName$sqlNumb.sql";
                    exec($command);
                    $fileTodb->setAttributes(['tablename' => $tableName, 'number' => $sqlNumb]);
                    $fileTodb->save();
                    unset($fileTodb);
//                      print_r ($command ."\n");
//
                }else {
                    echo "Файл $pathExec не существует \n";
                    files::deleteAll(['tablename'=>$tableName,'number'=>$sqlNumb]);
                }
            }
//        }
    }

}

