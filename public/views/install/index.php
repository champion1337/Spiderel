<h2>Spiderel - New Install</h2>
<h3><?php if(isset($notice)) { echo $notice; }  ?></h3>
Please remove the install.lock file if you ran the install process before
<form action="index.php?url=install/mysql" method="post">
Host<input type="text" name="host" /><br/>
User<input type="text" name="user" /><br />
Password<input type="password" name="pass" /></br>
Database<input type="text" name="database" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
