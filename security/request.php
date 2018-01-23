<?php
/*
 User has logged in and has a valid API key
 Give user the following options:
 OSD:	http://imaging.cci.emory.edu/camicroscope/osd/
 MOO:	http://imaging.cci.emory.edu/camicroscope/moo/
 Pivot:	http://imaging.cci.emory.edu/camicroscope/pivot/

 And no one should be able to hit those sites if they have not authenticated

 */

if (!isset($_REQUEST['doAction'])) {
	header('Location:../index.php');
}
require_once '../config/security_config.php';
require 'registration_info.php';
require_once 'mailWrapper.php';
session_start();

function handleAdminActions()
{
	global $folder_path;
	error_log("processing ....... signUp ");
	$email = $_POST["email"];
	$name =  $_POST["name"];
	$reason =  $_POST["reason"];
	
	if(isset($email)  && isset($name)) {
		$verification_code = UserRegistrationInfo::createNewRequest($email, $name, $reason);
		error_log("sending email .......");
		$admins = getAdminList();
		$subject = "$email requesting access to caMicroscope"; 
		$accept_url = get_host_port_url() . $folder_path ."security/accept_deny_user_access.php?doAction=request-accepted&verification_code=$verification_code";
		$deny_url = get_host_port_url() . $folder_path ."security/accept_deny_user_access.php?doAction=request-denied&verification_code=$verification_code";
		$content = "Following user is seeking access to caMicroscope\nName: $name\nEmail Address: $email\nReason: $reason\n\nApprove Request :\n$accept_url \n\nDeny Request :\n$deny_url";
		foreach ($admins as $admin_email)
		{			
			sendMail($admin_email, $subject, $content);
		}
		$first_line = "Your request has been received"; 
		$second_line = "You will recieve an email notification when your request is approved or denied.";
		writeHeaderHTML();
		display_message($first_line, $second_line);
		writeFooterHTML();
		error_log("finished writing HTML");
		die();
	}
	else{
		header("Location: ../error.php?message=registration information not provided");
		die();
	}
}

   
function handleUserRegistration() {
	global $folder_path;
	if (isset($_SESSION["api_key"])) {
		// user already has an api_key so no need to go through with registration just redirect to select.php
		header("Location:http://".$_SERVER["HTTP_HOST"].$folder_path."select.php");
		die();
	} else {
		try {
			// initialize 			
			UserRegistrationInfo::init();
			
			$email = $_SESSION["email"];
			$name = $_SESSION["name"];
			
			
			if("submitSignUp" === $_REQUEST["doAction"]) {
				error_log("handle admin actions...");
				handleAdminActions();
			} else {
				if(UserRegistrationInfo::isRequestPending($email)) {
					error_log("request pending...");
					requestPending($email , $name);
				} else {
					error_log("user registration...");
					userRegistration($email , $name); 
				}	
			}
			
		} catch(ErrorException $exception) {
			handleError($exception -> getMessage(), TRUE);
		}
	}
}

function display_message($first_line , $second_line)
{
	?>
	<div class="jumbotron">
	<p class="text-warning"><strong><?php echo $first_line; ?></strong> </p>
	<p><?php echo $second_line; ?></p>
	</div>
	<?php
}

function get_host_port_url()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port ;
}

function userRegistration($email , $name)
{
        error_log("signing up user: ");
        error_log($email);
        error_log($name);
	writeHeaderHTML();
?>
        <p>Since you don't have an account with caMicroscope, you need to sign up as an administrator or ask your administrator to grant you access.</p>
        <p>Administrator can signup himself/herself and  add other users to the caMicroscope by click below link.</p>
        <p><a href="/camicSignup/index.html">Signup User to Access caMicroscope</a></p>
	 <!--
        <form role="form" action="?doAction=submitSignUp" method="post">
		<div class="form-group">
	    	<label >Screen Name</label>
	    	<input type="text" name="name" class="form-control" value="<?php echo $name; ?>"  readonly>
	  </div>
		 <div class="form-group">
    	 	<label>Email address</label>
    	 	<input type="email" name="email" class="form-control" value="<?php echo $email; ?>"  readonly>
  		</div>
		 <div class="form-group">
    	 	<label>Reason for requesting access</label>
    	 	<textarea name="reason" class="form-control" rows="3" placeholder="I want to try our caMicroscope !"></textarea>
  		</div>
  		<script>
			$("textarea").focus();
  		</script>

  		<button type="submit" class="btn btn-default">Submit</button>
	</form>
        -->
<?php
	writeFooterHTML();
}

function requestPending($email,$name) {
	writeHeaderHTML();
	$first_line = "Your request is already under consideration.";
	$second_line = "You will recieve an email notification when your request is approved or denied.";
	display_message($first_line, $second_line);
		writeFooterHTML();
}

function writeHeaderHTML() {
	global $folder_path;
	?>
 <!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified JavaScript -->
		<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<!-- Latest compiled and minified CSS -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
                <script>
                function logOut() {
                    $.post( "server.php?logOut", {},
                    function() {
                        window.location = "../index.php";
                    });
                gapi.auth.signOut();
                };
                </script>
		</head>
	<title>caMicroscope </title>
	<body style="padding-top: 10px;">
		
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  				<div class="navbar-header">
    
    			<a class="navbar-brand" href="<?php echo $folder_path ?>"><h1>caMicroscope</h1></a>
  				</div>
  				
  				<div class="nav navbar-nav navbar-right">
  					<a  class="navbar-brand" href="http://imaging.cci.emory.edu/wiki/display/CAMIC/Home"><h5>Help</h5></a>
  				</div>
  				
  				<ul class="nav navbar-nav navbar-right"> 
  					
  					<li  class="dropdown">
  							 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><h5><?php echo $_SESSION["name"]; ?></h5></a>
  							<ul class="dropdown-menu navbar-inverse">
              <li><a onclick="logOut(); return false;" href="#">Logout</a></li>
 						    </ul>
  					</li> 
  				</ul>
  				
  				
		</nav>

		<div class="row" body >
			<div class="col-lg-1" left-margin>

			</div>
			<div class="col-lg-10">

<?php
}
function writeFooterHTML() {
?>

			</div>
			<div class="col-lg-1" right-margin>

			</div>
		</div>

		<div class="navbar navbar-fixed-bottom" footer>
			<hr />
			<div class="col-lg-9 col-lg-offset-3">
				<h5>caMicroscope is under development at the Department of Biomedical Informatics, Emory University</h5>
				<h5>It has been supported by NCI/SAIC-Fredrick through 10XS220 and the Google Summer of Code 2012</h5>
			</div>
		</div>

	</body>
</html>
<?php
}
handleUserRegistration();
?>
