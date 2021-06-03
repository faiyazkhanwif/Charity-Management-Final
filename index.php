<?php
	$alert = "";
	if (isset($_POST['login'])) {
		$uname = htmlspecialchars($_POST['uname']);
		$pass = htmlspecialchars($_POST['pass']);
		include_once("config.php");
		if (empty($uname) || empty($pass)){
			global $alert;
			$alert = "<div class=".'"p-3 mb-2 bg-danger text-white"'.">Please fill up the required fields properly.</div>";
		} else {
			$sqlcheck1 = "SELECT * FROM useraccounts WHERE username = '$uname'";
			$result1 = mysqli_query($conn,$sqlcheck1);
			if (!$result1) {
			    printf("Error: %s\n", mysqli_error($conn));
			}
			$data1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);
			
			mysqli_free_result($result1);

			if (empty($data1)) {
				$alert = "<div class=".'"alert alert-danger"'.">No user found, enter vaild user-name.</div>";
			} else {
				$inpass = "";
				$un = "";
				$em = "";
				foreach ($data1 as $col) {
					global $inpass;
					global $un;
					global $em;
					$inpass = $col['password'];
					$un = $col['username'];
					$em = $col['email'];
				}
				$passcheck = password_verify($pass, $inpass);
				if ($passcheck == false) {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Wrong Password.</div>";
				} else if ($passcheck == true) {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">Logged in!.</div>";
					session_start();
					$_SESSION['un'] = $un;
					$_SESSION['em'] = $em;
					header('location: projects.php');
				} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Wrong Password.</div>";
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
		<title>huhu</title>
		<link rel="icon" type="image/x-icon" href="icons\favi.ico">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="assets/css/site.css">
		<link rel="stylesheet" href="nucleo/css/nucleo.css">
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
				<div class="container ">
					<div class="text-center animate__animated animate__backInDown">
						<h2 class="font-italic">For humans, By humans</h2>
						<i class="fas fa-hand-holding-heart fa-5x p-3"></i>
						<hr>
					</div>
					<br>

					<form action="index.php" method="post" class="animate__animated animate__fadeIn animate__delay-1s">
						<h4 class="text-center">Log In</h4>
						<br>
						<div>
							<?php 
							echo $alert; ?>
						</div>
						<div class="col-sm-4 offset-4 ">
							<div class="form-group">
								<label>Username</label>
								<input id="username" type="text" class="form-control" autocomplete="off" name="uname" required>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input id="pw" type="Password" class="form-control" autocomplete="off" name="pass" required>
							</div class = "text-center">
						    <br>
							<input type="submit" id="loginBtn" class="btn btn-primary form-control btncmn" value="Login" onclick="loginFunc()" name="login">
							<br>
							<br>
							<div class="text-center">
								<a href="register.php">Register your account</a>
							</div>
						</div>	
					</form>
				</div>
			</main>
		</div>
		<footer class="text-center text-light bg-dark">
			Copyright © 2020 huhu tools<br>
			<a href="mailto:info@huhu.com.my">info@huhu.com.my</a>
		</footer>

		<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
		<script type="text/javascript">
			
			function loginFunc(){
				username = $('#username').val();
				pw = $('#pw').val();

				if(username === '' || pw === ''){
					alert("Please enter valid username or password");
				}
				else{
					loginProcess(username,pw);
				}
			}
			function loginProcess(username,pw){
				// checkDB
				// if Y -> menu
				// if F -> alert
				window.location.href = 'index.php';
			}
		</script>
	</body>
</html>
