<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use app\commands\MyController;

/**
 * Description of NotificationController
 *
 * @author roni
 */
class NotificationController extends MyController{




    public function path() {
        return 'fcs_regions/Krasnodarskij_kraj/notifications/';
    }

    public function pathResource (){
        return 'resource/notification/';
    }


    public function pathDestination() {
        return [
            'notification' => 'files/notification/notification'

        ];
    }

    public function resetFiles() {
        if (file_exists('resource/idcurrent/notification')) {
            unlink('resource/idcurrent/notification');
        }
        exec('rm -f files/notification/*');
        
    }

}
