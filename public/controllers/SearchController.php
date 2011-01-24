<?php
class SearchController extends Controller
{
    function go() 
    {
        if( isset( $_POST['query'] ) )
        {
            $query = $_POST['query'];
        }
        $search = new Search( $query );
        $results = $search->get_results();
        $this->set( 'results', $results );
    }

    function index()
    {
        
    }
}
