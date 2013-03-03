<?php

require_once 'functions.php';
$mysqli = New MySQL_connection();

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
			
			// Check if the user is already logged in. We use the global array $_SESSION to check if BOTH of these 
			// contains value. If they are, proceed to member page.
			if( !empty($_SESSION['LoggedIn']) )
			{
				 ?>
			    
			    <h1>Member Area</h1>
			  	<p>Thanks for logging in <b><?=$_SESSION['Username']?></b>!</p>
			    <p><b>Your 5 latest logins are:</b></p>
			    <p><?php $mysqli->display_login($_SESSION['Username']); ?></p>

			    <p id="logout"><a href="logout.php">Logout</a></p>

			    <?php
			}

			// Check with $_POST if the user has typed in username and password in the form. If that is true proceed to 
			// check if it is in the database.
			elseif(!empty($_POST['username']) && !empty($_POST['password']))
			{
				$username = $_POST['username'];
				$password = md5($_POST['password']);

				$check_user = $mysqli->check_username_and_password($username, $password);	

				if($check_user) {
					$mysqli->log_login($username);
					$_SESSION['LoggedIn'] = 1;
					$_SESSION['Username'] = $username;
					echo "<h1>Success</h1>";
        			echo "<p>We are now redirecting you to the member area.</p>";
        			echo "<meta http-equiv='refresh' content='1' />";
				} 
				else {
					echo "<h1>Error</h1>";
        			echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
				} 
			}

			//If neither of the above statements are true, display the login form.
			else
			{
				?>
			   <h1>Member Login</h1>
			    
			   <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
			    
				<form method="post" action="index.php" name="loginform" id="loginform">
				<fieldset>
					<label for="username">Username:</label><input type="text" name="username" id="username" /><br />
					<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
					<input type="submit" name="login" id="login" value="Login" />
				</fieldset>
				</form>
			   <?php
			}
		?>
	</div>
</body>
</html>