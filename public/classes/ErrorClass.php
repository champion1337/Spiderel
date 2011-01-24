<?php
class Error
{
    private $_errors = array();
    public function add($error) {
        array_push($this->_errors, $error);
    }
    public function eexit($error) {
        print_r($this->_errors);
        echo "A fatal error has occured: " . $error;
        exit(0);
    }
    public function ereturn() {
        return $this->_errors;
    }
}

