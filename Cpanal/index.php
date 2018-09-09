<?php
session_start();
$NOnavbar = '';
$titlename="login";

if(isset($_SESSION['username'])){
	header('location:dashbord.php');
}

include 'init.php'; 

	// sheck of user coming form http post requset
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$username=$_POST['user'];
		$password=$_POST['pass'];
		$hashpass=sha1($password);
		
		
	$stmt = $db->prepare("SELECT 
								UserID,Username, Password 
						 FROM 
						 		users 
						 WHERE 
						 		Username=? 
						 AND 
								Password=? 
						 AND 
						 		GroupID=1
						LIMIT 	1		
								
						");
	$stmt->execute(array($username,$hashpass));	
	$count = $stmt->rowCount();	
	$row = $stmt->fetch();	
		
		
	if($count > 0){
		$_SESSION['username']=$username;//register session name
		$_SESSION['id']=$row['UserID'];
		header('location:dashbord.php');//redirect to dashbord
		exit();		
		
	}
	}
?>
 
<form class="login" action="<?= $_SERVER['PHP_SELF']?>" method="POST" >
<h4 class="text-center">Admin Login</h4>
	<input class="form-control " type="text" name="user" placeholder="Username" autocomplete="off"/>
	<input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
	<input class="btn btn-primary btn-block" type="submit" value="login"/>
	
</form>



<?php include "$siteroot/footer.php"; ?>  