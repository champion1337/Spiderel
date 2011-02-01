<h2>Search indexed links</h2>
<form action="index.php?url=search/go" method="post">
<input type="text" name="query"><br>
<input type="submit" name="submit" value="cauta">
</form>
<div id="search">
<ul>
<?php
foreach ( $results as $result ) 
{
?>
<li>
    <div class="title">
        <a href="<? echo $result['url']; ?>"><? echo $result['title'];?></a> 
    </div>
    <div class="excerpt"><? echo $result['excerpt']; ?></div>
    <div class="url"><? echo $result['url']; ?></div>
</li>
<?php
} ?>
</ul>
</div>
