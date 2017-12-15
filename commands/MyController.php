<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use yii\console\Controller;

/**
 * Description of MyController
 *
 * @author roni
 */
class MyController extends Controller {

    const FTP_PATH = 'ftp.zakupki.gov.ru';
    const FTP_LOGIN = 'free';
    const FTP_PASSW = 'free';


    public function getXmlArray($xmlText) {
        $xmlObject = new xmlToArrayParser($xmlText);
        $xmlArray = $xmlObject->array;
        unset($xmlObject);
        return $xmlArray;
    }

    public function getXmlBits($xmlFileName, $tag='') {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        preg_match_all('/<' . $tag . '>.*?<\/' . $tag . '>/', $xmltext, $xmltextBits);
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

}
