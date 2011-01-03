<?php
class Queue {
	private $queue = array();
	public $active = 1;
    private function _is($url) {
        $is = 0;
        foreach($this->queue as $item) {
            if ($item['url'] == $url) {
                $is = 1;
            }
        }
        if ($is == 0) { return false; }
        else { return true; }
    }
	public function add($url) {
		$temp['url'] = $url;
		$temp['crawl'] = 0;
	        if (!$this->_is($url)) {
    			array_push($this->queue,$temp);
        	}
	}
	public function get_next() {
		foreach($this->queue as &$item) {
			if($item['crawl'] == 0) {
				$item['crawl'] = 1;
				return $item['url'];
				break;
			}
		}
		$this->active = 0;
        return "0";
	}
	public function add_array($links) {
		if (!empty($links)) {
	            foreach($links as $link) {
	    		$this->add($link);
		    }
	    }
    }
}    
