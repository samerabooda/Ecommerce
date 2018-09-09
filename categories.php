<?php
session_start();
$titlename = 'Categories';
include 'init.php'; 
?>
<div class="container">
	<div class="row">
	<h1 class="text-center"> Show catgories</h1>
	<?php
		$items = getall("*","items","WHERE Cat_ID={$_GET['catid']}"," AND Approve = 1","ItemID");

		foreach ($items as $item) {
			echo '<div class="col-sm-6 col-md-3">';
				echo '<div class="thumbnail item-box">';
					echo '<span class="price-tag">'.$item['Price'].'</span>';
					echo '<img class="img-responsive" src="layout/img/img.png" alt="" />';
					echo '<div class="caption">';
						echo '<h3><a href="item.php?itemid='.$item['ItemID'].'">'.$item['Name'].'</a></h3>';
						echo '<p>'.$item['Descrption'].'</p>';
						echo '<span class="date">'.$item['addDate'].'</span>';
					echo '</div>';

				echo '</div>';
			echo '</div>';
		}
	?>
</div>
</div>




<?php include "$siteroot/footer.php"; ?>  