<?php

require_once 'functions.php';

?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
    <title>PostifyCase (Johan Forsman)</title>  
    <link rel="stylesheet" href="style.css" type="text/css" />  
</head>  

<body>  
<div id="main">   

		<?php
		$mysqli = New MySQL_connection();

		// Check if the user has submitted information in the fields, then proceed to check if the username already
		// exists, if not, create a new user in database.
		if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){

			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$email = $_POST['email'];

			$username_exist = $mysqli->check_username_and_password($username, $password);	

			if($username_exist) {
				 $result = "Username already exists";
			} 
			else {
				$register = $mysqli->register_user($username, $password, $email);
				if($register){
					$result = "You have been registered!" . "<meta http-equiv='refresh' content='1;index.php' />";;
				}
			}

		}
		?>
       <h1>Register</h1>  
       <p>Please enter your details below to register.</p>  
        <form method="post" action="register.php" name="registerform" id="registerform">  
        <fieldset>  
            <label for="username">Username:</label><input type="text" name="username" id="username" /><br />  
            <label for="password">Password:</label><input type="password" name="password" id="password" /><br />  
            <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />  
            <input type="submit" name="register" id="register" value="Register" />  
        </fieldset>  
        </form>
        <?php if(isset($result)) echo "<h4 class='alert'>" . $result . "</h4>"; ?>
</div>  
</body>  
</html> 