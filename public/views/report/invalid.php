<h2>Invalid URLs</h2>
<div style="text-align:center"><a href="index.php?url=report">Valid URL's</a></div></br>
<div id="reports">
<div class="path">Path to URL</div>
<div clas="invalid">Error encountered</div>
<hr>
<?php
    foreach( $reports as $report )
    {

        ?>
        <div class="path"><?php echo $report['path']; ?></div>
        <div class="invalid"><?php echo $report['type']; ?></div>
        <?php
    }
?>
</div>
