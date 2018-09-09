<?php
session_start();
$titlename='Items';
if (isset($_SESSION['username'])) {
	include 'init.php';

$action = isset($_GET['action'])?$_GET['action']:'Manage';

if ($action == 'Manage') {
 	
 	$stmt = $db->prepare("SELECT items.*,categories.Name AS cat_name,users.Username FROM items
 		INNER JOIN categories ON categories.ID = items.Cat_ID
 		INNER JOIN users ON users.UserID = items.MemberID
 	 ");
 	$stmt->execute();
 	$rows=$stmt->fetchAll();
 	$count = $stmt->rowCount();
	if (!empty($rows)) {
 	if ($count > 0) { 
 			
 		?>
		<h1 class="text-center">manage item page </h1>
		<div class="container">
		<div class="table-responsive>">
			<table class="main-table text-center table table-bordered">
				<tr>
					<td>#ID</td>
					<td>Name</td>
					<td>Description</td>
					<td>price</td>
					<td>addDate</td>
					<td>CountryMade</td>
					<td>Cat_Name</td>
					<td>username</td>
					<td>Control</td>
				</tr> 	
				<?php
				foreach ($rows as $row) {
					echo "<tr>";
						echo "<td>".$row['ItemID']."</td>";
						echo "<td>".$row['Name']."</td>";
						echo "<td>".$row['Descrption']."</td>";
						echo "<td>".$row['Price']."</td>";
						echo "<td>".$row['addDate']."</td>";
						echo "<td>".$row['CountryMade']."</td>";
						echo "<td>".$row['cat_name']."</td>";
						echo "<td>".$row['Username']."</td>";


						echo "<td>
						<a href='item.php?action=Edit&itemid=".$row['ItemID']."' class='btn btn-success'><i class='fa fa-edit'></i>edit</a>
						<a href='item.php?action=delete&itemid=".$row['ItemID']."' class='btn btn-danger'><i class='fa fa-close'></i>delete</a>";
						if ($row['Approve']==0) {
						echo "<a href='item.php?action=Approve&itemid=".$row['ItemID']."' class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";

						}
					
							echo "</td>";
					echo "</tr>";
				}
			}
 			}else{
				echo '<p>this is not found the item</p>';
			}
 			?>
 		</table>
 	</div>
 		<a href='?action=Add' class="btn btn-primary"><i class="fa fa-plus"></i> new item</a>
 </div>


<?php

 } elseif ($action == 'Add') { ?>
 	
	<h1 class="text-center">Add Items</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=insert" method="POST">
			
			<!--start  name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end name feild-->
				<!--start Descrition feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Descrption feild-->	
					<!--start Descrition feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Country feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">CountryMade</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="country" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Country feild-->
						<!--end Country feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Statues</label>
						<div class="col-sm-10 col-md-6">
							<select  name="statues">
								<option value="0">....</option>
								<option value="1">new</option>
								<option value="2">like new</option>
								<option value="3">used</option>	
								<option value="4">old</option>
							</select>	
						</div>	
				</div>
					<!--end Country feild-->		
					<!--start member feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select  name="member">
								<option value="0">....</option>
								<?php
								$getuser = getall("*","users","","","UserID");
								foreach ($getuser as $user) {
									echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";
								}
								?>
							</select>	
						</div>	
				</div>
					<!--end members feild-->		
						<!--start category feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">category</label>
						<div class="col-sm-10 col-md-6">
							<select  name="category">
								<option value="0">....</option>
								<?php
								$getcat = getall("*","categories","WHERE Parent=0","","ID");
								foreach ($getcat as $cat) {
									echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
								 $getchild= getall("*","categories","WHERE Parent={$cat['ID']}","","ID");
								 foreach ($getchild as $child) {
	echo "<option value='".$child['ID']."'>--".$child['Name']."child form".$cat['Name']."</option>";

								 }
								}
								?>
							</select>	
						</div>	
				</div>
					<!--end category feild-->	
					<!--start tags feild-->	
						<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">tags</label>
						<div class="col-sm-10 col-md-6">
							<input name="tags" id="tags" class="form-control" />
						</div>	
				</div>
					<!--end tags feild-->		
					<!--start submit feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Items" class="btn btn-primary" />
						</div>	
				</div>
					<!--end submit feild-->
			</form>
		</div> 		
<?php
 } elseif ($action == 'insert') { 

		if($_SERVER['REQUEST_METHOD']=='POST'){
			echo"<h1 class='text-center'>Insert Item</h1>";
			echo '<div class="container">';
			
			$name=$_POST['name'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$country=$_POST['country'];
			$statue=$_POST['statues'];
			$member=$_POST['member'];
			$category=$_POST['category'];
			$tags=$_POST['tags'];
			
			
		
			
			$formrerror = [];

			if(empty($name)){
				$formrerror[] = "please this feiled is <strong>name of item</strong> empty";
			}
			if(empty($description)){
				$formrerror[] = "please this feiled is <strong>description of item</strong> empty";
			}
			if(empty($price)){
				$formrerror[] = "please this feiled is <strong>price of item</strong> empty";
			}
			if(empty($country)){
				$formrerror[] = "please this feiled is <strong>country of item</strong> empty";
			}
				if(empty($statue)){
				$formrerror[] = "please this feiled is <strong>statue of item</strong> empty";
			}
				if(empty($member)){
				$formrerror[] = "please this feiled is <strong>member of item</strong> empty";
			}
				if(empty($category)){
				$formrerror[] = "please this feiled is <strong>category of item</strong> empty";
			}
			foreach ($formrerror as $error){
				echo '<div class="alert alert-danger">' . $error . '</div>';
			}

			if(empty($formrerror)){
		//insert
				$stmt=$db->prepare("INSERT INTO items(Name,Descrption,Price,CountryMade,statues,addDate,MemberID,Cat_ID,tags)VALUE(:name,:des,:price,:country,:statue,now(),:member,:cat,:tag)");
				$stmt->execute(array(
				'name' => $name,
				'des' => $description,
				'price' => $price,
				'country' => $country,
				'statue' => $statue,
				'member' => $member,
				'cat'   => $category,
				'tag'   => $tags,

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
		

	}else{
		echo "<div class='container'>";
			$themsg = "<div class='alert alert-danger'>YOU CANT LOG HERE DIRECTORY</div> ";
			redirectHome($themsg,'back','');
		}
		echo "</div>";
			
			echo '</div>';		

 } elseif ($action == 'Edit') {

 		$itemid = isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;

 		$stmt = $db->prepare("SELECT * FROM items WHERE itemID=?");

 		$stmt->execute(array($itemid));

 		$row = $stmt->fetch();

 		$count = $stmt->rowCount();

 		if ($count > 0) {
 	?>
 	<h1 class="text-center">Edit Items</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=update" method="POST">
			<input type="hidden" name="itemid" value="<?=$itemid?>">
			<!--start  name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" value="<?=$row['Name']?>" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end name feild-->
				<!--start Descrition feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" value="<?=$row['Descrption']?>" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Descrption feild-->	
					<!--start Descrition feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="price" value="<?=$row['Price']?>" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Country feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">CountryMade</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="country" value="<?=$row['CountryMade']?>" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end Country feild-->
						<!--end Country feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Statues</label>
						<div class="col-sm-10 col-md-6">
							<select  name="statues">
								<option value="1"<?php if($row['statues']==1){echo 'selected';}?>>new</option>
							<option value="2"<?php if($row['statues']==2){echo 'selected';}?>>like new</option>
								<option value="3"<?php if($row['statues']==3){echo 'selected';}?>>used</option>	
								<option value="4"<?php if($row['statues']==4){echo 'selected';}?>>old</option>
							</select>	
						</div>	
				</div>
					<!--end Country feild-->		
					<!--start member feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select  name="member">
								<?php
								$getalluser = getall('*','users','','','UserID');					
								foreach ($getalluser as $user) {
									echo "<option value='".$user['UserID']."'";
									if($row['MemberID']==$user['UserID']){echo 'selected';}
									echo ">".$user['Username']."</option>";
								}
								?>
							</select>	
						</div>	
				</div>
					<!--end members feild-->		
						<!--start category feild-->	
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">category</label>
						<div class="col-sm-10 col-md-6">
							<select  name="category">
								<?php
								$getallcat = getall('*','categories','','','ID');
								foreach ($getallcat as $cat) {
									echo "<option value='".$cat['ID']."'";
									if( $row['Cat_ID'] == $cat['ID'] ){echo 'selected';}
									echo ">".$cat['Name']."</option>";
								}
								?>
							</select>	
						</div>	
				</div>
					<!--end category feild-->		
					<!--start tags feild-->	
						<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">tags</label>
						<div class="col-sm-10 col-md-6">
							<input name="tags" id="tags" class="form-control" value="<?=$row['tags']?>" />
						</div>	
				</div>
					<!--end tags feild-->
					<!--start submit feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Items" class="btn btn-primary" />
						</div>	
				</div>
					<!--end submit feild-->
			</form>
			<?php
				$stmt =$db->prepare("SELECT comments.*,users.Username AS User_name FROM comments 
							
				INNER JOIN users ON users.UserID = comments.user_id
				WHERE item_id=?

				");
		$stmt->execute(array($itemid));
		$rows = $stmt->fetchAll();
		if (!empty($rows)) {
		?>
			<h1 class="text-center">manage <?=$row['Name']?> Comment</h1>
		
		<div class="table-responsive>">
			<table class="main-table text-center table table-bordered">
				<tr>
					<td>Comment_name</td>
					<td>Comment_date</td>
					<td>user</td>
					<td>Control</td>
				</tr>
				<?php
					foreach ($rows as $row) {
						echo '<tr>';
				
						echo "<td>" .$row['Comment']. "</td>";
						echo "<td>" .$row['Comment_date']. "</td>";
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
			}
				?>



			</table>
			</div>

			
		</div> 		

<?php
}
 } elseif ($action == 'update') {
 		if($_SERVER['REQUEST_METHOD']=='POST'){
			echo"<h1 class='text-center'>update Item</h1>";
			echo '<div class="container">';

		$id 			=$_POST['itemid'];
		$name     		= $_POST['name'];
		$description 	= $_POST['description'];
		$price 			= $_POST['price'];
		$country 		=$_POST['country'];
		$statue 		=$_POST['statues'];
		$member 		= $_POST['member'];
		$category 		= $_POST['category'];
		$tags			= $_POST['tags'];


		$stmt = $db->prepare("UPDATE items SET Name=?,Descrption=?,Price=?,CountryMade=?,statues=?,MemberID=?,Cat_ID=?,tags=? WHERE itemID=?");

		$stmt->execute(array($name,$description,$price,$country,$statue,$member,$category,$tags,$id));

		$count = $stmt->rowCount();

		if ($count > 0) {
			
				$themsg="<div class='alert alert-success'>update is Successful</div>";
				redirectHome($themsg,'back'); 
				}else{
				$themsg="<div class='alert alert-danger'>the update is failed</div>";
				redirectHome($themsg,'back'); 
				}

		}
			echo'</div>';

}  elseif ($action == 'delete') {
 			echo'<h1 class="text-center">delete item</h1>';
			echo'<div class="container">';

	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;

		$check = checkItem('itemID','items',$itemid);

	if ($check > 0) {
		
		$stmt = $db->prepare("DELETE FROM items WHERE itemID=:id");

		$stmt->bindparam(':id',$itemid);

		$stmt->execute();

		$count = $stmt->rowCount();

		if ($count > 0) {
			$themsg ='<div class="alert alert-success"> delete items is successful </div>';
				redirectHome($themsg,'back',3);
		}else{
			$themsg ='<div class="alert alert-danger"> delete items is field </div>';
				redirectHome($themsg,'back',3);
		}
	}
			echo '</div>';
}elseif ($action == 'Approve') {
 		echo'<h1 class="text-center">Approve item</h1>';
			echo'<div class="container">';

	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;

		$check = checkItem('itemID','items',$itemid);

	if ($check > 0) {

	$stmt = $db->prepare("UPDATE items SET Approve = 1 WHERE itemID = ?");

	$stmt->execute(array($itemid));

		$count = $stmt->rowCount();

		if ($count > 0) {
			$themsg ='<div class="alert alert-success"> Approve items is successful </div>';
				redirectHome($themsg,'back',3);
		}else{
			$themsg ='<div class="alert alert-danger"> Approve items is field </div>';
				redirectHome($themsg,'back',3);
		}
		
		 }

}
	include $siteroot.'/footer.php';	
}else{
	header('location:index.php');
	exit();
}










?>