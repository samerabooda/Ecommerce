<?php
/* function to all  function */
	function getall($field,$table,$where=null,$AND=null,$orderfield,$order = 'DESC'){

		global $db;

	$getall=$db->prepare("SELECT $field FROM $table $where $AND ORDER BY $orderfield $order");
	$getall->execute();
	$count = $getall->fetchAll();
	return $count;
	}


/* function to Get cateories function */

	function cats(){

		global $db;

	$getcat=$db->prepare("SELECT * FROM categories ORDER BY ID ASC");
	$getcat->execute(); 
	$count = $getcat->fetchAll();
	return $count;
	}
	/* function to Get items function */
	/*
		function items($where,$value,$Approve=NULL){

		global $db;

		if ($Approve == NULL) {
			$sql = ' AND Approve = 1';
		}else{
			$sql = NULL;
		}

	$getitem=$db->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY ItemID DESC");
	$getitem->execute(array($value));
	$count = $getitem->fetchAll();
	return $count;

	}
	*/

	/* end function to Get items function */

		/* function to Get comments function */
		/*
		function comment($where,$value){

		global $db;

	$getitem=$db->prepare("SELECT * FROM comments WHERE $where = ? ORDER BY Comment_id ASC");
	$getitem->execute(array($value));
	$count = $getitem->fetchAll();
	return $count;
	}
*/
	/* function to comments function */

		function checkstatus($user){

		global $db;

	$getstatuse=$db->prepare("SELECT Username,Regstatues FROM users WHERE Username = ? AND Regstatues=0");
	$getstatuse->execute(array($user));
	$count = $getstatuse->rowCount();
	return $count;
	}


	function checkItem($select,$from,$value){
		global $db;

		$stmt1=$db->prepare("SELECT $select FROM $from WHERE $select = ?");
		$stmt1->execute(array($value));
		$count = $stmt1->rowCount();
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