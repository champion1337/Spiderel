<?php
class ReportController extends Controller
{

    function index()
    {
        $params = explode( "/", $_GET['url']);
        if( !empty( $params[ 2 ] ) )
            $page = $params[ 2 ];
        else $page = 1;
        if( !empty( $params[ 3 ] ) ) 
            $order = $params[ 3 ];
        else $order = "pagerank";
        if( !empty( $params[ 4 ] ) )
            $order_type = $params[ 4 ];
        else $order_type = "DESC";

        $query = "SELECT COUNT(*) FROM links where 1";
        $result = mysql_query( $query ) or die( mysql_error() );
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
            $total_pages = intval( $row[ 'COUNT(*)' ]);
        $page = intval( $page );
        $current_page = $page;
        $page = $page - 1;
        $page = $page * 30;
        $query = "SELECT * FROM links WHERE 1 ORDER BY " . $order . " " . $order_type . " LIMIT " . $page . ", 30";
        $result = mysql_query( $query ) or die(mysql_error());
        $links = array();
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) )
            array_push( $links, $row );
        $total_pages = intval( $total_pages / 30 ) + 1;
        $this->set( "order", $order );
        $this->set( "order_type", $order_type );
        $this->set( "total_pages", $total_pages );
        $this->set( "links", $links );
        $this->set( "current_page", $current_page);
    }
}
