<h2>Spiderel - Index</h2>
<form action="index.php?url=spiderel/crawl" method="post">
Start url <input type="text" name="start" value="<?php echo $start; ?>" /><br />
Path to robots.txt <input type="text" name="robots" value="<?php echo $path_robots; ?>" /><br />
User Agent<input type="text" name="agent" value="<?php echo $agent; ?>" /><br />
Rules<br /> <textarea name="rules" rows="5" cols="100">
<?php echo $rules; ?>
</textarea><br />
<input type="checkbox" name="pagerank" value="yes" />Apply pagerank to scanned pages<br />
<input type="checkbox" name="cron" value="yes" />Save configuration for cron job<br />
<input type="checkbox" name="subdomains" value="yes" />Follow subdomains<br />

<input type="submit" value="Start" name="submit" />
</form>
