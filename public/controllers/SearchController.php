<?php
class SearchController extends Controller
{
    function go() 
    {
        if( isset( $_POST['query'] ) )
        {
            $query = $_POST['query'];
        }
        if( isset( $_POST['type'] ) )
        {
            $type = $_POST['type'];
        }
        $search = new Search();
        $search->set_keywords( $query );
        $search->set_type( $type );
        $search->do_search();
        $results = $search->get_results();
        $this->set( 'results', $results );
    }

    function index()
    {
        
    }
}
