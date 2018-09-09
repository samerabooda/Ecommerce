<?php
session_start();
$titlename="member";
if(isset($_SESSION['username'])){
	include 'init.php';

	$action = isset($_GET['action'])?$_GET['action']:'Manage';
	if($action == 'Manage'){//manage page
			$Query = '' ;
			if (isset($_GET['page']) && $_GET['page'] == 'pending') {
				$Query= 'AND Regstatues=0';
			}

		$stmt =$db->prepare("SELECT * FROM users WHERE GroupID !=1 $Query");
		$stmt->execute();
		$rows = $stmt->fetchAll();
	
	?>	
			<h1 class="text-center">manage member page </h1>
		<div class="container">
		<div class="table-responsive>">
			<table class="main-table manage-member text-center table table-bordered">
				<tr>
					<td>#ID</td>
					<td>#Avatar</td>
					<td>Username</td>
					<td>email</td>
					<td>fullname</td>
					<td>registerData</td>
					<td>Control</td>
				</tr>
				<?php
					foreach($rows as $row){
					echo '<tr>';
						echo "<td>" .$row['UserID']. "</td>";

						echo "<td>";
						if (empty($row['avatar'])) {
							echo 'no image';
						}else{
							echo "<img src='upload/avatar/" .$row['avatar']."'/>";
						}
						
						echo "</td>";
						echo "<td>" .$row['Username']. "</td>";
						echo "<td>" .$row['Email']. "</td>";
						echo "<td>" .$row['FullName']. "</td>";
						echo "<td> ".$row['Date']."</td>";
						
						echo "<td>
						<a href='member.php?action=Edit&userid=".$row['UserID']."' class='btn btn-success'><i class='fa fa-edit'></i>edit</a>
						<a href='member.php?action=delete&userid=".$row['UserID']."' class='btn btn-danger'><i class='fa fa-close'></i>delete</a>";
								if ($row['Regstatues']==0) {
								echo"<a href='member.php?action=activate&userid=".$row['UserID']."' class='btn btn-info activate'><i class='fa fa-close'></i>Activate</a>";				
								}

						echo "</td>";
					echo '</tr>';
					}
				?>	
			
			</table>
		</div>
			<a href='?action=Add' class="btn btn-primary"><i class="fa fa-plus"></i> new members</a>
			
		</div>
	<?php	
	}elseif($action == 'Add'){
		?>
			
			<h1 class="text-center">Add member</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=insert" method="POST" enctype="multipart/form-data">
			
			<!--start user name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">UserName</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end user name feild-->
					<!--start password feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-6">
							<input type="Password" name="password" class="password form-control" autocomplete="new-password"/>
							<i class="show-pass fa fa-eye fa-2x"></i>
						</div>	
				</div>
					<!--end PAsswordfeild-->
					<!--start Email feild-->	
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control" autocomplete="off"  required="required"/>
						</div>	
				</div>
					<!--end Email feild-->
					<!--start fullname feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Fullname</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="Full" class="form-control" autocomplete="off"  required="required"/>
						</div>	
				</div>
					<!--end userfullt user name feild-->
						<!--start avata feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Avatar</label>
						<div class="col-sm-10 col-md-6">
						<input type="file" name="avatar" class="form-control"/>
						</div>	
				</div>
					<!--end avata feild-->

				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add member" class="btn btn-primary"/>
						</div>	
				</div>
					<!--end user name feild-->
			</form>
		</div> 	

	<?php	
		
	}elseif($action == 'insert'){
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			echo"<h1 class='text-center'>Insert member</h1>";
			echo '<div class="container">';
				// to upload the files
			$avatarname = $_FILES['avatar']['name'];
			$avatartype =  $_FILES['avatar']['type'];
			$avatartmp_name =  $_FILES['avatar']['tmp_name'];
			$avatarsize =  $_FILES['avatar']['size'];

			$avatrallowedExtention = array('jpg','jpeg','png','gif');

			$avatarExtention = end(explode('.',$avatarname));
			
			$username=$_POST['username'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$fullname=$_POST['Full'];
			$avatarname = $_FILES['avatar']['name'];

			
			$hashpass = sha1($password);
			
			$formrerror = [];
			if(empty($username)){
				$formrerror[] = "please enter name";
			}
			if(empty($email)){
				$formrerror[] = "please enter email";
			}
			if(empty($fullname)){
				$formrerror[] = "please fixed fullname ";
			}
			if(empty($password)){
				$formrerror[] = "please fixed the password";
			}
			if (!empty($avatarname) && !in_array($avatarExtention , $avatrallowedExtention)) {
				$formrerror[] = "Sorry this wrong extention";
			}
			if (empty($avatarname)) {
				$formrerror[] = "Sorry this Avatar is required";
			}
			if ($avatarname > 4194304) {
				$formrerror[] = "Sorry this is file is large than 4 MB";
			}
			
			foreach ($formrerror as $error){
				echo '<div class="alert alert-danger">' . $error . '</div>';
			}

			if(empty($formrerror)){
					
					$avatar = rand(0,10000). '_' . $avatarname;
					move_uploaded_file($avatartmp_name, "upload\avatar\\".$avatar);
				
	
				// check the name is exists 
				$check = checkItem('Username','users',$username);

				if ($check == 1) {
					$themsg = "<div class='alert alert-danger'>Sorry This Name IS Exist</div>";
					redirectHome($themsg,'back');
				}else{
		//insert
				$stmt=$db->prepare("INSERT INTO users (Username,Password,Email,FullName,Date,avatar)VALUES(:user,:pass,:email,:full,now(),:avatar)");
				$stmt->execute(array(
				'user' => $username,
				'pass' => $hashpass,
				'email' => $email,
				'full' => $fullname,
				'avatar'=> $avatar,

				));
				$count=$stmt->rowCount();

				if($count > 0 ){
				$themsg="<div class='alert alert-success'>Add is Successful</div>";
				redirectHome($themsg,'back'); 
				}else{
				$themsg="<div class='alert alert-danger'>the Add is failed</div>";
				redirectHome($themsg,'back'); 
				}
				
			}
		}

	}else{
		echo "<div class='container'>";
			$themsg = "<div class='alert alert-danger'>YOU CANT LOG HERE DIRECTORY</div> ";
			redirectHome($themsg,'back','');
		}
		echo "</div>";
			
			echo '</div>';	
		}
	

	
	/*===============================================*/
	/*========the part special of edit and upate the data*/
	/*===============================================*/
	
	elseif($action == 'Edit'){//edit page	
		
		// CHECK IF THE REQUEST NUMERIC OR NOT 
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		//SELECT ALL DATABASE DEPEND ON ID
		$stmt=$db->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1 ");
		// EXECUTE THE QUERY
		$stmt->execute(array($userid));
		//FETCH THE DATA
		$row = $stmt->fetch();
		// THE ROW COUNT 
		$count = $stmt->rowCount();
		//IF FIND DATA SHOW THE FORM
		
		
	if($count > 0){	?>		
			<h1 class="text-center">Edit member</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=Apdate" method="POST">
			<input type="hidden" name="userid" value="<?= $userid ?>"/>
			<!--start user name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">UserName</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" value="<?=$row['Username']?>" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end user name feild-->
					<!--start password feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-6">
							<input type="hidden" name=" oldPassword" class="form-control" value="<?=$row['Password']?>" />
							<input type="Password" name="newPassword" class="form-control" autocomplete="new-password"/>
						</div>	
				</div>
					<!--end PAsswordfeild-->
					<!--start Email feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="email"  value="<?=$row['Email']?>" class="form-control" autocomplete="off"  required="required"/>
						</div>	
				</div>
					<!--end Email feild-->
					<!--start fullname feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Fullname</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="Full" value="<?=$row['FullName']?>" class="form-control" autocomplete="off"  required="required"/>
						</div>	
				</div>
					<!--end userfullt user name feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Save" class="btn btn-primary"/>
						</div>	
				</div>
					<!--end user name feild-->
			</form>
		</div> 		
<?php				
	}else{
		echo "<div class='container'>";
		$themsg = "<div class='alert alert-danger'>THEY NOT FOUNT THIS ID</div>";
		redirectHome($themsg);
		echo "</div>";
	}	
}elseif($action == 'Apdate'){
	echo"<h1 class='text-center'>Apdate member</h1>";
		echo '<div class="container">';
		// check the request post or not
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$Id       =$_POST['userid'];
			$username =$_POST['username'];
			$email    =$_POST['email'];
			$fullname =$_POST['Full'];
			// password trick
			$pass = empty($_POST['newPassword'])?$_POST['oldPassword']:sha1($_POST['newPassword']);
				
			$formrerror = [];
			if(empty($username)){
				$formrerror[] = "<div class='alert alert-danger'>please enter name</div>";
			}
			if(empty($email)){
				$formrerror[] = "<div class='alert alert-danger'>please enter email </div>";
			}
			if(empty($fullname)){
				$formrerror[] = "<div class='alert alert-danger'>please fixed fullname </div>";
			}
			if(empty($pass)){
				$formrerror[] = "<div class='alert alert-danger'>please fixed the password</div>";
			}
			
			foreach ($formrerror as $error){
				echo $error ;
			}
			if(empty($formrerror)){

					$stmt1=$db->prepare("SELECT * FROM users WHERE Username=? AND UserID!=?");
					$stmt1->execute(array($username,$Id));
			
					$count = $stmt1->rowCount();
					if ($count > 0) {
						$themsg="<div class='alert alert-danger'>the name is exist</div>";
							redirectHome($themsg,'back'); 	
					}else{
		//update 
			$stmt = $db->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID=?");
			$stmt->execute(array($username,$email,$fullname,$pass,$Id));
			
			$count = $stmt->rowCount();
			if($count > 0){

			$themsg="<div class='alert alert-success'>the update is succeful</div>";
			redirectHome($themsg,'back',4); 
			}else{
				$themsg="<div class='alert alert-danger'>the update is failed</div>";
				redirectHome($themsg,'back'); 
			}
		}
	}
		}else{
			$themsg="<div class='alert alert-danger'>YOU CANT LOG HERE DIRECTORY</div>";
			redirectHome($themsg,'',4); 
		}
		echo '</div>';
	}elseif($action=='delete'){
		echo"<h1 class='text-center'>Delete member</h1>";
		echo '<div class="container">';
		
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		//SELECT ALL DATABASE DEPEND ON ID
		$check = checkItem('userid','users',$userid);
		if ($check > 0) {
			$stmt = $db->prepare("DELETE FROM users WHERE UserID = :id");
			$stmt->bindParam(":id",$userid);
			$stmt->execute();
			
			$count = $stmt->rowCount();
			
			if($count > 0){
			$themsg="<div class='alert alert-success'>Delete Successful</div>";
			redirectHome($themsg,'back'); 
			}else{
				$themsg="<div class='alert alert-success'>Delete Failed</div>";
			redirectHome($themsg,'back'); 
			}
		}
		
		echo "</div>";
	
	}elseif ($action == 'activate') {
				echo"<h1 class='text-center'>Delete member</h1>";
		echo '<div class="container">';
		
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		//SELECT ALL DATABASE DEPEND ON ID
		$check = checkItem('userid','users',$userid);
		if ($check > 0) {
			$stmt = $db->prepare("UPDATE users SET Regstatues = 1 WHERE UserID = ?");
			$stmt->execute(array($userid));
			$count = $stmt->rowCount();
			
			if($count > 0){
			$themsg="<div class='alert alert-success'>Active is  Successful</div>";
			redirectHome($themsg,'back'); 
			}else{
				$themsg="<div class='alert alert-success'>Active is Failed</div>";
			redirectHome($themsg,'back'); 
			}
		}
		
		echo "</div>";




	}
	include "$siteroot/footer.php";
	
}else{
	header('location:index.php');
	exit();
}


?>


