<?php
/******************************************************
------------------Required Configuration---------------
Database Connection and Configuration
******************************************************/

//log to the DataBase

$con = new MYSQLi('localhost', 'root', '', 'database_name');

// mysql_connect('localhost', 'root','');
// mysql_select_db('database_name');

//Username of the Administrator
$admin='a';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Forum Home Page
$url_home = 'index.php';

//Design Name
$design = 'default';


/******************************************************
----------------------Initialization-------------------
******************************************************/
include('init.php');


/******************************************************
----------------------Database Connection--------------
******************************************************/
$con = new MYSQLi("localhost", 'root','', 'database_name');



?>