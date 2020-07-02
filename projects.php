<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
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
						<h1 class="text-center">Welcome <?php echo $uname; ?></h1>
						<hr>
						<div class="col text-center">
							<form action="add-project.php">
							    <button  class="btn btn-info btn-lg text-center btncmn">Add Project  <i class="fas fa-folder-plus">	</i></button>
							</form>
							
						</div>	
					</div>
					<h4>Current Projects</h3>
					<div class="table-responsive">
						<table class="table table-striped" id="data-table">
							<thead class="text-primary">
								<th>#ID</th>
								<th>Project Name</th>
								<th>Date</th>
								<th>Volunteers</th>
								<th>Action</th>
							</thead>
							<tbody id="tb-project">
								<tr>
									<td>1</td>
									<td>Lunch for orphanage</td>
									<td>12/4/20</td>
									<td>8</td>
									<td class="btn-group">
										<a id="pj-btn1" class="btn btn-outline-secondary" title="Details" href="project-details.php"><i class="fas fa-tasks"></i></a>
										<a id="pj-btn1" class="btn btn-outline-success" title="Add volunteers" onclick="window.open('add-volunteer.html','popup','width=600,height=800,scrollbars=no,resizable=no')"><i class="fas fa-user-plus"></i></a>
										<a id="pj-btn1" class="btn btn-outline-danger" title="Delete" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i></a>
										
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td>Welfare home visit</td>
									<td>22/4/20</td>
									<td>6</td>
									<td class="btn-group">
											<a class="btn btn-outline-secondary" title="Details" href="project-details.php"><i class="fas fa-tasks"></i></a>
											<a class="btn btn-outline-success" title="Add volunteers" ><i class="fas fa-user-plus" onclick="window.open('add-volunteer.html','popup','width=600,height=800,scrollbars=no,resizable=no')" ></i></a>
											<a class="btn btn-outline-danger" title="Delete" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i></a>
										
									</td>
								</tr>
								<tr>
									<td>3</td>
									<td>Agathians Shelter visit</td>
									<td>2/5/20</td>
									<td>12</td>
									<td class="btn-group">
											<a class="btn btn-outline-secondary" title="Details" href="project-details.php"><i class="fas fa-tasks"></i></a>
											<a class="btn btn-outline-success" title="Add volunteers" ><i class="fas fa-user-plus" onclick="window.open('add-volunteer.html','popup','width=600,height=800,scrollbars=no,resizable=no')"></i></a>
											<a class="btn btn-outline-danger" title="Delete" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i></a>
									</td>
								</tr>
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

			function deleteRow(oButton){
				var dataTab = document.getElementById('data-table');
				console.log(dataTab);
				console.log(dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells[0].innerHTML);
				var length = dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells.length;
				var tableData = new Array(dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells.length - 1);
				for (var i = 0; i < length - 1; i++) {
					tableData[i] = dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells[i].innerHTML;
					console.log(tableData[i]);
				}
				var boolConfirm = confirm("Confirm Delete ?");
				if(boolConfirm == true){
					dataTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.
				}
			}
		</script>
	</body>
</html>