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
