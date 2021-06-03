<?php 
session_start();
include_once("config.php");
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$project = $_SESSION['proj'];
$projid = $_SESSION['projid'];



$sql2 = "SELECT volinproject.task, volunteers.vol_id, volunteers.fullname, volunteers.nric FROM volinproject, volunteers WHERE volinproject.vol_id=volunteers.vol_id AND volinproject.project_id='$projid'";
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
$rmalert="";
if (isset($_POST['remove'])) {
	$rmid = $_POST['remove'];
	$removesql = "DELETE FROM volinproject WHERE vol_id='$rmid' AND project_id='$projid'";
	if (mysqli_query($conn,$removesql)) {
		global $rmalert;
		$rmalert = "<div class=".'"alert alert-success"'.">Volunteer was removed from this project successfully.</div>";
		$url = "project-details.php";
		//header('Location: ' . $url);
		header('Location: ' . $url);
		
		} else {
					global $rmalert;
					$rmalert = "<div class=".'"alert alert-danger"'.">Could not remove the volunteer.".mysqli_error($conn)."</div>";
				}

} 

?>
 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Project Details</title>
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
				<div class="mb-0 ">
					<div class="modal fade" id="delete-vol">
						<div class="modal-dialog">
							<div class="modal-content">
						    	<div class="modal-header">
						         	<h4 class="modal-title">Are you sure you want to remove this volunteer from this project?</h4>
						        	<button type="button" class="close" data-dismiss="modal">&times;</button>
						        </div>
						        <div class="modal-body">
						        	<p class="text-danger font-italic"><small>*This will remove all data related to this person from this project.</small></p>
						        </div>
						        <div class="modal-footer">
						            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
						            <form method="post", action="project-details.php">
						            	<input type="submit" class="btn btn-danger" value="Remove" name="remove">
						            </form>
						        </div>
						    </div>
						</div>
					</div>
					<div class="animate__animated animate__fadeInDown">
						<h1>
						  <span>Project : <?php echo $project; ?></span>
						  <span class="float-right">
						  	<button class='btn btn-outline-info btncmn' onclick="upd_info()">Edit Information</button>
						    <button class='btn btn-info btncmn' onclick="info_submit()">Update Information</button>	
						  </span>
						</h1>
						<hr>
					</div>
					
					<br>
					<div class="row center-block animate__animated animate__fadeIn animate__delay-1s">
						<div class="card mx-auto btncmn" style="width: 18rem;">
						  <img class="card-img-top" src="assets/images/tnd.jpg" width="286" height="150" alt="Card image cap">
						  <div class="card-body">
						    <h5 class="card-title text-center">Time and Date</h5>
						    <p class="card-text">
						    	<div style="text-align: center;">
						    		<input type="time" id="pj-time" value="15:00" disabled="">
						    	</div>
						    	<br>
						    	<div style="text-align: center;">
						    		<input id="pj-date" value="2020-04-12" type="date" class="form-control" autocomplete="off" name="" required="" disabled="">
						    	</div>
						    </p>
						  </div>
						</div>
						<div class="card mx-auto btncmn" style="width: 18rem;">
						  <img class="card-img-top" src="assets/images/des.jpg" width="286" height="150" alt="Card image cap">
						  <div class="card-body">
						    <h5 class="card-title text-center">Description and Duration</h5>
						    <p class="card-text">
						    	<div>
						    		<textarea id="pj-obj" class="form-control" disabled="">Arrangement of lunch for 10 orphan kids</textarea>
						    	</div>
						    	<div style="text-align: center;">
						    		<br>
						    		<span>Duration(Days): </span>
						    		<span> <input id='pj-dur' type="number" id="pj-time" value="6" disabled=""></span>
						    	</div>
						    </p>
						  </div>
						</div>
						<div class="card mx-auto btncmn" style="width: 18rem;">
						  <img class="card-img-top" src="assets/images/loc.jpg" width="286" height="150" alt="Card image cap">
						  <div class="card-body">
						    <h5 class="card-title text-center">Location</h5>
						    <p class="card-text text-center"><textarea id="pj-loc" class="form-control" spellcheck="false" disabled="">Petaling jaya</textarea></p>
						  </div>
						</div>
						<hr>
					</div>
					<br>
					
				</div>			
				<br>
			<div class="accordion animate__animated animate__fadeIn animate__delay-1s" id="accordionExample">
			  <div class="card">
			    <div class="card-header" id="headingOne">
			      <h2 class="mb-0">
			        <button class="btn btn-link" style="color: black" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          <h5>Assigned Volunteers</h5>
			        </button>
			      </h2>
			    </div>
			    <div>
						<?php 
						echo $rmalert; ?>
					</div>

			    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
			        <div class="card-body">
			        	<div class="col text-center">
						<!-- <button id="add-report" class="btn btn-outline-info mb-4" data-toggle="modal" data-target="#addReport">Add Report  <i class="fas fa-file-alt"></i></button> -->
							<form action="add-volunteer.php">
									<button class='btn btn-outline-info mb-4 btn-lg btncmn'>Add Volunteer <i class="fas fa-people-carry"></i></button>	
							</form>
							<!-- Modal Add report -->
							<!-- <div class="modal fade" id="addReport" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Add Report</h5>
										</div>
										<div class="modal-body">
											<p>Hii</p>
										</div>
									</div>
								</div>
							</div> -->
						</div>
						<div class="table-responsive">
							<table class="table table-striped" id="vol-table">
								<thead class="text-primary">
									<th>Name</th>
									<th>Task</th>
									<th>Action</th>
								</thead>
								<tbody id="tb-vol">
									<?php
										foreach ($data as $row) { ?>
											<form action="project-details.php" method="post">
												<tr>
													<td><?php
													echo $row["fullname"]; ?></td>
													<td><?php
													echo $row["task"]; ?></td>
													<td class="btn-group">
															<button id="vol-btn1" type="submit" class="btn btn-outline-secondary" title="Profile" name="profile" value = "<?php 
															echo $profile = $row["nric"]; ?>"><i class="fas fa-user-alt"></i></button>
															<button id="vol-btn1" type="submit" class="btn btn-outline-danger" title="Remove" name="remove" value = "<?php 
															echo $rmid = $row["vol_id"]; ?>" onclick = "return deletevol();"><i class="fas fa-trash-alt"></i></button>
													</td>
												</tr>
											</form>	
									<?php } ?>	
								</tbody>
							</table>
						</div>
			        </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header" id="headingTwo">
			      <h2 class="mb-0">
			        <button class="btn btn-link collapsed" style="color: black" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			          <h5>Meeting Reports</h5>
			        </button>
			      </h2>
			    </div>
			    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
			        <div class="card-body">
			      		<div class="col text-center">
						<!-- <button id="add-report" class="btn btn-outline-info mb-4" data-toggle="modal" data-target="#addReport">Add Report  <i class="fas fa-file-alt"></i></button> -->
							<button id="add-report" class="btn btn-outline-info mb-4 btn-lg btncmn" target="popup" onclick="window.open('add-report.html','popup','width=600,height=800,scrollbars=no,resizable=no')">Add New Report  <i class="fas fa-file-alt"></i></button>
							<!-- Modal Add report -->
							<!-- <div class="modal fade" id="addReport" tabindex="-1" role="dialog">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Add Report</h5>
										</div>
										<div class="modal-body">
											<p>Hii</p>
										</div>
									</div>
								</div>
							</div> -->
						</div>
			        	<div class="table-responsive">
							<table class="table table-striped" id="rp-table">
								<thead class="text-primary">
									<th>#ID</th>
									<th>Date</th>
									<th>Time</th>
									<th>Topic</th>
									<th>Action</th>
								</thead>
								<tbody id="tb-report">
									<tr>
										<td>RP1</td>
										<td>17/4/20</td>
										<td>10.30 am</td>
										<td>Sponsorship</td>
										<td class="btn-group">
											<a class="btn btn-outline-secondary" title="View Report" onclick="rpDetails(this)" href="report.html"><i class="fas fa-file"></i></a>
											<a class="btn btn-outline-danger" title="Delete" ><i class="fas fa-trash-alt"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
			        </div>
			    </div>
			  </div>
			</div>
			<br>
		</main>
	</div>
	<footer class="text-center text-light bg-dark">
		Copyright © 2020 huhu tools<br>
		<a href="mailto:info@huhu.com.my">info@huhu.com.my</a>
	</footer>
	<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript">
			var dataTab = document.getElementById('rp-table');
		function rpDetails(oButton){
			console.log(dataTab);
			console.log(dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells[0].innerHTML);
			var length = dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells.length;
			var tableData = new Array(dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells.length - 1);
			for (var i = 0; i < length - 1; i++) {
		        tableData[i] = dataTab.rows[oButton.parentNode.parentNode.rowIndex].cells[i].innerHTML;
		        console.log(tableData[i]);
		    }
		    // get tableData[0] / report ID
		    //show report based on report ID
		}

		function deleteRow(oButton){
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
		var dataTab2 = document.getElementById('vol-table');
		function deletevol(){
			  var txt;
			  var r = confirm("Are you sure you want to remove this volunteer from the project?");
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
				window.location.href = 'project-details.php';
		}

		$(document).ready(function(){
				
			});
			function upd_info(){
				$('#pj-time').prop('disabled',false);
				$('#pj-date').prop('disabled',false);
				$('#pj-obj').prop('disabled',false);
				$('#pj-loc').prop('disabled',false);
				$('#pj-dur').prop('disabled',false);
			}
			function info_submit(){
				$('#pj-time').prop('disabled',true);
				$('#pj-date').prop('disabled',true);
				$('#pj-obj').prop('disabled',true);
				$('#pj-loc').prop('disabled',true);
				$('#pj-dur').prop('disabled',true);

				upd_data();
			}
			function upd_data(){
				// update DB
			}


	</script>

</body>
</html>