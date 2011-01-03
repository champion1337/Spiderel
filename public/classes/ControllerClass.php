<?php
class Controller {
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_session;
    public $config;
    function __construct($model, $controller, $action) {
        session_start();
        $this->config = new config; 
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_template = new Template($controller,$action);
        if(isset($_SESSION['notice'])) {
            $this->set('notice',$_SESSION['notice']);
            unset($_SESSION['notice']);
        }
        $this->_before();
    }

    function set($name,$value) {
        $this->_template->set($name,$value);
    }
    
    function add_notice($notice) {
        $_SESSION['notice'] = $notice;
    }
    function __destruct() {
        $this->_template->render();
    }
    function redirect($controller,$action,$query) {
        header( 'Location: index.php?url=' . $controller . '/' . $action ) ;
    }
    function return_action() {
        return $this->_action;
    }
}

