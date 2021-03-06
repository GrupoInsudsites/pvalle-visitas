<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Push extends CI_Controller {

     public function __construct() {
        parent::__construct();
        
        $this->load->model('evento');
    }
    
    public function pushData() {
        $data = $this->evento->exportData();
        
        $posValue =  json_encode($data);
        
        
        
        $url ="http://timesheet-sistemas-dev.grupoinsud.com/get/getData";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,array('token' => $posValue));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
          
     
        $response = curl_exec($ch);
        var_dump($response);
        curl_close($ch);
        
        if($response == "exito"){
            foreach ($data as $value) {
                $this->evento->disableImporter();
            }
        }
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
    }
    public function habilitedImporter(){
        $this->db->set('exportado', 0);
        $this->db->update('entradasalida');
        
    }
    
}