/Static<!-- *************************************************************************
-----------------------This page let delete a topic---------------------------
************************************************************************** -->

<?php
include('config.php');
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
if(isset($_SESSION['username']))
{
	$dn1 = $con->query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id')->fetch_assoc();
if($dn1['nb1']>0)
{
if($_SESSION['username']==$admin)
{
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $design; ?>/style_signup.css" rel="stylesheet" title="Style" />
    <title>Guide Me Forum | Login</title>
    <!-- ///////////////////////////////////////////// -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="/Project/Static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/Project/Static/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="/Project/Static/css/clean-blog.min.css" rel="stylesheet">
    <!-- ///////////////////////////////////////////// -->
</head>

<body>
<!-- /////////////////////////////////////// -->
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="index.php">Guide Me Forum</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php"></span>Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="read_topic.php">Topics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Replies</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="users.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="signup.php">Register</a>
        </li>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Log In</a>
        </li>
    </ul>
</div>
</div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url('/Project/Static/img/forum-bg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Login</h1>
            <span class="subheading">Q & A | Reach Out People</span>
        </div>
    </div>
</div>
</div>
</header>

<!-- /////////////////////////////////////// -->
        <div class="content">
<?php
$nb_new_pm = $con->query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"')->fetch_assoc();
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Delete the topic
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['confirm']))
{
	if($con->query('delete from topics where id="'.$id.'"'))
	{
	?>
	<div class="message">The topic have successfully been deleted.<br />
	<a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>">Go to "<?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?>"</a></div>
	<?php
	}
	else
	{
		echo 'An error occured while deleting the topic.';
	}
}
else
{
?>
<form action="delete_topic.php?id=<?php echo $id; ?>" method="post">
	Are you sure you want to delete this topic?
    <input type="hidden" name="confirm" value="true" />
    <input type="submit" value="Yes" /> <input type="button" value="No" onclick="javascript:history.go(-1);" />
</form>
<?php
}
?>
		</div>

<!-- ///////////////////////////////////////// -->
<!-- Footer -->
<footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <ul class="list-inline text-center">
            <li class="list-inline-item">
              <a href="https://twitter.com/">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
              </span>
          </a>
      </li>
      <li class="list-inline-item">
          <a href="https://www.facebook.com/">
            <span class="fa-stack fa-lg">
              <i class="fas fa-circle fa-stack-2x"></i>
              <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
          </span>
      </a>
  </li>
  <li class="list-inline-item">
      <a href="https://github.com/">
        <span class="fa-stack fa-lg">
          <i class="fas fa-circle fa-stack-2x"></i>
          <i class="fab fa-github fa-stack-1x fa-inverse"></i>
      </span>
  </a>
</li>
</ul>
<p class="copyright text-muted">Copyright &copy;2019- All Rights Reserved</p>
</div>
</div>
</div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/Project/Static/vendor/jquery/jquery.min.js"></script>
<script src="/Project/Static/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="/Project/Static/js/jqBootstrapValidation.js"></script>
<script src="/Project/Static/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="/Project/Static/js/clean-blog.min.js"></script>

<!-- //////////////////////////////////////////////////// -->
</body>
</html>
<?php
}
else
{
	echo '<h2>You don\'t have the right to delete this topic.</h2>';
}
}
else
{
	echo '<h2>The topic you want to delete doesn\'t exist.</h2>';
}
}
else
{
	echo '<h2>You must be logged as an administrator to access this page: <a href="login.php">Login</a> - <a href="signup.php">Sign Up</a></h2>';
}
}
else
{
	echo '<h2>The ID of the topic you want to delete is not defined.</h2>';
}
?>