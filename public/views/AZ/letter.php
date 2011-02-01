<?php
foreach ($alphabet as $letter)
{
?>
    <a href="index.php?url=AZ/letter&letter=<?php echo $letter; ?>"><?php echo $letter; ?></a>
<?
}
?>
<h2><?php echo $c_letter; ?></h2>
<?php
foreach($urls as $url)
{
?>
    <a href="<?php echo $url['url']; ?>">
        <?php echo $url['title']; ?>
    </a>
    </br>
<?
}
