<?
session_start();
$user_id;
$user;
include 'Myconstants.php';
include 'UserPersist.php';

//if username and password submitted, check them
if(isset($_POST['email']) && isset($_POST['pass']))
{ //$user = print $_POST['user'];

//sanity checks
if (strlen( $_POST['email']) > 40 || strlen($_POST['email']) < 4)
{
    $message = 'Incorrect Length for Username';
}
else if (strlen( $_POST['pass']) > 40 || strlen($_POST['pass']) < 4)
{
    $message = 'Incorrect Length for password';
}

else
{
		/*** if we are here the data is valid and we can insert it into database ***/
   // $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    //$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

		$up = new UserPersist();
		$ans = $up->verifyUser($_POST['email'],$_POST['pass']);
	//check whether we found a row
	if($ans)
	{
		Myconstants::setValue($ans["id"]);
		
			//remember that the user is logged in
			$_SESSION["authenticated"] = true;
			 $suid =  $ans["id"];
			 $_SESSION["userid"] = $suid;
			 $_SESSION["curruser"] = $suid;
			 
			 $_SESSION["user"] = $ans["user"];;
			//$_SESSION["name"] = print $user;
			//redirect user to home page, using absolute path
			$host = $_SERVER["HTTP_HOST"];
			$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
			header("Location: http://$host$path/post_class.php");
			//header("Location: http://localhost/~sangeetasingh/login/home.php");
			exit;

		}
		else
			echo "no such user";


	}
}
?>
<!--
<!DOCTYPE html>
<html>
<head></head>
<body>
<form action = "<?=// $_SERVER["PHP_SELF"] ?>" method="post">
	<table>
<tr>
<td>Username:</td>
<td>
<input name="email" type="email">
</td>
</tr>
<tr>
	<td>Password:</td>
<td>
<input name = "pass" type="password">
</td>
</tr>
<p><?//php echo $message; ?>
<td></td>
<td><input type="submit" value="Log In"></td>
<tr>
<td><a href = "signup.php"</a>New User?</td>
</tr>
	</table>
</form>
</body>
</html> -->
