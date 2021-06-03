<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$sql2 = "SELECT * FROM volunteers";
$result = mysqli_query($conn,$sql2);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

if (isset($_POST['profile'])) {
	$profile = $_POST['profile'];
	$_SESSION['volprof'] = $profile;
	$url = "volunteer-profile.php";
	//header('Location: ' . $url);
	header('Location: ' . $url);
	mysqli_close($conn);
	exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Volunteers</title>
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
								<a class="nav-link navbtn" href="projects.php">&nbsp Projects &nbsp</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link active navbtn" href="volunteers.php">&nbsp Volunteers &nbsp </a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item dbtn" href="profile.php">User Profile (<?php echo $uname; ?>)<span class="sr-only">(current)</a>
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
				<div class="container mb-3">
					<div class="mb-4 animate__animated animate__fadeInDown">
						<h1>
							<span>Volunteers</span>
							<span class="float-right">
								<form action="add-new-volunteer.php">
									<button class='btn btn-info btncmn'>Add New Volunteer</button>	
								</form>
							    
							</span>
						</h1>
						<hr>	
					</div>
					<div class="table-responsive animate__animated animate__fadeIn animate__delay-1s">
						<table class="table table-striped" id="vol-table">
							<thead class="text-primary">
								<th>Name</th>
								<th>Email</th>
								<th>Action</th>
							</thead>
							<tbody id="tb-vol">
								<?php
									foreach ($data as $row) { ?>
										<form action="volunteers.php" method="post">
											<tr>
												<td><?php
												echo $row["fullname"]; ?></td>
												<td><?php
												echo $row["email"]; ?></td>
												<td class="btn-group">
														<button id="vol-btn1" type="submit" class="btn btn-outline-secondary" title="Profile" name="profile" value = "<?php 
														echo $profile = $row["nric"]; ?>"><i class="fas fa-user-alt"></i></button>
												</td>
											</tr>
										</form>	
								<?php } ?>	
							</tbody>
						</table>
				
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