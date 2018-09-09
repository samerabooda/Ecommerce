<?php
session_start();
$titlename = 'Profile';
include 'init.php';
if (isset($_SESSION['user'])) {
 	
 	$getuser = $db->prepare("SELECT * FROM users WHERE Username=?");
 	$getuser->execute(array($_SESSION['user']));
 	$rows=$getuser->fetchAll(); 

?>
<h1 class="text-center">My Profile</h1>
	<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My Information</div>
				<div class="panel-body">
					<ul class="list-unstyled">
					<?php
						foreach ($rows as $row) {
							echo '<li>';
							echo'<i class="fa fa-unlock-alt fa-fw"></i>';
							echo'<span> Name :'.$row['Username'].'</span>';
							echo'</li>';


							echo '<li>';
							echo '<i class="fa fa-envelope-o fa-fw"></i> ';
							echo '<span> Email :'.$row['Email'].'</span>';
							echo '</li>';

							echo '<li>';
							echo '<i class="fa fa-user fa-fw"></i> ';
							echo '<span> fullname :'.$row['FullName'].'</span>';
							echo '</li>';

							echo '<li>';
							echo '<i class="fa fa-calendar fa-fw"></i> ';
							echo '<span> Date :'.$row['Date'].'</span>';
							echo '</li>';

							echo '<li>';
							echo '<i class="fa fa-envelope-o fa-fw"></i> ';
							echo '<span> favCats :</span>';
							echo '</li>';
						}
					?>
				</ul>
				</div>
			</div>
		</div>
	</div>	
		<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My-ADS</div>
				<div class="panel-body">
					<?php
					
				
				$Ads = getall("*","items","WHERE MemberID={$row['UserID']}","","ItemID");
				if (!empty($Ads)) {
				foreach ($Ads as $ads) {
					echo '<div class="col-sm-6 col-md-3">';
					if ($ads['Approve']==0) {
						echo 'not approve';
					}
						echo '<div class="thumbnail item-box">';
					
							echo '<span class="price-tag">'.$ads['Price'].'</span>';
							echo '<img class="img-responsive" src="layout/img/img.png" alt="" />';
							echo '<div class="caption">';
								echo '<h3><a href="item.php?itemid='.$ads['ItemID'].'">'.$ads['Name'].'</a>	</h3>';
								echo '<p>'.$ads['Descrption'].'</p>';
								echo '<div class="date">'.$ads['addDate'].'</div>';
							echo '</div>';

						echo '</div>';
					echo '</div>';
				}
			}else{
				echo 'Sorry this is no ads <a href="newAds.php">Add Ads</a>';
			}
					?>


				 </div>
			</div>
		</div>
	</div>	
		<div class="information block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">My-comments</div>
				<div class="panel-body">
					<?php
					$comments = getall("*","comments","WHERE user_id={$row['UserID']}","","Comment_ID");
					if (!empty($comments)) {
					foreach ($comments as $comment) {
					
						echo $comment['Comment'].'<br>';
						}
					}else{
						echo 'sorry this account no commnet';
					}
				
					?>
				</div>
			</div>
		</div>
	</div>	


<?php 
}else{
	header('location:login.php');
}
include "$siteroot/footer.php"; 
?>  