<?php
//This page display a personnal message
include('config.php');
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Read a PM</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
<?php
if(isset($_SESSION['username']))
{
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
$req1 = $con->query('select title, user1, user2 from pm where id="'.$id.'" and id2="1"')->fetch_assoc();
$dn1 = ($req1)->fetch_assoc();
if(($req1)->num_rows ==1)
{
if($dn1['user1']==$_SESSION['userid'] or $dn1['user2']==$_SESSION['userid'])
{
if($dn1['user1']==$_SESSION['userid'])
{
	$con->query('update pm set user1read="yes" where id="'.$id.'" and id2="1"')->fetch_assoc();
	$user_partic = 2;
}
else
{
	$con->query('update pm set user2read="yes" where id="'.$id.'" and id2="1"')->fetch_assoc();
	$user_partic = 1;
}
$req2 = $con->query('select pm.timestamp, pm.message, users.id as userid, users.username, users.avatar from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2')->fetch_assoc();
if(isset($_POST['message']) and $_POST['message']!='')
{
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	$message = mysql_real_escape_string(nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
	if($con->query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.(intval(mysql_num_rows($req2))+1).'", "", "'.$_SESSION['userid'].'", "", "'.$message.'", "'.time().'", "", "")') ->fetch_assoc() and $con->query('update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"'))
     // ->fetch_assoc()
	{
?>
<div class="message">Your reply has successfully been sent.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Go to the PM</a></div>
<?php
	}
	else
	{
?>
<div class="message">An error occurred while sending the reply.<br />
<a href="read_pm.php?id=<?php echo $id; ?>">Go to the PM</a></div>
<?php
	}
}
else
{
?>
<div class="content">
<?php
if(isset($_SESSION['username']))
{
$nb_new_pm = $con->query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"')->fetch_assoc();
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; <a href="list_pm.php">List of your PMs</a> &gt; Read a PM
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
}
else
{
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; <a href="list_pm.php">List of your PMs</a> &gt; Read a PM
    </div>
	<div class="box_right">
    	<a href="signup.php">Sign Up</a> - <a href="login.php">Login</a>
    </div>
    <div class="clean"></div>
</div>
<?php
}
?>
<h1><?php echo $dn1['title']; ?></h1>
<table class="messages_table">
	<tr>
    	<th class="author">User</th>
        <th>Message</th>
    </tr>
<?php
while($dn2 = ($req2)->fetch_assoc())
{
?>
	<tr>
    	<td class="author center"><?php
if($dn2['avatar']!='')
{
	echo '<img src="'.htmlentities($dn2['avatar']).'" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
}
?><br /><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo $dn2['username']; ?></a></td>
    	<td class="left"><div class="date">Date sent: <?php echo date('Y/m/d H:i:s' ,$dn2['timestamp']); ?></div>
    	<?php echo $dn2['message']; ?></td>
    </tr>
<?php
}
?>
</table><br />
<h2>Reply</h2>
<div class="center">
    <form action="read_pm.php?id=<?php echo $id; ?>" method="post">
    	<label for="message" class="center">Message</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
</div>
<?php
}
}
else
{
	echo '<div class="message">You don\'t have the right to access this page.</div>';
}
}
else
{
	echo '<div class="message">This message doesn\'t exist.</div>';
}
}
else
{
	echo '<div class="message">The ID of this message is not defined.</div>';
}
}
else
{
?>
<div class="message">You must be logged to access this page.</div>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Username</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Remember</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
?>
	</body>
</html>