<?php 
session_start();
include_once("config.php");
$alert="";
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
if (isset($_POST['delete'])) {
		$uname = htmlspecialchars($_POST['uname']);
		$pass = htmlspecialchars($_POST['pass']);
		include_once("config.php");
		if (empty($uname) || empty($pass)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the required fields properly.</div>";
		} else {
			$sqlcheck1 = "SELECT * FROM useraccounts WHERE username = '$uname'";
			$result1 = mysqli_query($conn,$sqlcheck1);
			if (!$result1) {
			    printf("Error: %s\n", mysqli_error($conn));
			}
			$data1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);
			//print_r($data1);
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
					//global $alert;
					//$alert = "<div class=".'"alert alert-s"'.">Logged in!.</div>";
					$removesql = "DELETE FROM useraccounts WHERE username='$uname'";
					if (mysqli_query($conn,$removesql)) {
						global $rmalert;
						echo $rmalert = "<div class=".'"alert alert-info"'.">User profile was deleted.</div>";
						session_start();
						session_unset();
						session_destroy();
						header("location: index.php");
					} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Wrong Password.</div>";
					}
				}
		}
		mysqli_close($conn);
	}
}

 ?>
 <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Delete Account</title>
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
					<div class="row nmrow animate__animated animate__fadeIn animate__delay">
						<div class="col-md-6 ">
							<h2>Delete Account</h2>
							<div>
								<?php 
								echo $alert; ?>
							</div>
							<br>
							<p class="text-danger font-italic">Reminder : <br>All your projects and reports will be permanently deleted. <br>Once deleted, cannot be recovered.</p>
							<br>
							<br>
							<a href="profile.php"><i class="fas fa-chevron-circle-left"></i> Cancel deletion</a>
						</div>
						<form method="post" action="deleteuser.php">
							<div class="col-md-14">
								<h3>Confirmation :</h3>
								<div class="form-group">
									<label><small>Enter Username and Password for confirmation and click 'Submit'.</small></label>
									<input id="userDel" type="text" class="form-control" autocomplete="off" placeholder="Username" name="uname" required>
									<br>
									<input type="password" id="pwDel" class="form-control" placeholder="Password" autocomplete="off" name="pass">
								</div>
								<input type="submit" id="submitBtn" class="btn btn-danger form-control btncmn" value="Submit" name="delete">
								
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


		<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.js"></script>
		<script type="text/javascript">
		</script>
	</body>
</html>