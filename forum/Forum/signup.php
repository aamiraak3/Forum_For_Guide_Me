<?php
//This page let users sign up
include('config.php');
?>
<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_signup.css" rel="stylesheet" title="Style" />
        <title>Guide Me Forum | Sign Up</title>
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
      <a class="navbar-brand" href="index.html">Guide Me</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/Project/index.html"></span>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Project/forum.html">Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Project/about.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Project/post.html">Popular Post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Project/signup.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Project/login.php">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Project/contact.html">Contact</a>
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
            <h1>Guide Me Forum</h1>
            <span class="subheading">Q & A | Reach Out People</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- /////////////////////////////////////// -->



    	<!-- <div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div> -->



<?php
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['avatar']) and $_POST['username']!='')
{
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['password'] = stripslashes($_POST['password']);
		$_POST['passverif'] = stripslashes($_POST['passverif']);
		$_POST['email'] = stripslashes($_POST['email']);
		$_POST['avatar'] = stripslashes($_POST['avatar']);
	}
	if($_POST['password']==$_POST['passverif'])
	{
		if(strlen($_POST['password'])>=6)
		{
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				$username = $_POST['username'];
				$password = (sha1($_POST['password']));
				$email = $_POST['email'];
				$avatar = $_POST['avatar'];
				$dn = $con->query('select id from users where username="'.$username.'"');
				if($dn->num_rows == 0)
				{
					$dn2 = $dn->num_rows;
					$id = $dn2+1;
					if($con->query('insert into users(id, username, password, email, avatar, signup_date) values ('.$id.', "'.$username.'", "'.$password.'", "'.$email.'", "'.$avatar.'", "'.time().'")'))
					{
						$form = false;
?>
						<div class="message">Signed Up Successfully. You can now Log in.<br />
						<a href="login.php">Log in</a></div>

						<?php header("Location:login.php?registered=true") ?>
<?php
					}
					else
					{
						$form = true;
						$message = 'An error occurred while signing you up.';
					}
				}
				else
				{
					$form = true;
					$message = 'this username has already taken, Please choose Another.';
				}
			}
			else
			{
				$form = true;
				$message = 'The email you typed is not valid.';
			}
		}
		else
		{
			$form = true;
			$message = 'Your password must have a minimum of 6 characters.';
		}
	}
	else
	{
		$form = true;
		$message = 'The passwords you entered are not identical.';
	}
}
else
{
	$form = true;
}
if($form)
{
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
?>
<div class="content">
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum Index</a> &gt; Sign Up
    </div>
	<div class="box_right">
    	<a href="signup.php">Sign Up</a>  |  <a href="login.php">Login</a>
    </div>
    <div class="clean"></div>
</div>
    <form action="signup.php" method="post">
        <h4>Please fill this form to Signup to Forum</h4><br />
        <div class="center">
            <label for="username">Username</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" required="true"/><br />
            <label for="password">Password<span class="small"><small><br>(6 characters min.)</small></span></label><input type="password" name="password" required="true"/><br />
            <label for="passverif">Password<span class="small"><small><br>(verification)</small</span></label><input  type="password" name="passverif" required="true" /><br />
            <label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" required="true"/><br />
            <label for="avatar">Avatar<span class="small"><small><br>(optional)</small></span></label><input type="text" name="avatar" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <input type="submit" value="Sign Up" />
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