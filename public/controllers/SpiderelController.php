<?php
class SpiderelController extends Controller 
{
    function _before() {
        
        $action = $this->return_action();
        $admin = "no";
        if( $action == 'login') { $admin = "yes"; }
        if( $action == 'admin') { $admin = "yes"; }
        if ( $admin == "no" && !isset($_SESSION['admin'])) {
            $this->redirect("spiderel","login","0");
        }
        
    }
    public function crawl() {
        if(isset($_POST['start'])) { $start_url = $_POST['start']; }
        if(isset($_POST['robots'])) { $robots = $_POST['robots']; }
        if(isset($_POST['rules'])) { $rules = $_POST['rules']; }
        if(isset($_POST['agent'])) { $agent = $_POST['agent']; }
        if(isset($_POST['cron'])) { $cron = $_POST['cron']; }
        if(isset($_POST['subdomains'])) { $subdomains = $_POST['subdomains']; }
        else { $subdomains = ""; }
        $f = fopen($robots,"w");
        fwrite($f,$rules);
        fclose($f);
        spiderel::load_config();
        spiderel::$config->set('url',$start_url);
        spiderel::$config->set('robots', $robots);
        spiderel::$config->set('agent',$agent);
        spiderel::$config->set("follow_sub_domain",$subdomains);
        $parse = parse_url( $start_url );
        spiderel::$config->set("domain", $parse['host']);
        spiderel::$config->save_config();
        spiderel::init();

        spiderel::crawl();
        spiderel::finish();
    }


    public function logout() {
        unset($_SESSION['admin']);
        $this->redirect('spiderel','login','0');
    }
    public function admin() {
        if(isset($_POST['user']) && isset($_POST['pass'])) {
            $post_user = $_POST['user'];
            $post_pass = $_POST['pass'];
            $cf_user = $this->config->get('admin_user');
            $cf_pass = $this->config->get('admin_password');
            if(
                ($post_user == $cf_user) &&
                ($post_pass == $cf_pass)
            ) {
                $_SESSION['admin'] = "yes"; 
                $this->redirect("spiderel","index","0");
            }
            else {
                $this->add_notice("Invalid username or password");
                $this->redirect("spiderel","login","0");
            }
        }
        else {
            $this->redirect("spiderel","login","0");
        }
    }

    public function login() {
    }
    
    public function index() {
        spiderel::load_config();
        $start = spiderel::$config->get("url"); 
        $robots = spiderel::$config->get("robots");
        $agent = spiderel::$config->get("agent");
        $follow_sub_domain = spiderel::$config->get("follow_sub_domain");
        $this->set('start',$start); 
        $this->set('path_robots',$robots);
        $this->set('agent',$agent);
        if(file_exists($robots)) {
            $f = fopen($robots,"r");
            $rules = fread($f,filesize($robots));
            fclose($f);
            $this->set('rules', $rules);
        }
        else {
            $this->set('rules',"");
        }
    }
}
