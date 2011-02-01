<?php

class HttpRequest
    {
    private $host;
    private $path;
    private $port; 
    private $get;
    private $error;
    private $header;

    public $content;
    private $status;
    private $content_type;
    public function get($url) 
    {
        if( empty($url) ) return false;
        $parse = parse_url($url);
        if( !empty( $parse[ 'host' ] ) ) { $this->host = $parse['host']; }
        else { return false; }
        if( !empty( $parse[ 'path' ] ) ) { $this->path = $parse['path']; }
        else { return false; }
        if( isset( $parse['port'] ) )
        {
            $this->port = $parse['port'];
        }
        else
        {
            $this->port = "80";
        }
        if(isset($parse['query'])) { $this->get = $parse['query']; }
        $fp = fsockopen($this->host,$this->port, $errno,$errstr,30);
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
    private function _validate_status()
    {
        if( $this->status == "200")
            return true;
        else
        {
            spiderel::add_invalid_response( $this->path, $this->status );
            return false;
        }
    }

    private function _validate_content()
    {
        $valid = 0;
        if( strpos( $this->content_type, "text") !== false )
        {
            $valid = 1;
        }
        if( strpos( $this->content_type, "pdf") !== false)
        {
            $valid = 1;
        }
        if( $valid == 0 )
        {
            spiderel::add_invalid_content( $this->path, $this->content_type );
            return false;
        }
        else return true;
    }

    private function _validate()
    {
        if(
            $this->_validate_status() &&
            $this->_validate_content()
        )
        return true;
        else return false;
	}

	private function _get_headers() {
		$headers = explode("\r\n",$this->header);
		$status = explode(" ",$headers[0]);
		$this->status = $status[1];
		foreach($headers as $header) {
			$split = explode(":",$header);
			if($split[0] == "Content-Type") {

				$this->content_type = trim($split[1]);
			}
		} 
	}

    public function get_content()
    {
        return $this->content;
    }

    public function get_content_type()
    {
        return $this->content_type;
    }
}
