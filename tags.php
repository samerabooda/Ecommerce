<?php
session_start();
$titlename = 'Tags';
include 'init.php'; 
?>
<div class="container">
	
	<?php
		if (isset($_GET['name'])) {
			$tags = $_GET['name'];
			echo '<div class="row">';
			echo'<h1 class="text-center"> <?= $tags?> </h1>';
			$gettag = getall("*","items","WHERE tags LIKE '%$tags%'","AND Approve=1","ItemID");
			foreach ($gettag as $item) {
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












		}

		?>