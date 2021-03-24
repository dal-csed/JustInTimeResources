<?php
include 'scripts/connections.php';
extract($_POST);
$user_ip = $_SERVER['REMOTE_ADDR'];

function mysqli_result($res,$row=0,$col=0){
	 $numrows = mysqli_num_rows($res);
	 if ($numrows && $row <= ($numrows-1) && $row >=0){
			 mysqli_data_seek($res,$row);
			 $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
			 if (isset($resrow[$col])){
					 return $resrow[$col];
			 }
	 }
	 return false;
}

$link = mysqli_connect('projects.cs.dal.ca', 'justintime', 'quoo6ooFiSoh1eic', 'justintime');

// check if the user has already clicked on the unlike (rate = 2) or the like (rate = 1)
$dislike_sql = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE ip = "'.$user_ip.'" and id_item = "'.$pageID.'" and rate = 2 ');
$dislike_count = mysqli_result($dislike_sql);

$like_sql = mysqli_query($link,'SELECT COUNT(*) FROM  rating WHERE ip = "'.$user_ip.'" and id_item = "'.$pageID.'" and rate = 1 ');
$like_count = mysqli_result($like_sql);

if($act == 'like'): //if the user click on "like"
	if(($like_count == 0) && ($dislike_count == 0)){
		mysqli_query($link,'INSERT INTO rating (id_item, ip, rate )VALUES("'.$pageID.'", "'.$user_ip.'", "1")');
	}
	if($dislike_count == 1){
		mysqli_query($link,'UPDATE rating SET rate = 1 WHERE id_item = '.$pageID.' and ip ="'.$user_ip.'"');
	}
endif;

if($act == 'dislike'): //if the user click on "like"
	if(($like_count == 0) && ($dislike_count == 0)){
		mysqli_query($link,'INSERT INTO rating (id_item, ip, rate )VALUES("'.$pageID.'", "'.$user_ip.'", "2")');
	}
	if($like_count == 1){
		mysqli_query($link,'UPDATE rating SET rate = 2 WHERE id_item = '.$pageID.' and ip ="'.$user_ip.'"');
	}
endif;
?>
