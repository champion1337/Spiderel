<?php
class Search
{
    private $results = array();
    function __construct( $query )
    {
        $query = mysql_real_escape_string( $query );
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
