<?php
class PDF
{
    private $content;
    private $text;
    function set_content( $content )
    {
        $this->content = $content;
    }

    function convert_to_text()
    {
        $input_file = ROOT . DS . "temp/temp.pdf";
        $output_file = ROOT . DS . "temp/temp.txt";
        file_put_contents( $input_file, $this->content);
        $output = `pdftotext $input_file $output_file`;
        echo $output;
        $this->text = file_get_contents( $output_file );
    }

    function get_text()
    {
        return $this->text;
    }
}
