<?
function connection()
{ 
	$host="localhost";
$dbname = "facebook";
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", "root", "password");
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
return $DBH;
} 

//redirecting to the searched person's page
if(isset($_POST['searchKey']))
{ try {
$DBH = connection();
//inserting data into the table using an array

$STH = $DBH->prepare("SELECT id FROM users WHERE user = :username");
	$var3 = array(':username' => $_POST['searchKey'] );

//$STH->setFetchMode(PDO::FETCH_OBJ);
//$STH->execute((array)$new_post);
 
$STH->execute($var3);

while($row3 = $STH->fetch())
{
  $suid = $row3['id'];
}
				
			 $GLOBALS['suid'] =  $row3["id"];
$host = $_SERVER["HTTP_HOST"];
			$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");	
$searchKey = NULL;
header("Location: http://$host$path/post_class.php");
 


}

catch(PDOException $e)
{
	echo $e->getMessage();
}

}
else
{$suid =  $_SESSION["userid"];
$username= $_SESSION["user"]; 

}
?>



