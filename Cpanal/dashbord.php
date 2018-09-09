<?php
session_start();
$titlename="Dashbord";
if(isset($_SESSION['username'])){
	include 'init.php';
			$limitUser = 5;
		$thelatestuser = latest('*','users','UserID',$limitUser);
			$limititem = 5;
		$thelatestitem = latest('*','items','itemID',$limititem);
?>	
	
		<div class="container text-center home-stat">
				<h1>Dashbord</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-member">
							<i class="fa fa-users"></i>
						<div class="info">
							Total members 
						<span>
							<a href="member.php"><?=countItem('UserID','users','')?></a>
						</span>
						</div>
						</div>		
					</div>
					<div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								Pending members
						<span>
							<a href="member.php?action=Manage&page=pending"><?=checkItem('Regstatues','users',0)?></a>
						</span>
							</div>
						 </div>		
					</div>
					<div class="col-md-3">
						<div class="stat st-item">
							<i class="fa fa-tag"></i>
							<div class="info">
							Total item 
							<span><a href="item.php"><?=countItem('itemID','items')?></a></span>
						</div>
						</div>		
					</div>
					<div class="col-md-3">
						<div class="stat st-comments">
							<i class="fa fa-comments"></i>
							<div class="info">
						Total comments
							<span><a href="comment.php"><?=countItem('Comment_id','comments')?></a></span>
						</div>
					</div>		
					</div>
				</div>
		</div>	
		<div class="latest">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i>Latest<?=$limitUser;?> Register user	
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latestusers">
								<?php
								foreach ($thelatestuser as $user) {
									echo '<li>';
									echo $user['Username'];
									echo '<a href = "member.php?action=Edit&userid='.$user['UserID'].'">';
									echo '<span class="btn btn-success pull-right">';
									echo '<i class="fa fa-edit"></i>Edit';
								 if ($user['Regstatues'] == 0) {
									echo"<a href='member.php?action=activate&userid=".$user['UserID']."' class='btn btn-info activate pull-right'><i class='fa fa-close'></i>Activate</a>";
									 }
									echo '</span>';
									echo '</a>';
									echo '</li>';
								}

								?>
								</ul>
							</div>	
							
						</div>
					</div>
						<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i>Latest <?= $limititem;?>items	
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
									<ul class="list-unstyled latestusers">
								<?php
								if (! empty($thelatestitem)) {
								foreach ($thelatestitem as $item) {
									echo '<li>';
									echo $item['Name'];
									echo '<a href = "item.php?action=Edit&itemid='.$item['ItemID'].'">';
									echo '<span class="btn btn-success pull-right">';
									echo '<i class="fa fa-edit"></i>Edit';
								 if ($item['Approve'] == 0) {
									echo"<a href='item.php?action=Approve&itemid=".$item['ItemID']."' class='btn btn-info activate pull-right'><i class='fa fa-close'></i>Approve</a>";
									 }
									echo '</span>';
									echo '</a>';
									echo '</li>';
								}
							}else{
								echo '<p>this is not found the item</p>';
							}
								?>
								</ul>
							</div>	
							
						</div>
					</div>
				</div>
					<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments"></i>Latestcomment	
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
									<?php
					$stmt =$db->prepare("SELECT comments.*,users.Username AS User_name FROM comments 	
								INNER JOIN users ON users.UserID = comments.user_id");
						$stmt->execute();
						$rows = $stmt->fetchAll();
						
								foreach ($rows as $comment) {
									echo '<div class="comment-box">';
										echo '<span class="member-n">'.$comment['User_name'].'</span>';
										echo '<p class="member-c">'.$comment['Comment'].'</p>';
									echo '</div>';
								}


								?>	
								
						
								
							
							</div>	
							
						</div>
					</div>
				</div>
			</div>
		</div>
	

	
	
<?php	
 include "$siteroot/footer.php"; 
}else{
	header('location: index.php');
	exit();
}
?>