<?
class Connect
{
    protected $dbh;

    public function __construct()
    {
        try {
            $db_host = 'localhost';  //  hostname
            $db_name = 'facebook';  //  databasename
            $db_user = 'root';  //  username
            $user_pw = 'password';  //  password

            $this->dbh = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $user_pw);  
            $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->dbh->exec("SET CHARACTER SET utf8");  //  return all sql requests as UTF-8  
        }
        catch (PDOException $err) {  
            echo "harmless error message if the connection fails";
            $err->getMessage() . "<br/>";
            file_put_contents('PDOErrors.txt',$err, FILE_APPEND);  // write some details to an error-log outside public_html  
            $this->dbh = NULL;
    }
}

    public function dbhfn()
    {
        return $this->dbh;
    }
}
#   put database handler into a var for easier access
   
?>