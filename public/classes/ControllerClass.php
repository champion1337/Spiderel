<?php
class Controller {
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_session;
    protected $_format;
    public $config;

    function __construct($model, $controller, $action, $format) {
        session_start();
        $lock_file = ROOT . DS . "install.lock";
        if(!is_file($lock_file)) {
            $this->config = new config; 
        }
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_template = new Template($controller,$action);
        $this->_template->set_format( $format );
        if(isset($_SESSION['notice'])) {
            $this->set('notice',$_SESSION['notice']);
            unset($_SESSION['notice']);
        }
        $this->_before();
    }
    function _before() {    
        $action = $this->return_action();
        $admin = "no";
        if( $this->_controller == 'install' ) { $admin = "yes"; }
        if( $this->_action == 'login') { $admin = "yes"; }
        if( $this->_action == 'admin') { $admin = "yes"; }
        if( $this->_controller == 'search') { $admin = "yes"; }
        if( $this->_controller == 'AZ') { $admin = "yes"; }
        if ( $admin == "no" && !isset($_SESSION['admin'])) {
            $this->redirect("spiderel","login","0");
        }
        
    }
   
    function set_format( $format )
    {
        $this->_format = $format;
    }

    function get_format()
    {
        return $this->_format;
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


