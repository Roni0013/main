<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use yii\console\Controller;
use app\models\files;
use yii\helpers\Html;
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

    public function getXmlBits($xmlFileName, $tag='') {
        $xmltext1 = file_get_contents($xmlFileName);
        $xmltext2 = preg_replace('/oos:/', '', $xmltext1);
        $xmltext3 = preg_replace('/ns2:/', '', $xmltext2);
        $xmltext4 = preg_replace('/<signature>.*?<\/signature>/', '', $xmltext3);
        $xmltext5 = preg_replace('/<consRegistryNum>.*?<\/consRegistryNum>/', '', $xmltext4);
        $xmltext6 = preg_replace('/<organizationRole>.*?<\/organizationRole>/', '', $xmltext5);
        $xmltext7 = preg_replace('/&apos/', '', $xmltext6);
        preg_match_all('/<' . $tag . '>.*?<\/' . $tag . '>/', $xmltext7, $xmltextBits);
//        print_r ($xmltextBits);
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

    protected function openFTP() {
        $urlFtp = self::FTP_PATH;
        print_r($urlFtp . "\n");
        $connectHandle = FALSE;
        $connectHandle = ftp_connect($urlFtp);
        return $connectHandle;
    }

     public function actionCopyfiles() {
        $ftpHandle = $this->openFTP();

        if (($ftpHandle) and ( ftp_login($ftpHandle, self::FTP_LOGIN, self::FTP_PASSW))) {
            echo "Соединились\n";
            $listFtpFiles[] = ftp_nlist($ftpHandle, $this->path());
            $listFtpFiles[] = ftp_nlist($ftpHandle, $this->path() . 'currMonth/');
            $listFtpFiles[] = ftp_nlist($ftpHandle, $this->path() . 'prevMonth/');
//            print_r ($this->path()."\n");
//            print_r ($this->path() . "currMonth\n");
//            print_r ($this->path() . "prevMonth\n");
//            die;
          echo "списки файлов получены \n";
//          создает новую папку
            if (!is_dir($this->pathResource())) {
                mkdir($this->pathResource());
                echo "папка создана\n";
            } else {
                echo "папка существует \n";
            }
//          все папки
            foreach ($listFtpFiles as $list) {
//          все файлы
                foreach ($list as $ftpFullName) {
                    if ((basename($ftpFullName) == 'currMonth') or ( basename($ftpFullName) == 'prevMonth')) {
                        continue;
                    }
                    $fileName = basename($ftpFullName);
                    $pathTo = $this->pathResource() . $fileName;
//                    print_r($fileName."\n");
                    if (file_exists($pathTo) and ( ftp_size($ftpHandle, $ftpFullName) == filesize($pathTo))) {
                        continue;
                    } else {
                        if (ftp_get($ftpHandle, $pathTo, $ftpFullName,FTP_ASCII)) {
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

    public function actionUpdate($parametr = '') {
        if ($parametr == '1') {
            $this->resetFiles();         //для каждого контроллера свой сброс
        }
        $pathFolder = $this->pathResource();
        $pathTempFolder = 'temp/';
        exec('rm -f temp/*');
        $listZipFiles = scandir($pathFolder);
        $currentIndexZip = 1;
        $allZips = count($listZipFiles);
        array_shift($listZipFiles);
        array_shift($listZipFiles);
        $fileNumber = 1;
        foreach ($listZipFiles as $zipFile) {
//                print_r($zipFile . "\n");
            self::unZip($pathFolder . $zipFile);
//                self::unZip($pathFolder.$zipFile);
            $listFiles = scandir($pathTempFolder);
            array_shift($listFiles);
            array_shift($listFiles);
//                $numberFiles = count($listFiles);
            //распарсить все из папки $pathTempFolder
            foreach ($listFiles as $fileName) {
//                    $this->tofile($pathTempFolder.$fileName);
                $commandTofile = "php yii cust/tofile $pathTempFolder$fileName $fileNumber";
                print_r($commandTofile);
//                    print_r($commandTofile."\n");
                exec($commandTofile);
                unlink($pathTempFolder . $fileName);
            }
            echo "   вставлен \n";
            $currentIndexZip++;
            $fileNumber++;
        }
        $this->putToFile($this->pathDestination(), ';');
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
    public function resetFiles() {

    }
}