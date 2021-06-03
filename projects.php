<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$sql2 = "SELECT * FROM projects";
$result = mysqli_query($conn,$sql2);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

if (isset($_POST['details'])) {
	$project = $_POST['details'];
	$_SESSION['proj'] = $project;
	$sqlid = "SELECT project_id FROM projects WHERE title ='$project'";
	$resultid = mysqli_query($conn,$sqlid);
	$dataid = mysqli_fetch_all($resultid,MYSQLI_ASSOC);
	mysqli_free_result($resultid);
	foreach ($dataid as $col) {
		$projid = $col['project_id'];
		$_SESSION['projid'] = $projid;
	}
	$url = "project-details.php";
	//header('Location: ' . $url);
	header('Location: ' . $url);
	mysqli_close($conn);
	exit();
}

$alert="";
if (isset($_POST['remove'])) {
	$proj = $_POST['remove'];
	$removesql = "DELETE FROM projects WHERE project_id='$proj'";
	if (mysqli_query($conn,$removesql)) {
		global $alert;
		$alert = "<div class=".'"alert alert-success"'.">Project was removed successfully.</div>";
		$url = "projects.php";
		//header('Location: ' . $url);
		header('Location: ' . $url);
		
		} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Could not remove the volunteer.".mysqli_error($conn)."</div>";
				}

} 

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Projects</title>
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
				<div class="container mb-3">
					<div class="mb-4">
						<div class="animate__animated animate__fadeInDown">
							<h1 class="text-center">Welcome <?php echo $uname; ?></h1>
							<hr>
						</div>
						
						
						<div class="col text-center animate__animated animate__fadeIn animate__delay-1s ">
							<form action="add-project.php">
							    <button  class="btn btn-info btn-lg text-center btncmn">Add Project  <i class="fas fa-folder-plus">	</i></button>
							</form>
							
						</div>	
					</div>
					<div class="animate__animated animate__fadeIn animate__delay-1s">
						<h4>Current Projects</h3>
					</div>
					<div>
						<?php 
						echo $alert; ?>
					</div>
					<div class="table-responsive animate__animated animate__fadeIn animate__delay-1s">
						<table class="table table-striped" id="data-table">
							<thead class="text-primary">
								<th>Project Name</th>
								<th>Date</th>
								<th>Location</th>
								<th>Action</th>
							</thead>
							<tbody id="tb-project">
								<?php
									foreach ($data as $row) { ?>
										<form action="projects.php" method="post">
											<tr>
												<td><?php
												echo $row["title"]; ?></td>
												<td><?php
												echo $row["starting_date"]; ?></td>
												<td><?php
												echo $row["location"]; ?></td>
												<td class="btn-group">
														<button id="vol-btn1" type="submit" class="btn btn-outline-secondary" title="Details" name="details" value = "<?php 
														echo $project = $row["title"]; ?>"><i class="fas fa-tasks"></i></button>
														<button id="vol-btn1" type="submit" class="btn btn-outline-danger" title="Remove" name="remove" value = "<?php 
															echo $proj = $row["project_id"]; ?>" onclick = "return deleteproj();"><i class="fas fa-trash-alt"></i></button>
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

			function deleteproj(){
			  var txt;
			  var r = confirm("Are you sure you want to remove this project?");
			  if (r == true) {
			    deleteProcess();
			  }else {
			  	return false;
			  }
			}
			function deleteProcess(username,pw){
				// checkDB
				// if Y -> menu
				// if F -> alert
				window.location.href = 'projects.php';
			}
		</script>
	</body>
</html>