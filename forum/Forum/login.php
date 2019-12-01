<?php
//This page let log in
include('config.php');
if(isset($_SESSION['username']))
{
	// echo "username is set";	
		unset($_SESSION['username'], $_SESSION['userid']);
	setcookie('username', '', time()-100);
	setcookie('password', '', time()-100);

?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Login</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
<div class="message">You have successfully been logged out.<br />
<a href="<?php echo $url_home; ?>">Home</a></div>
<?php
}
else
{
	if(isset($_POST['username'], $_POST['password']))
	{
		$username  = $_POST['username'];
		$password  = $_POST['password'];
		
		$req = $con->query('select password,id from users where username="'.$username.'"');
		$dn = $req->fetch_assoc();
		if($dn['password'] == sha1($password) and $req->num_rows > 0)
		{
			$form = false;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['id'];		
			if(isset($_POST['memorize']) and $_POST['memorize']=='yes')
			{
				$one_year = time()+(60*60*24*365);
				setcookie('username', $_POST['username'], $one_year);
				setcookie('password', sha1($password), $one_year);
			}
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Guide Me Forum | Login</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
<div class="message">You have successfully been logged in.<br />
<a href="<?php echo $url_home; ?>">Home</a></div>
<?php
		}
		else
		{
			$form = true;
			$message = 'The username or password you entered are not good.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Guide Me Forum | Login</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
	   <?php if(isset($_REQUEST["registered"])) { ?>
    <div>
    	<div class="message">Signed Up Successfully. You can now Log in.<br />
						<a href="login.php"></a></div>
    </div>
<?php } ?>
<?php
if(isset($message))
{
	echo '<div class="message">'.$message.'</div>';
}
?>
<div class="content">
<!-- <?php
$nb_new_pm = $con->query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"')->fetch_assoc();
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?> -->

<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; Login
    </div>

    <div class="box_right">
    	<a href="signup.php">Sign Up</a>  |  <a href="login.php">Login</a>
    </div>
    <div class="clean"></div>
	<!-- <!-- <div class="box_right">
		<?php print_r($_SESSION)  ?>
    	<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div> --> <s></s>
    <div class="clean"></div>
</div>
    <form action="login.php" method="post">
        <h4 style="text-align: center; border-bottom: 1px solid black;">Please Enter Your Login ID</h4><br />
        <div class="login">
            <label  for="username">Username</label><input type="text" name="username" id="username"/><br />
            <label for="password"style="margin-top: 4.5%;">Password  </label><input type="password" name="password" id="password" /><br />
            <small for="memorize">Remember me</small><input type="checkbox" name="memorize" id="memorize" value="yes" /><br />
            <input type="submit" value="Login"  />
		</div>
    </form>
</div>
<?php
	}
}
?>
	</body>
</html>