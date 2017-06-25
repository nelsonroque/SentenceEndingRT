<?php
session_start();

if(isset($_POST['submit'])){

	# if missing checkbox on arousal item
	if(!empty($_POST['check_list_arousal'])){
		$checked_string_arousal = implode(",",$_POST['check_list_arousal']);
		$_SESSION['options_clicked_arousal'] = $checked_string_arousal;
	} else{
		$_SESSION['MSG_WARNING'] = "Please select at least one option<br>";
		header("location:javascript://history.go(-1)");
	}

	# if missing checkbox on valence item
	if(!empty($_POST['check_list_valence'])){
		$checked_string_valence = implode(",",$_POST['check_list_valence']);
		$_SESSION['options_clicked_valence'] = $checked_string_valence;
	} else{
		$_SESSION['MSG_WARNING'] = "Please select at least one option<br>";
		header("location:javascript://history.go(-1)");
	}


	if((!empty($_POST['check_list_arousal'])) and (!empty($_POST['check_list_valence']))) {
		$_SESSION['RT'] = "NA";
		$_SESSION['time'] = date("h:i:sa");

		$myfile = fopen($_SESSION['filename'], "a") or die("Unable to open file!");
		$txt = $_SESSION['MID']."\t".$_SESSION['part_id']."\t".$_SESSION['date']."\t".$_SESSION['time']."\t".$_SESSION['b_name']."\t".$_SESSION['b_ver']."\t".$_SESSION['b_plt']."\t".$_SESSION['b_UA']."\t".$_SESSION['trial']."\t".$_SESSION['QUALTRICS_ID']."\t".$_SESSION['CONDITION_CODE']."\t".$_SESSION['FREE_RESPONSE']."\t".$_SESSION['options_clicked_valence']."\t".$_SESSION['options_clicked_arousal']."\t".$_SESSION['RT']."\n";
		fwrite($myfile, $txt);
		fclose($myfile);

		# update trial count
		$_SESSION['trial'] = $_SESSION['trial'] + 1;

		# reset vars
		unset($_POST['check_list_arousal']);
		unset($_POST['check_list_valence']);
		$_SESSION['MSG_WARNING'] = NULL;

		header("Location: http://cognitivetask.com/turk_coding/projects/DARTS/task.php");
	} else {
		$_SESSION['MSG_WARNING'] = "Please select at least one option<br>";
		header("location:javascript://history.go(-1)");
	}
} 
?>