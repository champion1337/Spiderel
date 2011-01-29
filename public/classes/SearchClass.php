<?php
class Search
{
    private $results = array();
    private $keywords;
    private $stype;
    function set_keywords( $query )
    {
        $this->keywords = $query;
    }

    function set_type( $type )
    {
        $this->stype = $type;
    }
    
    function do_search()
    {
        if( $this->stype == "normal" ) { $this->normal_search(); }
        if( $this->stype == "against" ) { $this->against_search(); }
        if( $this->stype == "filter1" ) { $this->filter1_search(); }
    }

    private function against_search()
    {
        $query = mysql_real_escape_string( $this->keywords );
        $mysql_query = "SELECT * FROM links WHERE MATCH (title,url,content) AGAINST('$query')";
        $result = mysql_query( $mysql_query ) or die( mysql_error() );
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
        {
            array_push( $this->results, $row );
        }
        if( mysql_num_rows( $result ) == 0 )
            $this->normal_search();
    }

    private function filter1_search()
    {
    }

    private function normal_search()
    {
        $query = mysql_real_escape_string( $this->keywords );
        $mysql_query = "SELECT `url`,`title`,`pagerank` FROM `links`  WHERE `content` LIKE '%$query%' ORDER BY `pagerank` DESC
        LIMIT 0 , 30";
        $result = mysql_query( $mysql_query ) or die( mysql_error() ) ;
        while ($row = mysql_fetch_array( $result, MYSQL_ASSOC )) 
        {
            array_push($this->results,$row);
        }
    }
    
    function get_results () 
    {
        return $this->results;
    }
}
