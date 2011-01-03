<?php

class Robots {
	private $host;
	private $contents;
	public $rules = array('+','-');
	private $browser;
	public function __construct() {
        $this->browser = spiderel::$config->get('agent');
        $robots_file = spiderel::$config->get('robots');
        $f = fopen($robots_file,"r");
        $contents = fread($f,filesize($robots_file));
        fclose($f);
		$raw_text = $contents;
		if($raw_text) {
			$this->contents =  $raw_text;
		}
		else { spiderel::$error->add("Robots.txt file not found");}
		$this->create_rules();	
	}

	private function create_rules() {
        $user_agent = $this->browser;
		$lines = explode("\n",$this->contents);
		$permissions = array();
        $permissions['*'] = "*";
		foreach ($lines as $line) {
			if(strpos(trim($line), '#') === 0) {
				continue;
			} 
			else {
				if(strpos($line,":")) {
                    list($key,$value) = explode(':',trim($line));
    				switch(strtolower($key)) {
    					case "user-agent": 
				    		$user_agent = trim($value);
			    			$permissions[$user_agent] = array('+' => array(),'-' => array());
	    					break;
    					case "allow";
		    				array_push($permissions[$user_agent]['+'],$value); 
    					case "disallow":
					    	array_push($permissions[$user_agent]['-'], $value);
				    }					
                }
			}
		}
		if(isset($permissions[$user_agent])) {
			$this->rules = $permissions[$user_agent];
		}
	}
	public function isAllowed($path) {
		$isallowed = true;
		foreach($this->rules['-'] as $rule) {
				$regex = preg_quote(trim($rule));
				$regex = str_replace('\*','.+',$regex);
				$regex = "#^$regex". '$' . "#i";
				#echo $regex;
				if(preg_match($regex,$path)) {
					$isallowed = false;
				}
		}
		foreach($this->rules['+'] as $rule) {
				$regex = preg_quote(trim($rule));
				$regex = str_replace('\*','.+',$regex);
				$regex = "#$regex". '$' . "#i";
				#echo $regex;
				if(preg_match($regex,$path)) {
					$isallowed = true;
				}
		}		
		return $isallowed;
	}
}
