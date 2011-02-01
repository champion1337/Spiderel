<h2>Generate AJAX code for easy integration</h2>
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
</div>
<div id="results"></div>
';
    echo htmlentities( $code );
?>
</textarea></br>
A-Z index code</br>
<textarea>
<?php

$code = '
  <a href="#" class="letter">A</a>
  <a href="#" class="letter">B</a>
  <a href="#" class="letter">C</a>
  <a href="#" class="letter">D</a>
  <a href="#" class="letter">E</a>

  <a href="#" class="letter">F</a>
  <a href="#" class="letter">G</a>
  <a href="#" class="letter">H</a>
  <a href="#" class="letter">I</a>
  <a href="#" class="letter">J</a>
  <a href="#" class="letter">K</a>

  <a href="#" class="letter">L</a>
  <a href="#" class="letter">M</a>
  <a href="#" class="letter">N</a>
  <a href="#" class="letter">O</a>
  <a href="#" class="letter">P</a>
  <a href="#" class="letter">Q</a>

  <a href="#" class="letter">R</a>
  <a href="#" class="letter">S</a>
  <a href="#" class="letter">T</a>
  <a href="#" class="letter">U</a>
  <a href="#" class="letter">V</a>
  <a href="#" class="letter">W</a>

  <a href="#" class="letter">X</a>
  <a href="#" class="letter">Y</a>
  <a href="#" class="letter">Z</a>


<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
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
    </script>
    <div id="results"></div>
    ';
    echo htmlentities( $code );
    ?>
    </textarea>

