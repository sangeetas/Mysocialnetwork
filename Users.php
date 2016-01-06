<?
class Users{
	public $id;
	public $email;
	public $user;
	public $password;

	public function __construct($id,$email,$user,$password)
	{
	$this->id  = $id;
	$this->email  = $email;
	$this->user = $user;
	$this->password =  sha1($password );
	}
} 
?>