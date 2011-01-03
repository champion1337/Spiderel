<?php

class HttpRequest
    {
    private $host;
    private $path;
    private $get;
    private $error;
    private $header;
    public $content;
    private $status;
    private $content_type;
    public function get($url) 
    {
        $parse = parse_url($url);
        $this->host = $parse['host'];
        $this->path = $parse['path'];
        if(isset($parse['query'])) { $this->get = $parse['query']; }
        $fp = fsockopen($this->host,80, $errno,$errstr,30);
		if(!$fp)
        {
            $this->error = "$url -> $errno $errstr";
            spiderel::add_error("Unable to connect to " . $this->host . " returned error: " . $this->error);
            return false;
		}
        else
        {
            $message =  "POST $this->path HTTP/1.1\r\n";
            $message .=  "Host: $this->host\r\n";
            $message .=  "Content-type: application/x-www-form-urlencoded\r\n";
        	$message .=  "Content-length: ".strlen($this->get)."\r\n";
        	$message .=  "Connection: close\r\n\r\n";
        	$message .=  $this->get; 
            fputs($fp, $message);
            $d = "";
		    while(!feof($fp)) $d .= fgets($fp,4096);
		    fclose($fp); 
            $result = explode("\r\n\r\n", $d, 2);
            $this->header = isset($result[0]) ? $result[0] : '';
            $this->content = isset($result[1]) ? $result[1] : '';
            $this->content = strstr($this->content,"<");
            $this->_get_headers();
            if($this->_validate()) return true;
            else
            {
                
                spiderel::add_error("Unable to validate http response for " . $url);
                return false;
			}
		}
	}
    private function _validate()
    {
        $fail = 0;
		if( ($this->status != "200") ) { spiderel::add_error("Invalid http response : " . $this->status . " for " . $this->path); $fail = 1; }
		$pos1 = strpos($this->content_type,"text");
		if( (strpos($this->content_type,"text") === false) ) { spiderel::add_error("Invalid content type: " . $this->content_type . " for " . $this->path); $fail=1;}
		if($fail == 1) { return false; }
		else {return true; }
	}
	private function _get_headers() {
		$headers = explode("\r\n",$this->header);
		$status = explode(" ",$headers[0]);
		$this->status = $status[1];
		print("\r\n\r\n");
			
		foreach($headers as $header) {
			$split = explode(":",$header);
			if($split[0] == "Content-Type") {

				$this->content_type = trim($split[1]);
			}
		}
		
		 
	}
}
