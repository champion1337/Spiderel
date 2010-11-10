<?php
class Config
{
    private $_configs = array();
    public function get($key) {
        if (isset($this->_configs[$key])) {
            return $this->_configs[$key];
        }
    }
    public function __construct() {
        if (isset($_GET['cron'])) {
            // load from db
        } else {
            $this->_configs['url'] = "http://www.webs-it.com/"; //$_POST['url'];
            $this->_configs['path'] = "http://www.webs-it.com/";
            $this->_configs['browser'] = "spiderel";
            $this->_configs['domain'] = "webs-it.com";
            $this->_configs['follow_sub_domain'] = true;
        }
    }	
}

