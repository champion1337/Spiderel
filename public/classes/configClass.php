<?php
class config
{
    private $_configs = array();

    private function _load_config_db() {
        spiderel::init_db();
        $query = "SELECT * FROM `config` WHERE 1";
        $result = mysql_query($query);
        if(mysql_num_rows($result) > 0) {
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $this->_configs[$row['key']] = $row['value'];
            }
        }
    }
    protected function _save_config_db() {
        foreach($this->_configs as $key => $value) {
            $key = mysql_real_escape_string($key);
            $value = mysql_real_escape_string($value);
            $query1 = "SELECT * FROM `config` WHERE `key`='" . $key . "'";
            $result = mysql_query($query1) or die(mysql_error());
            if(mysql_num_rows($result) > 0 ) { 
                $query = "DELETE FROM `config` WHERE `key`='" . $key . "'";
                mysql_query($query) or die(mysql_error());
            }
            $query = "INSERT INTO `config` (`key`, `value`) VALUES 
            ('" . $key . "', '" . $value . "');";
            mysql_query($query) or die(mysql_error());
        }
    }
    public function get($key) {
        if (isset($this->_configs[$key])) {
            return $this->_configs[$key];
        }
    }
    public function set($key,$value) {
        $this->_configs[$key] = $value;
    }
    
    public function save_config() {
        $this->_save_config_db();
    }
    public function __destruct() {
        $this->_save_config_db();
    }
    public function __construct() {
        $this->_load_config_db();
        if (isset($_GET['cron'])) {
            // load from db
        } else {
        }
    }
    public function create_tables() {
        $tables_file = ROOT . DS . "config" . DS . "tables.sql";
        $f = fopen($tables_file,"r");
        $query = fread($f,filesize($tables_file));
        fclose($f);
        if (mysql_query($query)) {
            return true;
        }
        else {
            return false;
        } 
    }
}

