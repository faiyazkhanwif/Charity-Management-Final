<?php
session_start();
include_once("config.php");
$alert="";
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$username=$uname;
$useremail=$email;
$fullname="";
$birthday="";
$phone="";
$address="";
$state="";
$zip="";

$sql2 = "SELECT * FROM useraccounts WHERE username = '$uname'";
$result = mysqli_query($conn,$sql2);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

foreach ($data as $row) {
	$userfullname = $row['fullname'];
	$username = $row['username'];
	$useremail = $row['email'];
	$userbirthday = $row['birthday'];
	$useraddress = $row['address'];
	$userphone = $row['phone'];
	$userstate = $row['state'];
	$userzip = $row['zip'];
}
#update
if (isset($_POST['update'])) {
		$userfullname = htmlspecialchars($_POST['fname']);
		$username = htmlspecialchars($_POST['username']);
		$useremail = htmlspecialchars($_POST['email']);
		$userbirthday = htmlspecialchars($_POST['birthday']);
		$userphone = htmlspecialchars($_POST['phone']);
		$useraddress = htmlspecialchars($_POST['address']);
		$userstate = htmlspecialchars($_POST['state']);
		$userzip = htmlspecialchars($_POST['zip']);

		if (empty($userfullname) || empty($useraddress) || empty($userbirthday) || empty($userphone) || empty($userstate) || empty($userzip)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly.</div>";
		} elseif (!filter_var($userphone, FILTER_VALIDATE_INT)) {
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid Phone number.</div>";
		} elseif (!filter_var($userzip, FILTER_VALIDATE_INT)) {
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter valid zip.</div>";
		} else {
				$sql = "UPDATE useraccounts
						SET fullname = '$userfullname', zip= '$userzip', phone= '$userphone', birthday= '$userbirthday', address= '$useraddress', state= '$userstate'
						WHERE username = '$username'";
				if (mysqli_query($conn,$sql)) {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">User profile has been updated.</div>";
				} else {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">Could not update the user information.".mysqli_error($conn)."</div>";
				}
			

		}	
		
}
#changepass
$oass="";
if (isset($_POST['submitpass'])) {
	foreach ($data as $row) {
		global $pass;
		$pass = $row['password'];
	}
	$oldpass = htmlspecialchars($_POST['oldpass']);
	$newpass = htmlspecialchars($_POST['newpass']);
	$conpass = htmlspecialchars($_POST['conpass']);
	$passcheck = password_verify($oldpass, $pass);
	if ($passcheck == false) {
		global $alert;
		$alert = "<div class=".'"alert alert-danger"'.">Wrong Password.</div>";
	} else if ($passcheck == true) {
		//$finalpasscheck = password_verify($oldpass, $newpass);
		if ($newpass !== $conpass) {
			$alert = "<div class=".'"alert alert-danger"'.">Please retype the password correctly.</div>";
		} else if ($newpass === $conpass){
			$hashedpass = password_hash($conpass, PASSWORD_DEFAULT);
			$passsql = "UPDATE useraccounts
						SET password = '$hashedpass'
						WHERE username = '$uname'";
			if (mysqli_query($conn,$passsql)) {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">User password has been updated.</div>";
				} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Could not update the user password.".mysqli_error($conn)."</div>";
				}
		}
		
	}
	
} 


mysqli_close($conn);
 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>User Profile</title>
		<link rel="icon" type="image/x-icon" href="icons\favi.ico">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="assets/css/site.css">
		<link rel="stylesheet" type="text/css" href="nucleo/css/nucleo.css">
		<link rel="stylesheet" href="fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
	</head>
	<body class="d-flex flex-column min-vh-100">
		<div class="wrapper flex-grow-1">
			<header>
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3 fixed-top">
					<div class="container">
						<a class="navbar-brand" href="#"><i class="fas fa-hand-holding-heart"></i> huhu</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
							<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link navbtn" href="projects.php">&nbsp Projects &nbsp</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link navbtn" href="volunteers.php">&nbsp Volunteers &nbsp </a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item dbtn active" href="profile.php">User Profile (<?php echo $uname; ?>)<span class="sr-only">(current)</a>
									<a class="dropdown-item dbtn" data-toggle="modal" data-target="#sign-out" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
								</div>
							</li>
							</ul>
						</div>
					</div>
				</nav>
				<div class="modal fade" id="sign-out">
					<div class="modal-dialog">
						<div class="modal-content">
					    	<div class="modal-header">
					         	<h4 class="modal-title">Are you sure?</h4>
					        	<button type="button" class="close" data-dismiss="modal">&times;</button>
					        </div>
					        <div class="modal-footer">
					            <button type="button" class="btn btn-success" data-dismiss="modal">Stay Here</button>
					            <form action="logout.php" method="post">
					            	<input type="submit" class="btn btn-danger" value="Log out">
					            </form>
					        </div>
					    </div>
					</div>
				</div>
			</header>
			<main>
				<div class="container">
					
						
						<div class="mb-4 animate__animated animate__fadeInDown">
							<h2>
								<span>User details</span>
								<span class="float-right">
								    <form action="volunteers.php">
								    	<button type="button" onclick="upd_profile()" class="btn btn-outline-info btncmn">Edit profile</button>
								    	<button type = "button" class="btn btn-outline-info btncmn" data-toggle="modal" data-target="#changePwModal">Change password</button>

										<a href="deleteuser.php" class="btn btn-danger btncmn">Delete account</a>
									</form>	
								</span>
							</h2>
							<hr>	
						</div>
						<div class="animate__animated animate__fadeIn animate__delay-1s">
							<?php 
							echo $alert; ?>
						</div>
						<div class="modal fade" id="changePwModal" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Change Password</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="profile.php" method="post">
											<div class="modal-body">
												<div class="form-group row">
													<label class="col-4 col-form-label">Old Password</label>
													<input type="password" class="col-5 form-control" id="oldPw" name="oldpass" required="">
												</div>	
												<div class="form-group row">
													<label class="col-4 col-form-label">New Password</label>
													<input type="password" class="col-5 form-control" id="newPw" name="newpass" required="">
												</div>
												<div class="form-group row">
													<label class="col-4 col-form-label">Confirm Password</label>
													<input type="password" class="col-5 form-control" id="cnewPw" name="conpass" required="">
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn btn-outline-secondary" value="Change" name="submitpass">
											</div>
										</form>
									</div>
								</div>
							</div>
						<form method="post" action="profile.php">	
							<div class="col-md-6 animate__animated animate__fadeIn animate__delay-1s">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Full Name</label>
									<div class="col-sm-9">
										<input id="fname" type="text" class="form-control" readonly="" autocomplete="off" name="fname" value="<?php echo $userfullname; ?>">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Username</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">@</span>
												</div>
												<input type="text" id="username" readonly="" class="form-control" autocomplete="off" value="<?php echo $username; ?>" name="username">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Email</label>
											<input id="user_email" type="email" class="form-control" readonly="" autocomplete="off" name="email" value="<?php echo $useremail; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Birth Date</label>
											<input id="birthdate" type="date" class="form-control" value="<?php echo $userbirthday; ?>" autocomplete="off" name="birthday" readonly="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Phone Number</label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">+60</span>
												</div>
												<input id="phone-num" type="text" class="form-control" value="<?php echo $userphone; ?>" autocomplete="off" name="phone" readonly="">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Address</label>
									<input type="text" id="address" class="form-control" name="address" value="<?php echo $useraddress; ?>" readonly="">
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>State</label>
											<input id="state" list="state_list" class="form-control" name="state" value="<?php echo $userstate; ?>" readonly="">
											<datalist id="state_list">
												<option>Johor</option>
												<option>Kedah</option>
												<option>Kelantan</option>
												<option>Melaka</option>
												<option>Negeri Sembilan</option>
												<option>Pahang</option>
												<option>Penang</option>
												<option>Perak</option>
												<option>Perlis</option>
												<option>Sabah</option>
												<option>Sarawak</option>
												<option>Selangor</option>
												<option>Terengganu</option>
												<option>Kuala Lumpur</option>
												<option>Labuan</option>
												<option>Putrajaya</option>
											</datalist>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Zip</label>
											<input id="zipcode" type="number" class="form-control" value="<?php echo $userzip; ?>" name="zip" autocomplete="off" name="" readonly="">
										</div>
									</div>
								</div>
								<br>
								<input type="submit" name="update" id="updateBtn" class="btn btn-outline-primary form-control" onclick="upd_submit()" value="Update" disabled="">
							</div>
						</form>		
				</div>
			</main>
		</div>
		<br>
		<footer class="text-center text-light bg-dark">
			Copyright © 2020 huhu tools<br>
			<a href="mailto:info@huhu.com.my">info@huhu.com.my</a>
		</footer>
		
		<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.js"></script>
		<script type="text/javascript">
			
			$(document).ready(function(){
				
			});
			function upd_profile(){
				$('#fname').prop('readonly',false);
				$('#birthdate').prop('readonly',false);
				$('#phone-num').prop('readonly',false);
				$('#address').prop('readonly',false);
				$('#state').prop('readonly',false);
				$('#zipcode').prop('readonly',false);
				$('#updateBtn').prop('disabled',false);
				$('#updateBtn').prop('readonly',false);

			}
			function upd_submit(){
				$('#fname').prop('readonly',true);
				$('#birthdate').prop('readonly',true);
				$('#phone-num').prop('readonly',true);
				$('#address').prop('readonly',true);
				$('#state').prop('readonly',true);
				$('#zipcode').prop('readonly',true);
				$('#updateBtn').prop('readonly',true);

				
			}


			document.getElementById("debtn").onclick = function 
			() {
				location.href = "deleteuser.php";
			};
		</script>
	</body>
</html>