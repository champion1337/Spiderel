
Ajax search code </br>
<textarea>
<?php $code ='<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <script>
    $(document).ready(function() {
        $( "#go" ).bind(("click", function() {
            dosearch();
        });
    });

    function dosearch() {
        sdata = "query=" + $( "#search" ).val();;
        $.ajax({
            type: "POST",
            url: "http://'. $host  . $uri . '?url=search/go.xml",
            data: sdata,
            success: function(msg){
                $( "#results" ).replaceWith( msg );
            }});}
    </script>
<div class="search">
    <input type="text" name="search" id="search">
    <input type="button" name="go" id="go" value="search">
</div>';
    echo htmlentities( $code );
?>
</textarea></br>
A-Z index code</br>
<textarea>
<?php

$code = '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script>
    $(document).ready(function() {
        $( ".letter" ).click(function() {
            letter = $( this ).html();
            call_az(letter);
        });
    });
    function call_az(letter)
    {
        var az_url ="http://' . $host . $uri .'?url=AZ/letter.xml&letter=" + letter;
        $.ajax({
            type: "GET",
            url: az_url,
            success: function(msg){
                $( "#results" ).replaceWith( msg );
            }
        });
    }
    </script>';
    echo htmlentities( $code );
    ?>
    </textarea>

