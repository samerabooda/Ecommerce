<?php
session_start();
$titlename='show item';
include 'init.php';

	$itemid =isset($_GET['itemid']) && is_numeric($_GET['itemid'])?$_GET['itemid']:0;

	$stmt = $db->prepare("SELECT items.* ,categories.Name AS catname,users.Username AS names
								FROM 
									items
								INNER JOIN categories ON categories.ID = items.Cat_ID
								
								INNER JOIN users ON	users.UserID = items.MemberID WHERE ItemID=? AND Approve=1");

	$stmt->execute(array($itemid));

	$count = $stmt->rowCount();

	if ($count > 0) { 
		$row = $stmt->fetch();

		?>
	<h1 class="text-center"><?= $row['Name']?></h1>
	<div class="container items">
		<div class="row">
			<div class="col-md-3">
				<img class="img-responsive" src="layout/img/img.png" alt="" />
			</div>
			<div class="col-md-9 item-info">
			<ul class="list-unstyled">
				<li><h2>Name : <?= $row['Name']?></h2></li>
				<li><p>Description :<?= $row['Descrption']?></p></li>
				<li><span>Price : $<?=$row['Price']?></span></li>
				<li><h4>Country Made : <?= $row['CountryMade']?></h4></li>
				<li><span>Datetoadd : <?=$row['addDate']?></span></li>
				<li><h4>CATNAME :<a href="categories.php?catid=<?=$row['Cat_ID']?>"> <?= $row['catname']?></a></h4></li>
				<li><h4>ADD BY : <a href="#"><?= $row['names']?></a></h4></li>

				<?php if(!empty($row['tags'])){
					$alltag = explode(",",$row['tags']);
					foreach ($alltag as $tag) {

					echo "<li> tages :";
					 echo "<a href='tags.php?name={$tag}'>";
					 echo $tag;
					 echo "</a></li>";
					}
				 ?>
			<?php } ?>
			</ul>

			</div>
		</div>
		<hr class="custom-hr">

		<?php if (isset($_SESSION['user'])) { ?>
		<div class="row">
			<div class="col-md-offset-3">
				<div class="add-comment">
				<form action="<?= $_SERVER['PHP_SELF'].'?itemid='. $row['ItemID']?>" method="POST">
					<h3>Add comments</h3>
					<textarea name="comment" class="form-control" ></textarea>
					<input class="btn btn-primary " type="submit" value="add comment">
					</form>

					<?php
						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								$comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
								$itemid = $row['ItemID'];
								$userid = $_SESSION['uid'];	


									if (!empty($comment)) {
								$stmt = $db->prepare("INSERT INTO comments(Comment,statues,Comment_date,item_id,user_id) VALUES(:comm,0,now(),:itid,:uid)");
								$stmt->execute(array(
									'comm' => $comment,
									'itid' => $itemid,
									'uid' => $userid,
								));	

								$count = $stmt->rowCount();
								if ($count > 0) {
									echo '<div class="alert alert-success">Comment sending </div>';
								}


							}


						}
					?>
			</div>
			</div>
			
		</div>
			<?php }else{
				echo '<a href="login.php">Login</a> or <a href="login.php">register</a> To ADD comments';
			} ?>

		<hr class="custom-hr">
		<?php
					$stmt=$db->prepare("SELECT comments.*,users.Username AS Member
										FROM comments 
										INNER JOIN users ON users.UserID=comments.user_id
										WHERE item_id=? AND statues=1
										");

					$stmt->execute(array($row['ItemID']));
					$rows=$stmt->fetchAll();
				?>
	
			<?php foreach ($rows as $com) { ?>
				<div class="comment-box">
						<div class="row">
					<div class="col-md-2 text-center">
						<img class="img-responsive img-circle" src="layout/img/img.png" alt="" />
						<?=$com['Member']?>
							
						</div>
					<div class="col-md-10">
						<p class="lead"><?=$com['Comment']?></p>
						</div>
					</div>
				</div>

					<hr>

			<?php } ?>

		</div>

	</div>
		</div>





<?php
	}else{
		echo '<div class="alert alert-danger">this is not found the item id or this items not Approve</div>';
	}
?>



<?php

	include $siteroot.'/footer.php';
?>