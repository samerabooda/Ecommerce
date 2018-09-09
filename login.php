<?php
session_start();
$titlename = 'login';
include 'init.php';

if (isset($_SESSION['user'])) {
	header('location:index.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD']=='POST') {

	if (isset($_POST['login'])) {

		$user = $_POST['user'];
		$password = $_POST['pass'];
		$hashpass = sha1($password);

		$stmt = $db->prepare("SELECT UserID,Username,Password FROM users WHERE Username=? AND Password=?");
		$stmt->execute(array($user,$hashpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count > 0) {
			$_SESSION['user']=$user;
			$_SESSION['uid']=$row['UserID'];
			header('location:index.php');
			exit();
			}

		}else{

			if (isset($_POST['signup'])) {
					$formerror = [];

					$Username = $_POST['username'];
					$pass1 = $_POST['password'];
					$pass2= $_POST['password2'];
					$email = $_POST['email'];
					// to hash the password
					$hashpass1 = sha1($pass1);
					$hashpass2 = sha1($pass2);
					// to filter to inputs
					$filteruser = filter_var($Username,FILTER_SANITIZE_STRING);
					$filteremail = filter_var($email,FILTER_SANITIZE_EMAIL);

						if (strlen($filteruser) < 4 ) {
						$formerror[] = 'Username can\'t be less 4 characters';

							}	
					if (filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true) {
							$formerror[] = 'email is not vailed';
						}		
							
						if (empty($pass1)) {
							$formerror[] = 'Please the password is empty';
						}

						if ($hashpass1 !== $hashpass2) {
							$formerror[] = 'Password is diffrents';

						}
						if (empty($formerror)) {
							
						$check = checkItem('Username','users',$Username);

						if ($check == 1) {
							$formerror[] = 'sorry this name is exist the database';
						}else{


			$stmt = $db->prepare("INSERT INTO users(Username,Password,Email,Regstatues,Date)VALUES(:user,:pass,:email,0,now())");
			$stmt->execute(array(
				'user' => $Username,
				'pass' => $hashpass1,
				'email' => $email	,
			));				
				
				$themsg ='sigined is successfled'; 
					
					}
				}
			}

		}

	}


?>

<div class="container login-page">
	<h1 class="text-center text">
		<span class="selected" data-class="login">Login</span> | 
		<span data-class="signup">SignUp</span>
	</h1>

<!--start login form -->
<form class="login" action="<?=$_SERVER['PHP_SELF']?>" method="POST" >
		
	<input class="form-control " type="text" name="user" placeholder="Username" autocomplete="off"/>
	<input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
	<input class="btn btn-primary btn-block" name="login" type="submit" value="login"/>
	
</form>
<!--end login form -->
<!--start signup form -->

<form class="signup" action="<?=$_SERVER['PHP_SELF']?>" method="POST" >
	<input pattern=".{4,}" title="please check the error" class="form-control " type="text" name="username" placeholder="Username" autocomplete="off" required="" />
	<input class="form-control" type="password" name="password" placeholder="password" autocomplete="new-password" required="" />
	<input class="form-control" type="password" name="password2" placeholder="password againe" autocomplete="new-password" required="" />
	<input class="form-control" type="text" name="email" placeholder="Email" autocomplete="off" required="" />
	<input class="btn btn-success btn-block" name="signup" type="submit" value="SignUp"/>
	
</form>
<!--end signup form -->
</div>
	<div class="error text-center">
		<?php
		if (!empty($formerror)){	
			foreach ($formerror as $error) {
			 
			echo $error .'<br>';
		}
	}

	if (isset($themsg)) {
		echo $themsg;
	}
		?>	

	</div>
<?php
include $siteroot.'/footer.php'; 
?>