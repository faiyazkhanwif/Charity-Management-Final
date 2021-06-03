<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$projid = $_SESSION['projid'];
$alert = "";
	if (isset($_POST['addvol'])) {
		$vpname = htmlspecialchars($_POST['vpname']);
		$vpemail = htmlspecialchars($_POST['vpemail']);
		$vptask = htmlspecialchars($_POST['vptask']);

		
		if (empty($vpname) || empty($vpemail) || empty($vptask)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly.</div>";
		} else if(!filter_var($vpemail, FILTER_VALIDATE_EMAIL)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid email.</div>";
		} else {
			$sqlcheck1 = "SELECT * FROM volunteers WHERE email = '$vpemail' AND fullname = '$vpname'";
			$result1 = mysqli_query($conn,$sqlcheck1);
			if (!$result1) {
			    printf("Error: %s\n", mysqli_error($conn));
			}
			$data1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);
			mysqli_free_result($result1);

			if (empty($data1)) {
				$alert = "<div class=".'"alert alert-danger"'.">There is no volunteer registered with this name and email. Try again.</div>";
			} else {
				$vacname = "";
				$vacemail = "";
				$vacid = "";
				foreach ($data1 as $row) {
					global $vacname;
					global $vacemail;
					global $vacid;
					$vacname = $row['fullname'];
					$vacemail = $row['email'];
					$vacid = $row['vol_id'];
				}
				$sqlcheck2 = "SELECT * FROM volinproject WHERE vol_id = '$vacid' AND project_id='$projid'";
				$result2 = mysqli_query($conn,$sqlcheck2);
				if (!$result2) {
			    	printf("Error: %s\n", mysqli_error($conn));
				}
				$data2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
				if (!empty($data2)) {
					$alert = "<div class=".'"alert alert-danger"'.">This volunteer is already assigned to this project. Try again.</div>";
				} else {
					$sql = "INSERT INTO volinproject(project_id,vol_id,task) VALUES('$projid','$vacid','$vptask')";
					if (mysqli_query($conn,$sql)) {
						global $alert;
						$alert = "<div class=".'"alert alert-success"'.">Volunteer has been assigned to this project successfully.</div>";
					} else {
						global $alert;
						$alert = "<div class=".'"alert alert-danger"'.">Could not assign the volunteer to this project.".mysqli_error($conn)."</div>";
					}
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
		<title>Add volunteer to project</title>
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
						<a class="navbar-brand" href="#"><i class="fas fa-hand-holding-heart"></i> huhu</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
							<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link navbtn active" href="projects.php">&nbsp Projects &nbsp</span></a>
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
				<div class="container">
					<div class="mb-4 animate__animated animate__fadeInDown">
						<h3>
							<span>New Volunteer for project</span>
							<span class="float-right">
								<form action="project-details.php">
								    <button  class="btn btn-outline-info float-right btncmn" id="bckbtn">Go back <i class="fa fa-arrow-circle-left"></i></button>
								</form>	
							</span>
						</h3>
						<hr>	
					</div>
					<form method="post" action="add-volunteer.php">
						
						<div class="animate__animated animate__fadeIn animate__delay-1s">
							<div>
								<?php 
								echo $alert; ?>
							</div>
							<div class="form-group row">
								<label for="rp-title" class="col-sm-3 col-form-label">Name</label>
								<div class="col-sm-9">
									<input type="text" id="vl-name" class="form-control" autocomplete="off" name="vpname">
								</div>
							</div>
							<div class="form-group row">
								<label for="rp-title" class="col-sm-3 col-form-label">Email</label>
								<div class="col-sm-9">
									<input type="email" id="vl-name" class="form-control" autocomplete="off" name="vpemail">
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Task</label>
								<div class="col-sm-9">
									<textarea id="vl-task" class="form-control" name="vptask"></textarea>
								</div>
							</div>
							<div class="text-center mt-5">
								<input type="submit" id="Add-vl-btn" class="btn btn-outline-success btn-lg btncmn" value="Add" name="addvol" >
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
