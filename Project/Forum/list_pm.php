<!-- *************************************************************************
---------This page let display the list of personnal message of an user-------
************************************************************************** -->

<?php

include('config.php');
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo $design; ?>/style_signup.css" rel="stylesheet" title="Style" />
    <title>Guide Me Forum | Personal Messages</title>
    <!-- ///////////////////////////////////////////// -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <title>Guide Me | Home</title> -->

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
            <a class="nav-link" href="new_category.php">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="new_reply.php">Replies</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="list_pm.php">Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="new_pm.php">New Message</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="read_pm.php">Read Messages</a>
        </li>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="edit_message.php">Edit Message</a>
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
            <h1>Messages List</h1>
            <span class="subheading">PQ & A | Reach Out People</span>
        </div>
    </div>
</div>
</div>
</header>

<!-- /////////////////////////////////////// -->
   <div class="content">
    <?php
    if(isset($_SESSION['username']))
    {
        $nrows = $con->query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc')->num_rows;

        $req1 = $con->query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="no" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="no" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
        $nnrows = $con->query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc')->num_rows;
        $req2 = $con->query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, users.id as userid, users.username from pm as m1, pm as m2,users where ((m1.user1="'.$_SESSION['userid'].'" and m1.user1read="yes" and users.id=m1.user2) or (m1.user2="'.$_SESSION['userid'].'" and m1.user2read="yes" and users.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
        $nb_new_pm = $con->query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"')->fetch_assoc();
        $nb_new_pm = $nb_new_pm['nb_new_pm'];
        print_r($req1);
        ?>
        <div class="box">
           <div class="box_left">
               <a href="<?php echo $url_home; ?>">Forum Index</a> &gt; List of your Personal Messages
           </div>
           <div class="box_right">
               <a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> | <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
           </div>
           <div class="clean"></div>
       </div>
       This is the list of your personal messages:<br />
       <a href="new_pm.php" class="button">New Personal Message</a><br />
       <h3>Unread messages(<?php echo $nrows; ?>):</h3>

       <table class="list_pm">
           <tr>
               <th class="title_cell">Title</th>
               <th>Nb. Replies</th>
               <th>Participant</th>
               <th>Date Sent</th>
           </tr>
           <?php
           while($dn1 = $req1->fetch_assoc())
           {
            ?>
            <tr>
               <td class="left"><a href="read_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
               <td><?php echo $dn1['reps']-1; ?></td>
               <td><a href="profile.php?id=<?php echo $dn1['userid']; ?>"><?php echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
               <td><?php echo date('d/m/Y H:i:s' ,$dn1['timestamp']); ?></td>
           </tr>
           <?php
       }
       if(($req1)->num_rows == 0)
       {
        ?>
        <tr>
           <td colspan="4" class="center">You have no unread message.</td>
       </tr>
       <?php
   }
   ?>
</table>
<br />
<h3>Read messages(<?php echo $nnrows; ?>):</h3>
<table class="list_pm">
	<tr>
       <th class="title_cell">Title</th>
       <th>Nb. Rreplies</th>
       <th>Participant</th>
       <th>Date Sent</th>
   </tr>
   <?php
   while($dn2 = ($req2->fetch_assoc()))
   {
    ?>
    <tr>
    	<td class="left"><a href="read_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn2['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo htmlentities($dn2['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('d/m/Y H:i:s' ,$dn2['timestamp']); ?></td>
    </tr>
    <?php
}
if(($req2 ->num_rows)==0)
{
    ?>
    <tr>
    	<td colspan="4" class="center">You have no read message.</td>
    </tr>
    <?php
}
?>
</table>
<?php
}
else

{
    ?>
    <h2>You must be logged to access this page:</h2>
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
<script src="/Project/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="/Project/Static/js/jqBootstrapValidation.js"></script>
<script src="/Project/Static/js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="/Project/Static/js/clean-blog.min.js"></script>
<!-- //////////////////////////////////////////////////// -->
</body>
</html>