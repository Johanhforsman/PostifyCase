<?php 
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'postifycase');

class MySQL_connection {
	private $conn;

	function __construct() {
		$this->conn = New mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or 
					  die('There was a problem connecting to the database.');
	}

	function check_username_and_password($username, $password) {
		$query = "SELECT * 
				  FROM users 
				  WHERE Username = ? AND Password = ?";
		
		if($statement = $this->conn->prepare($query)) {
			$statement->bind_param('ss', $username, $password);
			$statement->execute();

			if($statement->fetch()) {
				$statement->close();
				return true;
			}
		}
	}

	function log_login($username) {
		$register_login = "INSERT INTO logins (Username, Login) 
						  VALUES('".$username."', NOW() )";
		$this->conn->query($register_login) or die (mysqli_error());
	}

	function display_login($username) {
		$query = "SELECT * 
				  FROM logins 
				  WHERE Username = '".$username."'
				  ORDER BY Login DESC
				  LIMIT 5";
		
		if($result = $this->conn->query($query)){
    		while($row = $result->fetch_assoc()) {
    			printf("</br>". $row['Login']);
    		}
		} else printf($this->conn->error);

	}

	function register_user($username, $password, $email) {
		$registerquery = "INSERT INTO users (Username, Password, EmailAddress) 
						  VALUES('".$username."', '".$password."', '".$email."')";
		$this->conn->query($registerquery) or die (mysqli_error());
		return true;
	}
}

?>