<h2>A connection to the database has been successful and tables have been imported</h2>
<h3><?php if(isset($notice))  { echo $notice; } ?></h3>
<form action="index.php?url=install/check_robots" method="post">
Path to robots.txt<input type="text" name="path" />Example: /var/www/robots.txt <br />
<input type="checkbox" name="skip" value="yes" />Add a path to robots.txt later<br />
<input type="submit" type="submit" value="Next" />
</form>
