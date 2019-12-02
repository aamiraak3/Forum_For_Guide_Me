<!-- *************************************************************************
-----------------This page let create a new personnal message-----------------
************************************************************************** -->

<?php
include('config.php');
?>
<!DOCTYPE>
<html>
<!-- <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
	<title>New PM</title>
</head> -->


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $design; ?>/style_signup.css" rel="stylesheet" title="Style" />
    <title>Guide Me Forum | Login</title>
    <!-- ///////////////////////////////////////////// -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>Guide Me | Home</title> -->

    <!-- Bootstrap core CSS -->
    <link href="/Project/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="/Project/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="/Project/css/clean-blog.min.css" rel="stylesheet">
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
<header class="masthead" style="background-image: url('/Project/img/forum-bg.png')">
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






<!-- 	<div class="header">
		<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	</div> -->
	<?php
	if(isset($_SESSION['username']))
	{
		$form = true;
		$otitle = '';
		$orecip = '';
		$omessage = '';
		if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
		{
			$otitle = $_POST['title'];
			$orecip = $_POST['recip'];
			$omessage = $_POST['message'];
			if(get_magic_quotes_gpc())
			{
				$otitle = stripslashes($otitle);
				$orecip = stripslashes($orecip);
				$omessage = stripslashes($omessage);
			}
			if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
			{
				$title = ($otitle);
				$recip = ($orecip);
				$message = $omessage;
				$dn1 = $con->query('select count(id) as recip, id as recipid, (select count(*) from pm) as npm from users where username="'.$recip.'"')->fetch_assoc();
				print_r($dn1);
				if($dn1['recip']==1)
				{
					echo "yo";
					echo $_SESSION['userid'];
					if($dn1['recipid'] != $_SESSION['userid'])
					{
						echo "hey";
						$id = $dn1['npm']+1;
						echo "insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values(".$id.", 1	, '".$title."', ".$_SESSION['userid'].", ".$dn1['recipid'].", '".$message."',  ".time().", 'yes', 'no')";
						if($con->query("insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values(".$id.", 1	, '".$title."', ".$_SESSION['userid'].", ".$dn1['recipid'].", '".$message."',  ".time().", 'yes', 'no')"))
						{
							?>
							<div class="message">The PM have successfully been sent.<br />
								<a href="list_pm.php">List of your Personal Messages</a></div>
								<?php
								$form = false;
							}
							else
							{
								$error = 'An error occurred while sending the PM.';
							}
						}
						else
						{
							$error = 'You cannot send a PM to yourself.';
						}
					}
					else
					{
						$error = 'The recipient of your PM doesn\'t exist.';
					}
				}
				else
				{
					$error = 'A field is not filled.';
				}
			}
			elseif(isset($_GET['recip']))
			{
				$orecip = $_GET['recip'];
			}
			if($form)
			{
				if(isset($error))
				{
					echo '<div class="message">'.$error.'</div>';
				}
				?>
				<div class="content">
					<?php
					$nb_new_pm = $con->query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"')->fetch_assoc();
					$nb_new_pm = $nb_new_pm['nb_new_pm'];
					?>
					<div class="box">
						<div class="box_left">
							<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; <a href="list_pm.php">List of you PMs</a> &gt; New PM
						</div>
						<div class="box_right">
							<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
						</div>
						<div class="clean"></div>
					</div>
					<h1>New Personal Message</h1><br />
					<form action="new_pm.php" method="post">
						<h4>Please fill the following to send a PM:</h4><br />
						<label for="title" style=" margin-bottom: 2%; margin-top: 2%;">Subject</label><input type="text" placeholder="Subject" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" style="transform: scale(1.3); margin-left: 2.5%; margin-bottom: 2%; margin-top: 2%;" /><br  />
						<label for="recip" style="margin-bottom: 2%;">Recipient<span class="small">(Username)</span></label><input type="text" placeholder="Username" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" style="transform: scale(1.3); margin-bottom: 2%;margin-left: 2.5%;"/><br />
						<label for="message">Message</label><textarea cols="35" rows="7" id="message" placeholder="type your message here" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
						<input type="submit" value="Send Message" />
					</form>
				</div>
				<?php
			}
		}
		else
		{
			?>
			<div class="message">You must be logged to access this page</div>
			<div class="box_login">
				<form action="login.php" method="post">
					<label for="username">Username</label><input type="text" name="username" id="username" /><br />
					<label for="password">Password</label><input type="password" name="password" id="password" /><br />
					<div class="center">
						<input type="submit" value="Login" /> 
					</div>
				</form>
			</div>
			<?php
		}
		?>

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
<script src="/Project/vendor/jquery/jquery.min.js"></script>
<script src="/Project/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="/Project/js/jqBootstrapValidation.js"></script>
<script src="/Project/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="/Project/js/clean-blog.min.js"></script>

<!-- //////////////////////////////////////////////////// -->



	</body>
	</html>