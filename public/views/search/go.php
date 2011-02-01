<h2>Search indexed links</h2>
<form action="index.php?url=search/go" method="post">
<input type="text" name="query"><br>
<input type="submit" name="submit" value="cauta">
</form>
<?php
foreach ( $results as $result ) 
{
?>
<div>
<? echo $result['url']; ?> &nbsp;
<a href="<? echo $result['url']; ?>"><? echo $result['title'];?></a> - 
<? echo $result['pagerank'];?>
</br>
</div>
<?php
} ?>
