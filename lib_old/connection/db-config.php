<?php

//$con=mysqli_connect("localhost","aptsolutions","godaddy@2019");
// mysqli_select_db("salary_demo",$con)
//or die("Could not connect Salary");
//$con = mysqli_connect('localhost','aptsolutions','godaddy@2020','dbsalary');

$con = mysqli_connect('localhost','aptsolutions','godaddy@2020','ghare');
if(!$con){
    die('Could not connect: '.mysql_error());
}

class DbConfig 
{    
    private $_host = 'localhost';
    private $_username = 'aptsolutions';
    private $_password = 'godaddy@2020';
//    private $_database = 'dbsalary';
      private $_database = 'ghare';
    
    protected $connection;
    
    public function __construct()
    {
        if (!isset($this->connection)) {
            
            $this->connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
            
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        //echo $this->_database;
        return $this->connection;
    }
}

/*class db {
	private $conn;
	private $host;
	private $user;
	private $password;
	private $baseName;
	private $port;
	private $Debug;
	
	function __construct($params=array()) {
		$this->conn = false;
		$this->host = 'localhost'; //hostname
		$this->user = 'testdemo1'; //username
		$this->password = 'testdemo1'; //password
		$this->baseName = 'testdemo1'; //name of your database
		$this->port = '3306';
		$this->debug = true;
		$this->connect();
	}
 
	function __destruct() {
		$this->disconnect();
	}
	
	function connect() {
		if (!$this->conn) {
			$this->conn = mysql_connect($this->host, $this->user, $this->password);	
			mysql_select_db($this->baseName, $this->conn); 
			mysql_set_charset('utf8',$this->conn);
			
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection BDD failed';
				die();
			} 
			else {
				$this->status_fatal = false;
			}
		}
 
		return $this->conn;
	}
 
	function disconnect() {
		if ($this->conn) {
			@pg_close($this->conn);
		}
	}
	
	function getOne($query) { // getOne function: when you need to select only 1 line in the database
		$cnx = $this->conn;
		if (!$cnx || $this->status_fatal) {
			echo 'GetOne -> Connection BDD failed';
			die();
		}
 
		$cur = @mysql_query($query, $cnx);
 
		if ($cur == FALSE) {		
			$errorMessage = @pg_last_error($cnx);
			$this->handleError($query, $errorMessage);
		} 
		else {
			$this->Error=FALSE;
			$this->BadQuery="";
			$tmp = mysql_fetch_array($cur, MYSQL_ASSOC);
			
			$return = $tmp;
		}
 
		@mysql_free_result($cur);
		return $return;
	}
	
	function getAll($query) { // getAll function: when you need to select more than 1 line in the database
		$cnx = $this->conn;
		if (!$cnx || $this->status_fatal) {
			echo 'GetAll -> Connection BDD failed';
			die();
		}
		
		mysql_query("SET NAMES 'utf8'");
		$cur = mysql_query($query);
		$return = array();
		
		while($data = mysql_fetch_assoc($cur)) { 
			array_push($return, $data);
		} 
 
		return $return;
	}
	
	function execute($query,$use_slave=false) { // execute function: to use INSERT or UPDATE
		$cnx = $this->conn;
		if (!$cnx||$this->status_fatal) {
			return null;
		}
 
		$cur = @mysql_query($query, $cnx);
 
		if ($cur == FALSE) {
			$ErrorMessage = @mysql_last_error($cnx);
			$this->handleError($query, $ErrorMessage);
		}
		else {
			$this->Error=FALSE;
			$this->BadQuery="";
			$this->NumRows = mysql_affected_rows();
			return;
		}
		@mysql_free_result($cur);
	}
	
	function handleError($query, $str_erreur) {
		$this->Error = TRUE;
		$this->BadQuery = $query;
		if ($this->Debug) {
			echo "Query : ".$query."<br>";
			echo "Error : ".$str_erreur."<br>";
		}
	}
}
*/
?>
