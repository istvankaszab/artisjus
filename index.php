<?
//ob_start();

//session_start();

require "config.php";


/*
$uri=$_SERVER['REQUEST_URI'];
$rest=substr($uri, 1);
$pos = strpos($rest, '/');

if(isset($_GET['inf'])) $inf= $_GET['inf']; else header('Location: '.$_SERVER['REQUEST_URI'].'?inf=musor-lista');
*/

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>ATV - Artisjus</title>
	<link rel="shortcut icon" type="image/png" href="images/favicon.png" />        

<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-custom.css" rel="stylesheet">

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/navbar.js"></script>
	<script src="js/atv-artisjus.js"></script>

        
</head>
<body>
<div class="container">



<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			</button>
			<a class="navbar-brand" href="index.php">ATV Artisjus</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Kezdőlap</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Import <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="adas-import.php">Adásnapló import</a></li>
					<li><a href="adas-import-xls.php">Adásnapló import XLS</a></li>
					<li><a href="#">Zene import</a></li>
				</ul>
				</li>
				<li><a href="musor-lista.php">Műsor lista</a></li>
				<li><a href="proba.php">Próba</a></li>
			</ul>            
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>
