<?php  
session_start();
include_once("config.php");
$alert="";
$uname = $_SESSION['un'];
$email = $_SESSION['em'];
$volprof = $_SESSION['volprof'];
$volname="";
$volnric="";
$volage="";
$volnationality="";
$volphone="";
$volemail="";
$voladdress="";

//if (isset($_GET['profile'])) {
$sql2 = "SELECT * FROM volunteers WHERE nric = '$volprof'";
$result = mysqli_query($conn,$sql2);
$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
mysqli_free_result($result);

foreach ($data as $row) {
	$volname = $row['fullname'];
	$volnric = $row['nric'];
	$volage = $row['age'];
	$volnationality = $row['nationality'];
	$volphone = $row['phone'];
	$volemail = $row['email'];
	$voladdress = $row['address'];
}

if (isset($_POST['update'])) {
		$volname = htmlspecialchars($_POST['fullname']);
		$volnric = htmlspecialchars($_POST['nric']);
		$volage = htmlspecialchars($_POST['age']);
		$volnationality = htmlspecialchars($_POST['nationality']);
		$volphone = htmlspecialchars($_POST['pnumber']);
		$volemail = htmlspecialchars($_POST['email']);
		$voladdress = htmlspecialchars($_POST['address']);

		if (empty($volname) || empty($volnric) || empty($volage) || empty($volnationality) || empty($volphone) || empty($volemail) || empty($voladdress)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Information not be updated</div>";
		} else if(!filter_var($volemail, FILTER_VALIDATE_EMAIL)){
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid email.</div>";
		} elseif (!filter_var($volphone, FILTER_VALIDATE_INT)) {
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter a valid Phone number.</div>";
		} elseif (!filter_var($volage, FILTER_VALIDATE_INT)) {
			global $alert;
			$alert = "<div class=".'"alert alert-danger"'.">Please fill up the form properly. Enter valid age.</div>";
		} else {
				$sql = "UPDATE volunteers
						SET fullname = '$volname', age= '$volage', nationality= '$volnationality', phone= '$volphone', email= '$volemail', address= '$voladdress'
						WHERE nric = '$volnric'";
				if (mysqli_query($conn,$sql)) {
					global $alert;
					$alert = "<div class=".'"alert alert-success"'.">Volunteer information has been added updated.</div>";
				} else {
					global $alert;
					$alert = "<div class=".'"alert alert-danger"'.">Could not update the volunteer information.".mysqli_error($conn)."</div>";
				}
			

		}	
		
}
$rmalert="";
if (isset($_POST['remove'])) {
	$removesql = "DELETE FROM volunteers WHERE nric='$volnric'";
	if (mysqli_query($conn,$removesql)) {
		global $rmalert;
		echo $rmalert = "<div class=".'"alert alert-success"'.">Volunteer was removed successfully.</div>";
		$url = "volunteers.php";
		//header('Location: ' . $url);
		header('Location: ' . $url);
		} else {
					global $rmalert;
					echo $rmalert = "<div class=".'"alert alert-danger"'.">Could not remove the volunteer.".mysqli_error($conn)."</div>";
				}

} 

mysqli_close($conn);
	//}
//if (isset($_POST['update'])) {
//	echo "hi";
//} else {
	# code...
//}

		 
					
					//$updsql =  "UPDATE volunteers SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1;"

	//if (isset($_POST[])) {
		# code...
	//} else {
		# code...
	//}


//if (isset($_POST['update'])) {
			
//}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Volunteer Profile</title>
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
								<a class="nav-link navbtn active" href="volunteers.php">&nbsp Volunteers &nbsp </a>
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
							<span>Volunteer details</span>
							<span class="float-right">
							    <form action="volunteers.php">
							    	<button type="button" onclick="upd_profile()" class="btn btn-outline-info btncmn">Edit profile</button>
									<a href="" data-toggle="modal" data-target="#delete-vol" class="btn btn-danger btncmn">Remove Volunteer</a>
								</form>	
							</span>
						</h3>
						<hr>	
					</div>
					<div class="modal fade" id="delete-vol">
						<div class="modal-dialog">
							<div class="modal-content">
						    	<div class="modal-header">
						         	<h4 class="modal-title">Are you sure you want to remove this volunteer?</h4>
						        	<button type="button" class="close" data-dismiss="modal">&times;</button>
						        </div>
						        <div class="modal-body">
						        	<p class="text-danger font-italic"><small>*This will remove all data related to this person.</small></p>
						        </div>
						        <div class="modal-footer">
						            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
						            <form method="post", action="volunteer-profile.php">
						            	<input type="submit" class="btn btn-danger" value="Remove" name="remove">
						            </form>
						        </div>
						    </div>
						</div>
					</div>
					<form method="post" action="volunteer-profile.php">
					<div>
						<?php 
						echo $alert; ?>
					</div>
					<div class="animate__animated animate__fadeIn animate__delay-1s">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Full Name</label>
									<div class="col-sm-9">
										<input id="vol_fname" type="text" class="form-control" value="<?php echo $volname; ?>" autocomplete="off" name="fullname" readonly>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">NRIC</label>
									<div class="col-sm-9">
										<input id="vol_nric" type="text" class="form-control" value="<?php echo $volnric; ?>" autocomplete="off" name="nric" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Age</label>
									<div class="col-sm-9">
										<input id="vol_age" type="number" class="form-control" value="<?php echo $volage; ?>" autocomplete="off" name="age" readonly>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Nationality</label>
									<div class="col-sm-9">
										<input id="vol_nat" type="text" class="form-control" value="<?php echo $volnationality; ?>" autocomplete="off" name="nationality" readonly>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Phone Number</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">+60</span>
										</div>
										<input id="vol_phone" type="text" class="form-control" value="<?php echo $volphone; ?>"autocomplete="off" name="pnumber" readonly>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Email</label>
									<input id="vol_em" type="email" class="form-control" value="<?php echo $volemail; ?>"autocomplete="off" name="email" readonly>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group row">
								<label>Address</label>
								<input type="text" id="vol_address" class="form-control" value="<?php echo $voladdress; ?>" name="address" readonly>
							</div>
						</div>
						<div class="text-center mt-5">
							<input type="submit" id="updateBtn" onclick="upd_submit()" class="btn btn-outline-success btn-lg btncmn" value="Update" name="update" disabled="">
						</div>
						<br>
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
			
			$(document).ready(function(){
				
			});
			function upd_profile(){
				$('#vol_fname').prop('readonly',false);
				$('#vol_id').prop('readonly',true);
				$('#vol_phone').prop('readonly',false);
				$('#vol_address').prop('readonly',false);
				$('#vol_em').prop('readonly',false);
				$('#vol_age').prop('readonly',false);
				$('#vol_nat').prop('readonly',false);
				$('#updateBtn').prop('disabled',false);
				$('#updateBtn').prop('readonly',false);

			}
			function upd_submit(){
				$('#vol_fname').prop('readonly',true);
				$('#vol_id').prop('readonly',true);
				$('#vol_phone').prop('readonly',true);
				$('#vol_address').prop('readonly',true);
				$('#vol_em').prop('readonly',true);
				$('#vol_age').prop('readonly',true);
				$('#vol_nat').prop('readonly',true);
				$('#updateBtn').prop('readonly',true);

				//upd_data();
			}
			//function upd_data(){}
				//<?php
				//echo "THIS". $volname;
				// global $volage;
				// echo "THIS". $_GET['profile'];	
				//global $volnationality;
				//global $volphone;
				//global $volemail;
				//global $voladdress;
				//if (empty($_POST['fname']) || empty($_POST['nric']) || empty($_POST['age']) ||  empty($_POST['pnumber']) || empty($_POST['vemail']) || empty($_POST['address'])){
				//			global $alert;
				//			$alert = "<div class=".'"p-3 mb-2 bg-danger text-white"'.">Please fill up the form properly.</div>";
			//	}else{
			//		$volname = $_POST['fname'];
			///		$volage = $_POST['age'];
			//		$volnationality = $_POST['nationality'];
			//		$volphone = $_POST['pnumber'];
			//		$volemail = $_POST['vemail'];
			//		$voladdress = $_POST['address'];

			//		echo $volemail;
			///	}	 
				 ?>
		}

		</script>
	</body>
</html>