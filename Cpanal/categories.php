<?php
session_start();
$titlename = 'categories';

if (isset($_SESSION['username'])) {
	include 'init.php';

$action = isset($_GET['action'])?$_GET['action']:'Manage';

if ($action == 'Manage') {

	$sort = 'ASC';
	$sort_order = array('ASC','DESC');
		if(isset($_GET['order']) && in_array($_GET['order'], $sort_order)){
			$sort = $_GET['order'];
		}

		$rows = getall('*','categories','WHERE Parent = 0','','Ordering',$sort);
?>
	<h1 class="text-center">Categories</h1>
	<div class="container categories">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-edit"></i>Manage Categories
				<div class="ordering pull-right"><i class="fa fa-sort"></i>Ordering :
				<a class="<?php if($sort == 'ASC'){ echo 'active'; }?>" href="?order=ASC">Asc</a>|
				<a class="<?php if($sort == 'DESC'){ echo 'active'; }?>" href="?order=DESC">Desc</a>
			</div>
			</div>
			<div class="panel-body">
				<?php	
					foreach ($rows as $row) {

						echo '<div class="categ">';
						echo "<div class ='hidden-button'>";
							echo "<a href='?action=Edit&catid=".$row['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>edit</a> ";

							echo "<a href='?action=delete&catid=".$row['ID']."' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>delete</a> ";

						echo "</div>";
						echo '<h3>'.$row['Name'].'</h3>';
						echo "<p>";if (empty($row['Descrption'])) {
							echo "this is no description";
								}else{
									echo $row['Descrption'];
								}
							echo "</p>";
						if ($row['Visablty'] == 1 ) {
							echo '<span class = "visablty"><i class="fa fa-eye"></i> visable is hidden</span>';
						}
						if ($row['Allow_Comment'] == 1 ) {
							echo '<span class = "comment"> <i class="fa fa-close"></i>Comment disapled</span>';
						}
							if ($row['Allow_Ads'] == 1 ) {
							echo '<span class = "ads"> <i class="fa fa-close"></i>ads disapled</span>';
						}
						
						echo '</div>';
					 $cats = getall("*","categories","WHERE Parent={$row['ID']}","","ID");
						 if (! empty($cats)) {
						 	echo '<h4>Child categories</h4>';
						 		foreach ($cats as $cat) {
						 	echo "<a href='?action=Edit&catid=".$cat['ID']."'>".$cat['Name']."</a>";
						 	echo "<a class='show-delete' href='?action=delete&catid=".$cat['ID']."'> delete</a> ";
						 		}
			 				}				



						echo '<hr>';

					}

				?>
			</div>	
		</div>
		<a href="?action=add" class="add-category btn btn-primary"><i class="fa fa-plus"></i>Add new categories</a>
</div>


<?php	
}elseif ($action == 'add') { ?>
		<h1 class="text-center">Add Cateogries</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=insert" method="POST">
			
			<!--start user name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required"/>
						</div>	
				</div>
					<!--end user name feild-->
					<!--start Descrption feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control"/>
						</div>	
				</div>
					<!--end Descrption-->

					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Parents</label>
						<div class="col-sm-10 col-md-6">
							<select name="Parent">
								<option value="0">None</option>
								<?php
							$cats = getall('*','categories','WHERE Parent=0','','ID','ASC');
								foreach ($cats as $cat) {
									echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
								}
								?>
							</select>
						</div>	
				</div>
					<!--start order feild-->	
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Order</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="order" class="form-control" autocomplete="off"/>
						</div>	
				</div>
					<!--end order feild-->
					<!--start visabilty feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Visable</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visbilty" value="0" checked/>
								<label for="vis-yes">yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="visbilty" value="1"/>
								<label for="vis-no">no</label>
							</div>
						</div>	
				</div>
					<!--end visablty feild-->
					<!--start comminting feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label"> Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="comminting" value="0" checked/>
								<label for="com-yes">yes</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="comminting" value="1"/>
								<label for="com-no">no</label>
							</div>
						</div>	
				</div>
					<!--end commenting feild-->
						<!--start Ads feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="Ads-yes" type="radio" name="Ads" value="0" checked/>
								<label for="Ads-yes">yes</label>
							</div>
							<div>
								<input id="Ads-no" type="radio" name="Ads" value="1"/>
								<label for="Ads-no">no</label>
							</div>
						</div>	
				</div>
					<!--end visablty feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Cateogries" class="btn btn-primary"/>
						</div>	
				</div>
					<!--end user name feild-->
			</form>
		</div> 		


<?php	
}elseif ($action == 'insert') {
	echo'<h1 class="text-center">Add Cateogries</h1>';
	echo'<div class="container">';
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$parent		= $_POST['Parent'];
				$order 		= $_POST['order'];
				$visable 	= $_POST['visbilty'];
				$comment 	= $_POST['comminting'];
				$Ads 		= $_POST['Ads'];
				

		$check = checkItem('Name','categories',$name);		
		if ($check > 0) {
			$themsg ='<div class="alert alert-danger">Sorry this categories is Exist </div>';
				redirectHome($themsg,'back',3);
		}else{

			$stmt = $db->prepare("INSERT INTO categories(Name,Descrption,Parent,Ordering,Visablty,Allow_Comment,Allow_Ads)VALUE(:zname,:zdesc,:zparent,:zorder,:zvisale,:zcomment,:zads)");

			$stmt->execute(array(
				'zname'   => $name,
				'zdesc'   => $desc,
				'zparent' => $parent,
				'zorder'  => $order,
				'zvisale' => $visable,
				'zcomment'=> $comment,
				'zads'    => $Ads,
			));

			$count = $stmt->rowCount();
			if ($count > 0) {
				$themsg ='<div class="alert alert-success"> the add is categories is successful </div>';
				redirectHome($themsg,'back',3);
			}else{
				$themsg ='<div class="alert alert-success"> the add is categories is feiled </div>';
				redirectHome($themsg,'back',3);
			}

		}
			}else{
				$themsg ='<div class="alert alert-danger">Sorry you cant Log here directory </div>';
				redirectHome($themsg,'back',3);
			}

	echo '</div>';		
	
}elseif ($action == 'Edit') {

	$catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;

	$stmt = $db->prepare("SELECT * FROM categories WHERE ID = ?");

	$stmt->execute(array($catid));

	$cats = $stmt->fetch();

	$count = $stmt->rowCount();

	if ($count > 0) { ?>
		<h1 class="text-center">Edit Cateogries</h1>
		<div class="container">
			<form class="form-horizontal" action="?action=update" method="POST">
			<input type="hidden" name="catid" value="<?=$catid ?>">
			<!--start user name feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" required="required" value="<?=$cats['Name']?>" />
						</div>	
				</div>
					<!--end user name feild-->
					<!--start DEsc feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" value="<?=$cats['Descrption']?>"/>
						</div>	
				</div>
					<!--end Descfeild-->
					<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Parents</label>
						<div class="col-sm-10 col-md-6">
							<select name="Parent">
								<option value="0">None</option>
								<?php
							$c = getall("*","categories","WHERE Parent= 0","","ID","ASC");
								foreach ($c as $c1) {
									echo "<option value='".$c1['ID']."'";
									if ($cats['Parent']==$c1['ID']) {
										echo 'selected';
									}
									echo ">".$c1['Name'] ."</option>";
								}
								?>
							</select>
						</div>	
					</div>

					<!--start Email feild-->	
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Order</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="order" class="form-control" value="<?=$cats['Ordering']?>"/>
						</div>	
				</div>
					<!--end Email feild-->
					<!--start visabilty feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Visable</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visbilty" value="0" <?php 
									if ($cats['Visablty'] == 0) {echo 'checked';}?>/>
								<label for="vis-yes">yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="visbilty" value="1" <?php 
									if ($cats['Visablty'] == 1) {echo 'checked';}?>/>
								<label for="vis-no">no</label>
							</div>
						</div>	
				</div>
					<!--end visablty feild-->
					<!--start comminting feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label"> Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="comminting" value="0" <?php 
									if ($cats['Allow_Comment'] == 0) {echo 'checked';}?>/>
								<label for="com-yes">yes</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="comminting" value="1" <?php 
									if ($cats['Allow_Comment'] ==1) {echo 'checked';}?> />
								<label for="com-no">no</label>
							</div>
						</div>	
				</div>
					<!--end commenting feild-->
						<!--start Ads feild-->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="Ads-yes" type="radio" name="Ads" value="0" <?php 
									if ($cats['Allow_Ads'] == 0) {echo 'checked';}?>/>
								<label for="Ads-yes">yes</label>
							</div>
							<div>
								<input id="Ads-no" type="radio" name="Ads" value="1" <?php 
									if ($cats['Allow_Ads'] == 1) {echo 'checked';}?>/>
								<label for="Ads-no">no</label>
							</div>
						</div>	
				</div>
					<!--end visablty feild-->
				<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Cateogries" class="btn btn-primary"/>
						</div>	
				</div>
					<!--end user name feild-->
			</form>
		</div> 		

<?php 
	}else{
	$themsg	 = '<div class="alert alert-danger">This id is not exist</div>';
	redirectHome($themsg,'back');
	}	
}elseif ($action == 'update') {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo'<h1 class="text-center">Update Cateogries</h1>';
		echo'<div class="container">';

		$id 			=$_POST['catid'];
		$name     		= $_POST['name'];
		$description 	= $_POST['description'];
		$Parent 		= $_POST['Parent'];
		$order 			= $_POST['order'];
		$visabl 		=$_POST['visbilty'];
		$allowcomm 		=$_POST['comminting'];
		$allowads 		= $_POST['Ads'];


		$stmt = $db->prepare("UPDATE categories SET Name=?,Descrption=?,Parent=?,Ordering=?,Visablty=?,Allow_Comment=?,Allow_Ads=? WHERE ID=?");

		$stmt->execute(array($name,$description,$Parent,$order,$visabl,$allowcomm,$allowads,$id));

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


}elseif ($action == 'delete') {
			echo'<h1 class="text-center">delete Cateogries</h1>';
			echo'<div class="container">';

	$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])?intval($_GET['catid']):0;

		$check = checkItem('ID','categories',$catid);

	if ($check > 0) {
		
		$stmt = $db->prepare("DELETE FROM categories WHERE ID=:id");

		$stmt->bindparam(':id',$catid);

		$stmt->execute();

		$count = $stmt->rowCount();

		if ($count > 0) {
			$themsg ='<div class="alert alert-success"> delete categories is successful </div>';
				redirectHome($themsg,'back',3);
		}else{
			$themsg ='<div class="alert alert-danger"> delete categories is field </div>';
				redirectHome($themsg,'back',3);
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