<?php
include 'dbc.php';




/******************* ACTIVATION BY FORM**************************/
if ($_POST)
{
$err = array();
$msg = array();

foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}
if(!isEmail($data['user_email'])) {
$err[] = "ERROR - Please enter a valid email";
}

$user_email = $data['user_email'];

//check if activ code and user is valid as precaution
$rs_check = mysql_query("select id from users where user_email='$user_email'") or die (mysql_error());
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated.
    if ( $num <= 0 ) {
	$err[] = "Error - Sorry no such account exists or registered.";
	//header("Location: forgot.php?msg=$msg");
	//exit();
	}


if(empty($err)) {

$new_pwd = GenPwd();
$pwd_reset = PwdHash($new_pwd);
//$sha1_new = sha1($new);
//set update sha1 of new password + salt
$rs_activ = mysql_query("update users set pwd='$pwd_reset' WHERE
						 user_email='$user_email'") or die(mysql_error());

$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);

//send email

$message =
"Here are your new password details ...\n
User Email: $user_email \n
Passwd: $new_pwd \n

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE.
***DO NOT RESPOND TO THIS EMAIL****
";
//print $message;
	mail($user_email, "Reset Password", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

$msg[] = "Your account password has been reset and a new password has been sent to your email address.";

//$msg = urlencode();
//header("Location: forgot.php?msg=$msg");
//exit();
 }
}
?>
<html>
<head>
<title>Forgot Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#actForm").validate();
  });
  </script>
 <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">

  <script src="js/vendor/custom.modernizr.js"></script>
</head>

<body>
<div class="row">
	<div class="panel">
Forgot Password

      <p>
        <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages
	  **************************************************************************/
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  /******************************* END ********************************/
	  ?>
      </p>
      <p>If you have forgot the account password, you can <strong>reset password</strong>
        and a new password will be sent to your email address.</p>

      <form action="forgot.php" method="post" name="actForm" id="actForm" >


						<div class="row">
							<div class="large-5 columns">
								<div class="row collapse">
									<div class="small-4 columns">

											<label class="inline">Your Email</label>

									</div>
									<div class="small-6 columns">
											 <input name="user_email" type="text" class="required email" id="txtboxn" size="25">
											
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="large-5 columns">
								<div class="row collapse">
									
									<div class="small-6 columns">
										 <input name="doReset" class="tiny button" type="submit" id="doLogin3" value="Reset">
											
									</div>
								</div>
							</div>
						</div>
           
         
                <p>
                 
                </p>
             
       
      </form>
</div>
</div>
</body>
</html>
