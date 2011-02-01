<?php
class SearchController extends Controller
{
    function go() 
    {
        if( isset( $_POST['query'] ) )
        {
            $query = $_POST['query'];
        }
        $search = new Search();
        $search->set_keywords( $query );
        $search->do_search();
        $results = $search->get_results();
        $keywords = explode( " ", $query );
        $keyword = $keywords[0];
        foreach ($results as &$row) 
        {//do the following for each result:
            $text = $row["content"];//we're only interested in the content at the moment
            $text=substr ($text, strrpos($text, $keyword)-90, 180); //cut out
            $text=str_replace($keyword, '<strong>'.$keyword.'</strong>', $text); //highlight
            $row['excerpt'] = $text;
        }

        $this->set( 'results', $results );
    }

    function index()
    {
        
    }
}
