<h2>Valid URLs</h2>
<div style="text-align: center"><a href="index.php?url=report/invalid">Invalid URL's</a></div></br>
<div id="pagination">
<?php
for( $i = 1;$i <= $total_pages; $i++)
{
    if( $i != $current_page )
    {
        ?>
        <a href="index.php?url=report/index/<? echo $i;?>/<? echo $order; ?>/<? echo $order_type; ?>"><? echo $i; ?></a>
        <?
    }
    else { echo $i; }
}
?>
</div>


<div id="links">
    <ul>
    <li>
        <div class="title">
        <a href="index.php?url=report/index/1/title/<?
        if ($order_type == "DESC") echo "ASC";
        else echo "DESC";
        ?>">Title</a>
        </div>
        <div class="url">
            <a href="index.php?url=report/index/1/url/<?
            if( $order_type == "DESC") echo "ASC";
            else echo "DESC";
            ?>">URL</a>
        </div>
        <div class="pagerank">
            <a href="index.php?url=report/index/1/pagerank/<?
            if( $order_type == "DESC") echo "ASC";
            else echo "DESC";
            ?>">Pagerank</a>
        </div>
        <div class="type">
            <a href="index.php?url=report/index/1/type/<?
            if( $order_type == "DESC") echo "ASC";
            else echo "DESC";
            ?>">Type</a>
 
        </div>
    </li>
    <?php
    foreach( $links as $link )
    {
        ?>
    <li>
            <div class="title"><a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a></div>
            <div class="url"><?php echo $link['url']; ?></div>
            <div class="pagerank"><?php echo $link['pagerank']; ?></div>
            <div class="type"><?php echo $link['type'] ?></div>
    </li>
        <?
    }
    ?>
    </ul>
</div>

