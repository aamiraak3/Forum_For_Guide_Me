<!-- *************************************************************************
----------------------This page display a personnal message-------------------
************************************************************************** -->

<?php
include('config.php');
?>
<!DOCTYPE>
<html>
<!-- <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
    <title>Read a PM</title>
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


   <!-- <div class="header">
       <a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
   </div> -->
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
               $nrows = $con->query('select pm.timestamp, pm.message, users.id as userid, users.username, users.avatar from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2')->num_rows;
               $req2 = $con->query('select pm.timestamp, pm.message, users.id as userid, users.username, users.avatar from pm, users where pm.id="'.$id.'" and users.id=pm.user1 order by pm.id2')->fetch_assoc();
               if(isset($_POST['message']) and $_POST['message']!='')
               {
                   $message = $_POST['message'];
                   if(get_magic_quotes_gpc())
                   {
                      $message = stripslashes($message);
                  }
                  $message = (nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
                  if($con->query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "'.( $req2 ->nrows + 1).'", "", "'.$_SESSION['userid'].'", "", "'.$message.'", "'.time().'", "", "")') ->fetch_assoc() and $con->query('update pm set user'.$user_partic.'read="yes" where id="'.$id.'" and id2="1"')->fetch_assoc())
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