<?php
class InstallController extends Controller 
{
    public function index() {

    }
    public function mysql() {
        $host = $_POST["host"];
        $user = $_POST['user'];
        $password = $_POST['pass'];
        $database = $_POST['database'];
        $success = 1;
        if (!mysql_connect($host, $user, $password)) {
            $this->add_notice( "Unable to connect");
            $success = 0;
        }
        if (!mysql_select_db($database)) {
            $this->add_notice( "Unable to select database" );
            $success = 0;
        }
        if($success == 0) {
            $this->redirect("install","index",0);
        }
        else {
            $mysql_file = ROOT . DS . "config/mysql.php";
            $f = fopen($mysql_file,"w");
            $mysql_data = '<?php
            ';
            $mysql_data .= '$mysql_host = "' . $host . '";
            ';
            $mysql_data .= '$mysql_user = "' . $user . '";
            ';
            $mysql_data .= '$mysql_password = "' . $password . '";
            ';
            $mysql_data .= '$mysql_database = "' . $database . '";
            ';
            fwrite($f, $mysql_data); //write config/mysql.php
            spiderel::init_db();
            if (!spiderel::create_tables()) {
                $this->add_notice("Unable to create tables");
                $this->redirect("install", "index", 0);
            }
            else {
                $this->redirect("install","robots",0);
            }
        }
    }
    public function robots() {
        $path_robots = ROOT . DS . "robots.txt";
        $this->set("path_robots", $path_robots);
    }
    public function check_robots() {
        if(!isset( $_POST['skip'])) {
            if(!fopen($_POST['path'],"a+")) {
                $this->add_notice("Unable to open file");
                $this->redirect("install","robots", 0);
            }
            else {
                $this->config = new config;
                $this->config->set('path_robots_txt',$_POST['path']);
                //add path to robots file to db
                $this->redirect("install","admin","0");
            }
        }
        else {
            $this->redirect("install","admin","0");
        }
    }
    public function admin() {
    
    }
    public function add_admin() {
        $this->config = new config;
        $user = $_POST['user'];
        $password = $_POST['password'];
        //add user and pass to db
        $this->config->set("admin_user", $_POST['user']);
        $this->config->set("admin_password", $_POST['password']);
    }
}
