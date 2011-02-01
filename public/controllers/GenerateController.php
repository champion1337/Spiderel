<?php
class GenerateController extends Controller
{
    function index()
    {
        $this->set( "host",  $_SERVER["HTTP_HOST"] );
        $this->set( "uri", $_SERVER["REQUEST_URI"] );
    }
}
