<?php
session_start();
$titlename='comments';
if (isset($_SESSION['username'])) {
	include 'init.php';

$action = isset($_GET['action'])?$_GET['action']:'Manage';

if ($action == 'Manage') {
	
		$stmt =$db->prepare("SELECT comments.*,items.Name AS Item_Name,users.Username AS User_name FROM comments 
				INNER JOIN items ON items.ItemID = comments.item_id
				INNER JOIN users ON users.UserID = comments.user_id
				ORDER BY  Comment_id DESC
				");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		if (!empty($rows)) {
			?>
		<h1 class="text-center">manage comment page </h1>
		<div class="container">
		<div class="table-responsive>">
			<table class="main-table text-center table table-bordered">
				<tr>
					<td>com_ID</td>
					<td>Comment_name</td>
					<td>Comment_date</td>
					<td>item</td>
					<td>user</td>
					<td>Control</td>
				</tr>
				<?php
					foreach ($rows as $row) {
						echo '<tr>';
						echo "<td>" .$row['Comment_id']. "</td>";
						echo "<td>" .$row['Comment']. "</td>";
						echo "<td>" .$row['Comment_date']. "</td>";
						echo "<td>" .$row['Item_Name']. "</td>";
						echo "<td> ".$row['User_name']."</td>";
						
						echo "<td>
						<a href='comment.php?action=Edit&comid=".$row['Comment_id']."' class='btn btn-success'><i class='fa fa-edit'></i>edit</a>
						<a href='comment.php?action=delete&comid=".$row['Comment_id']."' class='btn btn-danger'><i class='fa fa-close'></i>delete</a>";
								if ($row['statues']==0) {
								echo"<a href='comment.php?action=Approve&comid=".$row['Comment_id']."' class='btn btn-info activate'><i class='fa fa-close'></i>Approve</a>";				
								}

						echo "</td>";
					echo '</tr>';
					}
					}else{
						echo '<p>this is not found the item</p>';
					}
				?>



			</table>
			</div>

			</div>	

<?php
}elseif($action == 'Edit'){

	$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;

	$stmt = $db->prepare("SELECT * FROM comments WHERE Comment_id=?");

	$stmt->execute(array($comid));

	$row = $stmt->fetch();

	$count = $stmt->rowCount();

	if ($count > 0) { ?>
			<h1 class="text-center">Edit comment</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=update" method="POST">
			<input type="hidden" name="comid" value="<?=$comid ?>">
			<!--start NameComment feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Comment</label>
						<div class="col-sm-10 col-md-6">
							<textarea id="comment" class="form-control" name="comment"><?php echo trim($row['Comment'])?></textarea>
						</div>	
				</div>
					<!--end NameComment feild-->
				
					<!--end visablty feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="edit item" class="btn btn-primary"/>
						</div>	
				</div>
					<!--end user name feild-->
			</form>
		</div> 		

<?php
}else{
	$themsg	 = '<div class="alert alert-danger">This id is not exist</div>';
	redirectHome($themsg);
	}		


}elseif($action == 'update'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo'<h1 class="text-center">Update Comment</h1>';
		echo'<div class="container">';

		$id 	=$_POST['comid'];
		$comment	=$_POST['comment'];


		$stmt = $db->prepare("UPDATE comments SET Comment=? WHERE Comment_id=?");

		$stmt->execute(array($comment,$id));

		$count = $stmt->rowCount();
		if ($count > 0) {
			$themsg ='<div class="alert alert-success"> the change is successful </div>';
				redirectHome($themsg,'back',3);
		}else{
			$themsg ='<div class="alert alert-danger"> the change is feiled </div>';
				redirectHome($themsg,'back',3);
		}

	}else{
		$themsg ='<div class="alert alert-danger">Sorry you cant Log here directory </div>';
				redirectHome($themsg,'back',3);
	}

}elseif($action == 'delete'){
	echo'<h1 class="text-center">delete Comment</h1>';
		echo'<div class="container">';

	$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;

	$check = checkItem('Comment_id','comments',$comid);

	if ($check > 0) {

		$stmt = $db->prepare("DELETE FROM comments WHERE Comment_id=:id");
		$stmt->bindparam(':id',$comid);
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

}elseif($action == 'Approve'){
	echo'<h1 class="text-center">Approve Comment</h1>';
		echo'<div class="container">';

$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])?intval($_GET['comid']):0;

	$check = checkItem('Comment_id','comments',$comid);

	if ($check > 0) {
		$stmt = $db->prepare("UPDATE comments SET statues=1 WHERE Comment_id=?");
		$stmt->execute(array($comid));
		$count = $stmt->rowCount();

			if($count > 0){
			$themsg="<div class='alert alert-success'>Approve Successful</div>";
			redirectHome($themsg,'back'); 
			}else{
				$themsg="<div class='alert alert-success'>Approve Failed</div>";
			redirectHome($themsg,'back'); 
			}
		
	}

	echo '</div>';	
}






include $siteroot.'/footer.php';
}else{
	header('location:index.php');
	exit();
}








?>