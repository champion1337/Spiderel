<h2><?php echo $letter; ?></h2>
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
