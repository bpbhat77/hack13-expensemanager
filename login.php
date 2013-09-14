<?php
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
include 'dbc.php';
error_reporting(0);

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}

if ($_POST)
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";

}


$result = mysql_query("SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE
           $user_cond
			AND `banned` = '0'
			") or die (mysql_error());
$num = mysql_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated.
    if ( $num > 0 ) {

	list($id,$pwd,$full_name,$approved,$user_level) = mysql_fetch_row($result);

	if(!$approved) {
	//$msg = urlencode("Account not activated. Please check your email for activation code");
	$err[] = "Account not activated. Please check your email for activation code";

	//header("Location: login.php?msg=$msg");
	 //exit();
	 }

		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) {
	if(empty($err)){

     // this sets session and logs user in
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session
		$_SESSION['user_id']= $id;
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());

		//set a cookie

	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: myaccount.php");
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }
}



?>
<html>
<head>
<title>Members Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">

  <script src="js/vendor/custom.modernizr.js"></script>
</head>

<body>
<div class="row">
	
	<div class="panel">
Login Users

	  <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages
	  **************************************************************************/
	  if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";
	   }
	  /******************************* END ********************************/
	  ?></p>



      <form data-abide class="custom" action="login.php" method="post" name="logForm" id="logForm" >
	  
	  
	  
						<div class="row">
							<div class="large-5 columns">
								<div class="row collapse">
									<div class="small-4 columns">

											<label class="inline">  Username / Email</label>

									</div>
									<div class="small-6 columns">
											<input name="usr_email" type="email" required id="txtbox" size="15">
											
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="large-5 columns">
								<div class="row collapse">
									<div class="small-4 columns">

											<label class="inline">Password</label>

									</div>
									<div class="small-6 columns">
											<input name="pwd" type="password" class="required password" id="txtbox" size="25">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
      
							<div class="large-5 columns">
									<div class="row collapse">
										<div class="small-4 columns">
											<label for="right-label" class="left ">Remember me</label>
										</div>
										<div class="small-4  inline pull-1 columns">
											<div class="switch tiny round">
													  <input id="remember" value="true" name="remember" type="radio" checked="">
													  <label for="Remember1" onclick="">Yes</label>

													  <input id="remember" value="false" name="remember" type="radio">
													  <label for="Remember2" onclick="">No</label>

													<span></span>
												</div>
										</div>


									</div>
								</div>
							</div>
							<div class="row">
								<div class="large-5 columns">
									<div class="row collapse">
										
										<div class="small-3 columns">
												 <input name="doLogin" type="submit" class="tiny button" id="doLogin3" value="Login">
										</div>
										<div class="small-5 columns">
												 <label class="inline"><a href="forgot.php">Login with socially</a> <font color="#FF6600"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="large-5 columns">
									<div class="row collapse">
										<div class="small-4 columns">

												<label class="inline"><a href="register.php">Register</a><font color="#FF6600"></label>

										</div>
										<div class="small-7 columns">
												<label class="inline"><a href="forgot.php">Register with socially</a> <font color="#FF6600"></label>
										</div>
										<div class="small-4 columns">
												<label class="inline"><a href="forgot.php">Forgot Password</a> <font color="#FF6600"></label>
										</div>
										
									</div>
								</div>
							</div>
                 
               
                
      </form>
 
    </div>
  </div>
</body>
</html>