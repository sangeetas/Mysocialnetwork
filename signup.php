<?
session_start();
include 'Users.php';
include 'UserPersist.php';

if(!isset( $_POST['username'], $_POST['password'], $_POST['email']))
{
    $message = 'Please enter a valid email, username and password';
}

/*** check the username is the correct length ***/
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
    $message = 'Incorrect Length for Password';
}

elseif (strlen( $_POST['email']) > 40 || strlen($_POST['email']) < 4)
{
    $message = 'Incorrect Length for email';
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);




    try
    {
    	$newuser = new Users(NULL, $email, $username, $password);
    $up = new UserPersist();
    $up->save($newuser);
    $message = "Signup successful!";
    }
    catch(Exception $e)
    {
        /*** check if the username already exists ***/
        //echo $e->getMessage();
        
        if( $e->getCode() == 23000)
        {
            $message = 'Email already exists';
        }
        else
        {
            /*** if we are here, something has gone wrong with the database ***/
           $message = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>

<html>
<head></head>
<body>
<form action = "<?= $_SERVER["PHP_SELF"] ?>" method="post">
	<table>
<h3>Provide the following details</h3>
<tr>
	<td>Username:</td>
<td><input name = "username" type="text"/></td>
</tr>
<tr>
<td>Email:</td>
<td><input name = "email" type="email"/></td>
</tr>
<tr>
<td>Password:</td>
<td><input name = "password" type="password"/></td>
</tr>
<td><input value="Sign up" type="submit"></input></td>
<p><?php echo $message; ?>
	<tr>
	<td><a href = "index.html">Login</a></td>
</tr>
</table>
</body>
</form>
</html>
