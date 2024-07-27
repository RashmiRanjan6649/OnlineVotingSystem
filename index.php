<?php
require_once("admin/inc/config.php");
$fetchingElections = mysqli_query($db, "SELECT *FROM elections") or die(mysqli_error($db));
while($data =mysqli_fetch_assoc($fetchingElections))
{
	$starting_date=$data['starting_date'];
	$ending_date= $data['ending_date'];
	$curr_date= date("y-m-d");
	$election_id=$data['id'];
	$status= $data['status'];

	if($status=="Active")
{

$date1=date_create($curr_date);
$date2=date_create($ending_date);
$diff=date_diff($date1,$date2);
//echo $diff->format("%R%a");

if((int)$diff->format("%R%a") <0)
{
    //update
	mysqli_query($db, "UPDATE elections SET status='Expired' WHERE id='".$election_id."'")or die(mysqli_error($db));

}
	} 
	else if($status=="InActive")
	{
		$date1=date_create($curr_date);
$date2=date_create($starting_date);
$diff=date_diff($date1,$date2);
echo $diff->format("%R%a");

if((int)$diff->format("%R%a") <= 0)
{
    mysqli_query($db, "UPDATE elections SET status='Active' WHERE id='".$election_id."'")or die(mysqli_error($db));


}
	}else
	{

	}
}

?>


<!DOCTYPE html>
<html>
    
<head>
	<title>Login_Online voting system</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<!--Coded by Rashmi Ranjan-->
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<!-- <img src="https://cdn.freebiesupply.com/logos/large/2x/pinterest-circle-logo-png-transparent.png" class="brand_logo" alt="Logo"> -->
						<img src="assets\images\logo.jpeg" class="brand_logo" alt="Logo">
					</div>
				</div>
                <?php 
                    if(isset($_GET['sign-up']))
                    {
                        ?>
                        <div class="d-flex justify-content-center form_container">
					<form method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="su_username" class="form-control input_user" placeholder="username" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="text" name="su_contact_no" class="form-control input_pass" placeholder="contact No" required/>
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="su_password" class="form-control input_pass" placeholder="Password" required/>
						</div>
                        <div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype-Password" required/>
						</div> 
						
                        
						
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="sign_up_btn" class="btn login_btn" style="background-color:blue;">Sign Up</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links " style="color:rgb(54,54,199);">
						Already have an account? <a href="index.php" class="ml-2" style="color:rgb(54,54,199);" >Sign In</a>
					</div>
					<div class="d-flex justify-content-center links">
						<!-- <a href="#" class="text-white">Forgot your password?</a> -->
					</div>
				</div>
                        <?php
                    }
                    else{
                        ?>
                    
				<div class="d-flex justify-content-center form_container">
					<form method="POST">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="contact_no" class="form-control input_user"  placeholder="Contact NO" required/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" placeholder="password" required/>
						</div>
						
							<div class="d-flex justify-content-center mt-3 login_container">
				 	<button type="submit" name="loginBtn" class="btn login_btn" style="background:blue;">Login</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links" style="color:rgb(54,54,199);">
						Don't have an account? <a href="?sign-up=1" class="ml-2" style="color:rgb(54,54,199);">Sign Up</a>
					</div>
					<div class="d-flex justify-content-center links">
						<a href="#" style="color:rgb(54,54,199);">Forgot your password?</a>
					</div>
				</div>			
                <?php
                    }
                ?>
				<?php
				if(isset($_GET['registered']))
				{
				?>
				<span class="bg-white text-success text-center my-3">Your account has been created successsfullly</span>
				<?php }
				else if (isset($_GET['invalid'])){
				?>
				<span class="bg-white text-danger text-center my-3">passwords mismatched, please try again</span>
				<?php 
				} else if (isset($_GET['not_registered'])){
					?>
					<span class="bg-white text-warning text-center my-3">YOU ARE NOT REGISTERED</span>
					<?php 
					}else if (isset($_GET['invalid_access'])){
						?>
						<span class="bg-white text-danger text-center my-3">invalid username or password</span>
						<?php 
						}
				?>
				

			</div>
		</div>
	</div>
    <script src ="assets/js/jquery.min.js"></script>
    <script src= "assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php
	require_once("admin/inc/config.php");
	if(isset($_POST['sign_up_btn']))
	{	
		$su_username = mysqli_real_escape_string($db,$_POST['su_username']);
		$su_contact_no = mysqli_real_escape_string($db,$_POST['su_contact_no']);
		$su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
		$su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retype_password']));
		$user_role="Voter";
		
		if($su_password == $su_retype_password)
		{
			// insert query
			mysqli_query($db,"INSERT INTO users(username, contact_no, password, user_role) VALUES('".$su_username."','".$su_contact_no."','".$su_password."','".$user_role."')") or die(mysqli_error($db));
			?>
			<script>location.assign("index.php?sign-up=1&registered=1") </script>
			<?php

		}
		else{
			?>
			<script>location.assign("index.php?sign-up=1&invalid=1") </script>
	<?php
		}
	} else if(isset($_POST['loginBtn']))
	{
		$contact_no = mysqli_real_escape_string($db,$_POST['contact_no']);
		$password = mysqli_real_escape_string($db,sha1($_POST['password']));

		//Query /select quey
		$fetchingData = mysqli_query($db, "SELECT *FROM users WHERE contact_no= '".$contact_no."' ") or die(mysqli_error($db));
		$data = mysqli_fetch_assoc($fetchingData);

		if(mysqli_num_rows($fetchingData)>0)
		{
			//$data= mysqli_fetch_assoc($fetchingData);
			if($contact_no==$data['contact_no'] AND $password==$data['password'])
			{
				session_start();
				$_SESSION['user_role']= $data['user_role'];
				$_SESSION['username']= $data['username'];
				$_SESSION['user_id']= $data['id'];
				
				if($data['user_role']=="Admin")
				{	$_SESSION['key']= "AdminKey";
				?> <script>location.assign("admin/index.php?homepage=1");</script>
				<?php	
				}else{ 
					$_SESSION['key']= "VotersKey";
					?>
					<script>location.assign("voters/index.php");</script>
					<?php
				}
			} else{
				?>
				<script>location.assign("index.php?invalid_access=1") </script>
				<?php
			}
		} else{
			?>
			<script>location.assign("index.php?sign-up=1&not_registered=1") </script>
			<?php
			
		}
		
	}
	
?>
	