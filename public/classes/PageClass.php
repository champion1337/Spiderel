<?php
class Page {

	private $url;
	private $content;
	private $text;
    private $_id;
    public $status = true;

	function strip_html_tags( $text )
    {
        $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
        return strip_tags( $text );
    } 
    function __construct($init) {
        $this->url = $init;
        $http = new HttpRequest();
        if($http->get($init)) {
            $raw_text = $http->content;
        	$this->content = $raw_text ;
            if(preg_match( '@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s+charset=([^\s"]+))?@i',$raw_text, $matches )) {
                $encoding = strtolower($matches[3]);
                if (!empty($encoding)) {
                    if ($encoding != "utf-8") {
                        /* Convert to UTF-8 before doing anything else */
                        $utf8_text = iconv( $encoding, "utf-8", $raw_text );        
                        /* Strip HTML tags and invisible text */
                        $utf8_text = $this->strip_html_tags( $utf8_text ); 
                        /* Decode HTML entities */
                        $utf8_text = html_entity_decode( $utf8_text  ); 
         	    	    $raw_text = $utf8_text;
             	    	$this->text = $raw_text; 
                    }                    
                    else {
                        $this->text = html_entity_decode($this->strip_html_tags($raw_text));
                    }
                }
                else {
                    $this->text = html_entity_decode($this->strip_html_tags($raw_text));
                }
                $this->title = preg_match('!<title>(.*?)</title>!i', $raw_text, $matches) ? $matches[1] : '';
                $this->text = preg_replace('/\s+/', ' ',$this->text);
            }
            else {
                $this->status = false;
            }  
        } else {
      	    $this->status = false;
        }
	}
	public function get_url() {
		return $this->url;
	}
	public function get_links() {
		$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
		if(preg_match_all("/$regexp/siU", $this->content, $matches)) { 
			$filtered = $this->_filter_links($matches[2]);
			return $filtered;
		}
		else return false;
	}
	public function get_text() {
		return $this->text;
	}
    public function get_db_id() { 
        return $this->_id;
    }
    public function add_to_db() {
        $query = " 
        INSERT INTO `spiderel`.`links` (
        `url` ,
        `title` ,
        `content`
        )
        VALUES (
        '" . $this->url . "', '" . $this->title . "', '" . mysql_real_escape_string($this->text) . " '
        );
        ";
        mysql_query($query) or spiderel::add_error("failed to execute query " . $query . " ! the mysql server returned " . mysql_error() . " .i ");
        $query = "SELECT * from `spiderel`.`links` WHERE url='" . $this->url . "'"; 
        $result = mysql_query($query) or spiderel::add_error("failed to execute query " . $query . " ! the mysql server returned " . mysql_error() . " .i ");
        $row = mysql_fetch_array($result);
        $this->_id = $row['id'];
        
    }

    private function _identify_url($url,$base_url,$current_url) {
        $parse_base = parse_url( $base_url );
        $parse_current = parse_url( $current_url );
        $domain_base = $parse_base['host'];
        $domain_current = $parse_current['host'];
        if( strpos( $domain_current, $domain_base ) === false )
        {
            //identify the URL base that needs to be followed relative to subdomain/directories
            $path = str_replace($base_url,"",$current_url);
            $url_dirs = explode("/",$url);
            $base_dirs = explode("/",$path);
            $pop = array_pop($base_dirs);
            if($pop != $path) {
                foreach($url_dirs as $dir) {
                    if($dir == "..") {
                        array_pop($base_dirs);
                    }
                    else {
                        array_push($base_dirs,$dir);
                    }
                }
                $path = implode("/",$base_dirs);
                $path = $base_url . $path;
            }
            return $path;
        }
        else { return $base_url . $url; } 
    }
	private function _filter_links($links) {
		$filtered = array();//array for checked links
		foreach ($links as $link) {
            if (strpos($link, "#") !== false ) { //remove #
                $link = strstr($link, '#', true);
            }
            $push = 1;
            $isUrl = 0;
            if (strpos($link, "javascript:") !== false || (strpos($link, "://") !== false)) {            
                $push = 0;
            } //the links are for  javascript
            if (strpos($link, "://") !== false) {
                $isUrl = 1;
                $domain = spiderel::get_config('domain');
                $www_domain = "www." . $domain; 
                $parse_url = parse_url($link); 
                if ($parse_url['host'] == $domain || (strpos($www_domain,$parse_url['host']) !== false )) {
                    $push = 1;
                }
                elseif(
                    (spiderel::get_config('follow_sub_domain') == "yes") &&
                    (strpos($domain, $link) !== false)
                ) {
                    $push = 1;
                }
            }
            if ($push == 1) { 
                if ($isUrl == 0) {
                    //echo $link . "<br>";
                    //echo spiderel::get_config('url') . "<br>";
                    //echo $this->url . "<br>";
                    $link = $this->_identify_url($link,spiderel::get_config('url'),$this->url);
                }
	 			array_push($filtered, $link);
			}
		}
		return $filtered;
	}

}
