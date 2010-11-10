<?php

class Robots {
	private $host;
	private $contents;
	public $rules = array('+','-');
	private $browser;
	public function __construct($url,$browser) {
		$parser = parse_url($url);
		$this->host = $parser['host'];
		$this->browser = $browser;
		$http = new HttpRequest;
		$http->get("http://" . $this->host . "/robots.txt");
		$raw_text = $http->content;
		if($raw_text) {
			$this->contents =  $raw_text;
		}
		else { spiderel::$error->add("Robots.txt file not found");}
		$this->create_rules();	
	}

	private function create_rules() {
		$lines = explode("\n",$this->contents);
		$permissions = array();
		foreach ($lines as $line) {
			if(strpos(trim($line), '#') === 0) {
				continue;
			} 
			else {
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
		if(isset($permissions[$user_agent])) {
			$this->rules = $permissions[$user_agent];
		}
		else {	$this->rules = $permissions['*']; }
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
