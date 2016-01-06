<?
include_once 'Connection.php';
class UserPersist
{ private $con=null;

	public function __construct()
	{
		$this->con = new Connect();
		$this->con = $this->con->dbhfn();
	}

	public function getUserByName($name)
	{
		$STH = $this->con->prepare("SELECT id FROM users WHERE user = :username");

		$vars = array(':username' => $name); 
		
		$STH->execute($vars);

		$row = $STH->fetchAll();
    		return $row;

	}

	public function getUserById($id)
	{
		$STH = $this->con->prepare("SELECT user FROM users WHERE id = :id");

		$vars = array(':id' => $id); 
		
		$STH->execute($vars);

		return $STH->fetch();
    		

	}

	public function save($user)
	{

		$STH = $this->con->prepare("INSERT INTO users(id, email, user, password) value (:id, :email, :user, :password)");
		$vars = array(':id' => $user->id, ':email' => $user->email,':user' => $user->user,
				 ':password' => $user->password );
 
	$STH->execute($vars);

	}

	public function verifyUser($email, $password)
	{
		$password = sha1($password);
		$STH = $this->con->prepare("SELECT id,email,user,password FROM users WHERE email = :email AND password = :password");
		$vars = array(':email' => $email,':password' => $password);
 
	$STH->execute($vars);

	return  $STH->fetch();
	



	}

	}
?>