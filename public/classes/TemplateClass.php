<?php
class Template {
    protected $variables = array();
    protected $_controller;
    protected $_action;
    function __construct($controller,$action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }

/** Set Variables **/

    function set($name,$value) {
        $this->variables[$name] = $value;
    }

/** Display Template **/

    function render() {
        extract($this->variables);
        $header =  ROOT . DS . 'views' . DS . $this->_controller . DS . 'header.php';
        if (file_exists($header)) {
            include ($header);
        } else {
            include (ROOT . DS . 'views' . DS . 'header.php');
        }
            include (ROOT .  DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
        $footer =  ROOT . DS . 'views' . DS . $this->_controller . DS . 'footer.php';
        if (file_exists($footer)) {
            include ($footer);
        } else {
            include (ROOT . DS . 'views' . DS . 'footer.php');
        }
    }

}

