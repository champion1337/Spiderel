<?php
class spiderel
{
    static public $mysql;
    static public $error;
    static public $config;
    static public $robots;
    static public $pagerank;
    static function load_config() {
        spiderel::$config = new Config();
    }
    static public function init() {
        $query = "TRUNCATE TABLE `links`";
        mysql_query($query);
        $url = spiderel::get_config("url");
        $browser = spiderel::get_config("browser");
        spiderel::$error = new Error();
        spiderel::$robots = new Robots();
        spiderel::$pagerank = new Pagerank;
        if (spiderel::test(spiderel::get_config('url'))) {
            spiderel::finish();
        } else {
            spiderel::$error->eexit("The url can't be accesed");
        }
    }
    static public function test($url) {
        $http = new HttpRequest;
        if ($http->get($url)) {
            return true; 
        } else {
            return false; 
        }
    }
    static public function crawl() {
        $q = new Queue;
        $q->add(spiderel::get_config('url'));
        echo "starting.... ";
        $i = 0;
        while ($q->active != "0") {
            $i++;
            $nextUrl = $q->get_next();
            if($nextUrl != false) {
                echo "Crawling " . $nextUrl . "... <br>";
                $page = new Page($nextUrl);
                if ($page->status) {
            		$links = $page->get_links();
                    $page->add_to_db();
                    $id = $page->get_db_id();
                    $q->add_array($links);
                    spiderel::$pagerank->add_link($nextUrl,$links,$id);
                }
           }
        }
        spiderel::$pagerank->calculate();
    }
    static public function add_error($error)
    {
        spiderel::$error->add($error);

    }
    static public function get_config($key)
    {
        return self::$config->get($key);
    }
    static public function finish() {
          $errors = spiderel::$error->ereturn();    
          foreach ($errors as $row) {
            echo $row . "<br>";
          }
    }
    static public function init_db() {
        include(ROOT . DS . "config" . DS . "mysql.php");
        mysql_connect($mysql_host, $mysql_user, $mysql_password) or die("Database connect failed");
        mysql_select_db($mysql_database) or die("Database load failed");
    }
}		
