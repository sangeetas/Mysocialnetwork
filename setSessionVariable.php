<?
	session_start();
	$_SESSION['curruser'] = $_SESSION['userid'];
	$host = $_SERVER["HTTP_HOST"];
	$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");	
	//header("Location: http://$host$path/post_class.php");


?>