<?php
	$alert = "";
	if (isset($_POST['register'])) {
		$fname = htmlspecialchars($_POST['fname']);
		$uname = htmlspecialchars($_POST['uname']);
		$email = htmlspecialchars($_POST['email']);
		$pass = htmlspecialchars($_POST['pass']);
		$cpass = htmlspecialchars($_POST['cpass']);
		$bday = htmlspecialchars($_POST['bday']);
		$pnumber = htmlspecialchars($_POST['pnumber']);
		$address = htmlspecialchars($_POST['address']);
		$state = htmlspecialchars($_POST['state']);
		$zip = htmlspecialchars($_POST['zip']);


		include_once("config.php");
		if (empty($fname) || empty($uname) || empty($email) || empty($pass) || empty($bday) || empty($pnumber) || empty($address) || empty($state) || empty($zip)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly.</div>";
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid email.</div>";
		} elseif (!filter_var($pnumber, FILTER_VALIDATE_INT)) {
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid Phone number.</div>";
		} else if($pass !== $cpass){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Password does not match.</div>";
		} else {
			$sqlcheck1 = "SELECT email FROM useraccounts WHERE email = '$email' OR username = '$uname'";
			$result1 = mysqli_query($conn,$sqlcheck1);
			if (!$result1) {
			    printf("Error: %s\n", mysqli_error($conn));
			}
			$data1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);
			mysqli_free_result($result1);

			if (!empty($data1)) {
				$alert = "<div class=".'"p-3 mb-2 bg-danger text-white"'.">Email or Username already registered. Try again.</div>";
			} else {
				$hashedpass = password_hash($pass, PASSWORD_DEFAULT);
				$sql = "INSERT INTO useraccounts(fullname,username,email,password,birthday,phone,address,state,zip) VALUES('$fname','$uname','$email','$hashedpass','$bday','$pnumber','$address','$state','$zip')";
				if (mysqli_query($conn,$sql)) {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">An account was created successfully.</div>";
				} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Could not create an account.".mysqli_error($conn)."</div>";
				}
			}
			
		}
		mysqli_close($conn);

	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Registration</title>
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
					<a class="navbar-brand" href=""><i class="fas fa-hand-holding-heart"></i> huhu</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="about-us.html">About Us</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<main>
			<h2 class="text-center animate__animated animate__fadeInDown">Registration Form</h2>
			<div class="container mb-5 animate__animated animate__fadeIn animate__delay-1s">
				<div class="">
					
					<hr>
					<div>
						<?php 
						echo $alert; ?>
					</div>
					<div class="mb-4">
						<a class="btn btn-outline-info float-right" id="hrefUpd" href="index.php" role="button"><i class="fas fa-chevron-circle-left"></i> Go back to Login page</a>
					</div>
					<form action="register.php" method="post" class="">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Full Name</label>
								<div class="col-sm-9">
									<input id="fname" type="text" class="form-control" autocomplete="off" name="fname" required>
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
											<input type="text" id="username" class="form-control" autocomplete="off" required name="uname">
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Email</label>
										<input id="user_email" type="email" class="form-control" autocomplete="off" name="email" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Password</label>
										<input id="pw" type="password" class="form-control" autocomplete="off" name="pass" required>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Confirm Password <span id="pwValid" class="pull-right"></span></label>
										<input id="confirm-pw" type="password" class="form-control" autocomplete="off" name="cpass" required>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Birth Date</label>
										<input id="birthdate" type="date" class="form-control" autocomplete="off" name="bday" required>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Phone Number</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">+60</span>
											</div>
											<input id="phone-num" type="number" class="form-control" autocomplete="off" name="pnumber" required>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Address</label>
								<input type="text" id="address" class="form-control" name="address">
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>State</label>
										<input id="state" list="state_list" class="form-control" required="" name="state">
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
										<input id="zipcode" type="number" class="form-control" autocomplete="off" name="zip" required>
									</div>
								</div>
							</div>
							<br>
							<input type="submit" id="registerBtn" class="btn btn-primary form-control btncmn" value="Register" name="register">
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
	<footer class="text-center text-light bg-dark">
		Copyright © 2020 huhu tools<br>
		<a href="mailto:info@huhu.com.my">info@huhu.com.my</a>
	</footer>
	
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#confirm-pw').keyup(function(){
				if($('#pw').val() !== $('#confirm-pw').val()){
					$('#pwValid').html('<i class="text-danger" aria-hidden="true">Not Match!</i>');
				}else{
					$('#pwValid').html('<i class="text-success" aria-hidden="true">Match!</i>');
				}
			});
			$('#pw').keyup(function(){
				if($('#confirm-pw').val() !== ''){
					if($('#pw').val() !== $('#confirm-pw').val()){
						$('#pwValid').html('<i class="text-danger" aria-hidden="true">Not Match!</i>');
					}else{
						$('#pwValid').html('<i class="text-success" aria-hidden="true">Match!</i>');
					}
				}
			});
		});
	</script>

</body>
</html>