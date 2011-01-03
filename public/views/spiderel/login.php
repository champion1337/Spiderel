<h2>Login</h2>
<h3><?php if(isset($notice)) { echo $notice; } ?></h3>
<form action="index.php?url=spiderel/admin" method="post">
    User<input type="text" name="user" />
    Pass<input type="password" name="pass" />
    <input type="submit" name="submit" value="Login" />
</form>
