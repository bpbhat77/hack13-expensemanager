<?php
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'dbc.php';
page_protect();
error_reporting(0);

$err = array();
$msg = array();

if($_POST)
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST)
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }

$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'");
?>
<html>
<head>
<title>My Account Settings</title>

<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
  });
  </script>

  <title>Welcome to </title>

  <!-- Included CSS Files -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">

  <script src="js/vendor/custom.modernizr.js"></script>
  </head>

<body>


<?php
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users.
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
<div class="row">
    <div class="large-12 columns">
		 <!-- Navigation -->

		<div class="row">
			<div class="large-12 columns">
			<nav class="top-bar">
				<ul class="title-area">
				  <!-- Title Area -->
				  <li class="name">

					  <a href="#">
						
					  </a>

				  </li>
				  
				  <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
				</ul>
         
			<section class="top-bar-section">
				  <!-- Right Nav Section -->
				<ul class="right">
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="myaccount.php">Profile</a>
						<ul class="dropdown">
							<li><a href="mysettings.php">Setting</a></li>
							
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
            </section>
          </nav>
          <!-- End Top Bar -->
        </div>
      </div>
	</div>
</div>
<!-- End Navigation -->


	
<div class="row"><!--main row -->
 
  
  
	<div class="large-12 columns">
		
		<div class="panel">
			<div class="row">

				<div class="large-4  columns">
					<h6>Edit your settings</h6>
				</div>
				
			</div>
		</div>
		<hr>
		<div class="panel">
			<div class="row">
<?php 
				
		 while ($row_settings = mysql_fetch_array($rs_settings)) {?>
		 
		 <form action="mysettings.php" method="post" name="myform" id="myform">
          Your Name  <input name="name" type="text" id="name"  class="required" value="<?php echo $row_settings['full_name']; ?>" size="50">
          Address (full address with ZIP)
              <textarea name="address" cols="40" rows="4" class="required" id="address"><?php echo $row_settings['address']; ?></textarea>
 
            Country
            <input name="country" type="text" id="country" value="<?php echo $row_settings['country']; ?>" >
         Phone<input name="tel" type="text" id="tel" class="required" value="<?php echo $row_settings['tel']; ?>">
         Fax<input name="fax" type="text" id="fax" value="<?php echo $row_settings['fax']; ?>">
         Website<input name="web" type="text" id="web" class="optional defaultInvalid url" value="<?php echo $row_settings['website']; ?>">
             
    
            User Name
            <input name="user_name" type="text" id="web2" value="<?php echo $row_settings['user_name']; ?>" disabled>
      Email<input name="user_email" type="text" id="web3"  value="<?php echo $row_settings['user_email']; ?>" disabled>

        <p align="center">
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
 <?php } ?>
 
 
 
 
 <h3 class="titlehdr">Change Password</h3>
      <p>If you want to change your password, please input your old and new password
        to make changes.</p>
      <form name="pform" id="pform" method="post" action="">
        Old Password
            <input name="pwd_old" type="password" class="required password"  id="pwd_old">
     New Password<input name="pwd_new" type="password" id="pwd_new" class="required password"  >
        <p align="center">
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
      </form>
 
 

				
			</div>
		</div>
		
		
	</div>
</div>

  <!-- Footer -->

  <footer class="row">
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-4 columns">
          <p>&copy; Copyright - Some Rights reserved </p>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/foundation.min.js"></script>


  <script src="js/foundation/foundation.js"></script>

  <script src="js/foundation/foundation.alerts.js"></script>

  <script src="js/foundation/foundation.clearing.js"></script>

  <script src="js/foundation/foundation.cookie.js"></script>

  <script src="js/foundation/foundation.dropdown.js"></script>

  <script src="js/foundation/foundation.forms.js"></script>

  <script src="js/foundation/foundation.joyride.js"></script>

  <script src="js/foundation/foundation.magellan.js"></script>

  <script src="js/foundation/foundation.orbit.js"></script>

  <script src="js/foundation/foundation.reveal.js"></script>

  <script src="js/foundation/foundation.section.js"></script>

  <script src="js/foundation/foundation.tooltips.js"></script>

  <script src="js/foundation/foundation.topbar.js"></script>

  <script src="js/foundation/foundation.interchange.js"></script>

  <script src="js/foundation/foundation.placeholder.js"></script>
  
  <script>
  document.write('<script src=js/vendor/' +  ('__proto__' in {} ? 'zepto' : 'jquery') +  '.js> <\/script>');
  </script>
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
	
  </script>
<?php } 
	  ?>
     

</body>
</html>
