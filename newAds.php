<?php
session_start();
$titlename = 'new item';
include 'init.php'; 
if (isset($_SESSION['user'])) {


		if($_SERVER['REQUEST_METHOD']=='POST'){
			echo"<h1 class='text-center'>Insert Item</h1>";
			echo '<div class="container">';
		

			$name=$_POST['name'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$country=$_POST['country'];
			$statue=$_POST['statues'];
			$category=$_POST['category'];
			$tags = $_POST['tags'];
			
			$filtername = filter_var($name,FILTER_SANITIZE_STRING);
			$filterdesc = filter_var($description,FILTER_SANITIZE_STRING);
			$filterprice = filter_var($price,FILTER_SANITIZE_NUMBER_INT);
			$filtercountry = filter_var($country,FILTER_SANITIZE_STRING);
			$filterstatu = filter_var($statue,FILTER_SANITIZE_NUMBER_INT);
			$filtercat = filter_var($category,FILTER_SANITIZE_NUMBER_INT);
			$filtertags = filter_var($tags,FILTER_SANITIZE_STRING);

				$formrerror = [];
			if(empty($filtername)){
				$formrerror[] = "please this feiled is <strong>name of item</strong> empty";
			}
			if(empty($filterdesc)){
				$formrerror[] = "please this feiled is <strong>description of item</strong> empty";
			}
			if(empty($filterprice)){
				$formrerror[] = "please this feiled is <strong>price of item</strong> empty";
			}
			if(empty($filtercountry)){
				$formrerror[] = "please this feiled is <strong>country of item</strong> empty";
			}
				if(empty($filterstatu)){
				$formrerror[] = "please this feiled is <strong>statue of item</strong> empty";
			}
			
				if(empty($filtercat)){
				$formrerror[] = "please this feiled is <strong>category of item</strong> empty";
			}
			
			if(empty($formrerror)){
		//insert
				$stmt=$db->prepare("INSERT INTO items(Name,Descrption,Price,CountryMade,statues,addDate,Cat_ID,MemberID,tags)VALUES(:name,:des,:price,:country,:statue,now(),:cat,:member,:tag)");
				$stmt->execute(array(
				'name'		=> $filtername,
				'des' 		=> $filtername,
				'price' 	=> $filterprice,
				'country' 	=> $filtercountry,
				'statue' 	=> $filterstatu,
				'cat'   	=> $filtercat,
				'member'   	=> $_SESSION['uid'],
				'tag'		=>$filtertags,	
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
?>
<h1 class="text-center">Add new Ads</h1>
	<div class="create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Create new ad</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8">
							<form class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
			
								<!--start  name feild-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Name</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="name" class="form-control live-name" autocomplete="off" required="required"/>
										</div>	
								</div>
						<!--end name feild-->
				<!--start Descrition feild-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Description</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="description" class="form-control live-desc" autocomplete="off" required="required"/>
										</div>	
								</div>
					<!--end Descrption feild-->	
					<!--start Descrition feild-->
								<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Price</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="price" class="form-control live-price" autocomplete="off" required="required"/>
										</div>	
								</div>
					<!--end Country feild-->	
									<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">CountryMade</label>
										<div class="col-sm-10 col-md-9">
											<input type="text" name="country" class="form-control live-country" autocomplete="off" required="required"/>
										</div>	
								</div>
					<!--end Country feild-->
						<!--end Country feild-->	
									<div class="form-group form-group-lg">
									<label class="col-sm-2 control-label">Statues</label>
										<div class="col-sm-10 col-md-9">
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
		
						<!--start category feild-->	
								<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">category</label>
									<div class="col-sm-10 col-md-9">
										<select  name="category">
											<option value="0">....</option>
											<?php
									$getcat = getall('*','categories','','','ID');
											foreach ($getcat as $cat) {
												echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
										$getchild = getall("*","categories","WHERE Parent={$cat['ID']}","","ID");	
												foreach ($getchild as $c) {
											echo "<option value='".$c['ID']."'>--".$c['Name']."</option>";	
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


						<div class="col-md-4">
								<div class="thumbnail item-box live-preview">
										<span class="price-tag">$0</span>
										<img class="img-responsive" src="layout/img/img.png" alt="" />
										<div class="caption">
											<h3>Name</h3>
											<p>Description</p>
										</div>
								</div>
							</div>
						</div>
						<?php
							if (!empty($formrerror)) {
								foreach ($formrerror as $error) {
									echo '<div alert aler-danger>'.$error.'</div>';
								}
							}

						?>
					</div>
			</div>
		</div>
	</div>



<?php
}  
include "$siteroot/footer.php"; 

?>  