<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$alert = "";
	if (isset($_POST['saveproject'])) {
		$title = htmlspecialchars($_POST['title']);
		$dur = htmlspecialchars($_POST['duration']);
		$date = htmlspecialchars($_POST['date']);
		$time = htmlspecialchars($_POST['time']);
		$loc = htmlspecialchars($_POST['location']);
		$des = htmlspecialchars($_POST['description']);
		$file = htmlspecialchars($_POST['file']);
		


		include_once("config.php");
		if (empty($title) || empty($dur) || empty($date) || empty($time) || empty($loc) ||  empty($des)){
			global $alert;
			$alert = "<div class=".'"p-3 mb-2 bg-danger text-white"'.">Please fill up the form properly.</div>";
		} else {
				if (empty($file)) {
					$file = "No file added";
				} else {
					    $sql = "INSERT INTO projects(title,duration,starting_date,starting_time,location,description,files) VALUES('$title','$dur','$date','$time','$loc','$des','$file')";
						if (mysqli_query($conn,$sql)) {
							global $alert;
							$alert = "<div class=".'"p-3 mb-2 bg-success text-white"'.">Project was created successfully.</div>";
						} else {
							global $alert;
							$alert = "<div class=".'"p-3 mb-2 bg-danger text-white"'.">Could not create the project.".mysqli_error($conn)."</div>";
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
	<title>Add Project</title>
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
								<a class="nav-link active navbtn" href="projects.php">&nbsp Projects &nbsp</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link navbtn" href="volunteers.php">&nbsp Volunteers &nbsp </a>
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
			<div class="container mb-5">
				<div class="mb-4 animate__animated animate__fadeInDown">
						<h1>
							<span>New Project</span>
							<span class="float-right">
							    <form action="projects.php">
							    	<button  class="btn btn-outline-info float-right btncmn" id="bckbtn">Go back <i class="fa fa-arrow-circle-left"></i></button>
								</form>	
							</span>
						</h1>
						<hr>	
				</div>
				<form method="post" action="add-project.php">
					
					<div class="animate__animated animate__fadeIn animate__delay-1s ">
						<div>
							<?php 
							echo $alert; ?>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group row">
									<label for="rp-title" class="col-sm-3 col-form-label">Title</label>
									<div class="col-sm-9">
										<input type="text" id="rp-title" class="form-control" autocomplete="off" required name="title">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label for="rp-title" class="col-sm-3 col-form-label">Est. Duration</label>
									<div class="col-sm-9">
										<input type="number" placeholder="Number of days" id="rp-title" class="form-control" autocomplete="off" name="duration" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Starting Date</label>
									<div class="col-sm-9">
										<input type="date" id="pj-date" class="form-control" name="date" required>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label for="" class="col-sm-3 col-form-label">Starting Time</label>
									<div class="col-sm-9">
										<input type="time" id="pj-time" class="form-control" name="time" required>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Location</label>
							<div class="col-sm-9">
								<input type="text" id="pj-location" class="form-control" autocomplete="off" name="location" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Description</label>
							<div class="col-sm-9">
								<textarea id="pj-obj" class="form-control" name="description" required></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-3 col-form-label">Upload a File</label>
							<div class="col-sm-9">
								<div class="custom-file">
								    <input type="File" name="file">
								</div>
							</div>
						</div>
						<div class="text-center mt-5">
							<input type="submit" id="submit-btn-pj" class="btn btn-outline-success btn-lg btncmn" name="saveproject" value="Save Project" >
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
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript">
		
	</script>
</body>

</html>