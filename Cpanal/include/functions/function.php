<?php

function getall($field,$table,$where=null,$AND=null,$orderfield,$order = 'DESC'){

		global $db;

	$getall=$db->prepare("SELECT $field FROM $table $where $AND ORDER BY $orderfield $order");
	$getall->execute();
	$count = $getall->fetchAll();
	return $count;
	}








/*get title */
function title(){
	global $titlename;
	if(isset($titlename)){
		echo "$titlename";
	}else{
		echo "defalt";
	}
}
		//=====================================================================//

/* 
The function v.1
redirecthome DIRECTRY
*/
/*
	function redirectHome($errormsg,$second = 3){
		echo "<div class='alert alert-danger'>$errormsg</div>";
		echo "<div class='alert alert-info'>they will transfer directly after $second seconds </div>";
		header("refresh:$second;url=index.php");
		exit();
	}
*/
				//===============================================================//
	/*the function is v.2
		--redirecthome--
	*/	
	function redirectHome($themsg, $url = null, $second = 3){
			if ($url===null) {
				$url='index.php';
				$link='homepage';
			}else{
				if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=='') {
					$url=$_SERVER['HTTP_REFERER'];
					$link='privious page';
				}else{
					$url='index.php';
					$link='homepage';
				}
			}

		echo $themsg;
		echo "<div class='alert alert-info'>this page to transfer directly to $link after $second seconds</div>";
		header("refresh:$second;url=$url");
		exit();

	}	


				//==================================================================//
/* function to check the item exist or not*/

	function checkItem($select,$from,$value){
		global $db;

		$stmt1=$db->prepare("SELECT $select FROM $from WHERE $select = ?");
		$stmt1->execute(array($value));
		$count = $stmt1->rowCount();
		return $count;

	}

				//==================================================================//
/* function to count of item */
function countItem($item,$table){

	global $db;
	$stmt2=$db->prepare("SELECT count($item) FROM $table");
	$stmt2->execute();
	$count = $stmt2->fetchColumn();
	return $count;


} 

				//==================================================================//
/* function to leatets record function */

	function latest($select,$table,$order,$limit=5){

		global $db;

	$stmt2=$db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	$stmt2->execute();
	$count = $stmt2->fetchAll();
	return $count;



	}


?>