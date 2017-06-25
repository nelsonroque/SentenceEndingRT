<?php
  session_start();
  function myReadCSV($filename=''){
    $array = $fields = array(); $i = 0;
    $handle = @fopen($filename, "r");
    if ($handle) {
        while (($row = fgetcsv($handle, 4096)) !== FALSE) {
          if (empty($fields)) {
            $fields = $row;
            continue;
          }
          foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value;
          }
          $i++;
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
      }

      return($array);
  }

  	# if file passed into URL, then use that URL
	if(isset($_GET['file_to_code']) and !empty($_GET['file_to_code'])) {
		$myfile = $_GET['file_to_code'];
	}
	else {
		# else, open demo file
	    $myfile = 'http://cognitivetask.com/turk_coding/projects/DARTS/input/data.csv';
	}

	# read the file and get its length
    $array = myReadCSV($myfile);
    $file_length = count($array);

    for ($i = 0; $i < $file_length; $i++) {
	    $_SESSION['QUALTRICS_ID'] = $array[$i]['image_id'];
	    $_SESSION['ORG_TASK_START'] = $array[$i]['StartDate'];
	    $_SESSION['MTURK_UNIQUE_CODE'] = $array[$i]['image_category'];
	    $_SESSION['CONDITION_CODE'] = $array[$i]['image_subcategory'];
	    $_SESSION['FREE_RESPONSE'] = $array[$i]['filename'];

	    #print_r(array_values($array));
	    echo("<hr>");
	    echo("IMAGE_ID: ".$_SESSION['QUALTRICS_ID']."<br>");
	    echo("RATING_START_DATE: ".$_SESSION['ORG_TASK_START']."<br>");
	    echo("IMG_CAT: ".$_SESSION['MTURK_UNIQUE_CODE']."<br>");
	    echo("IMG_SUBCAT: ".$_SESSION['CONDITION_CODE']."<br>");
	    echo("FILENAME: ".$_SESSION['FREE_RESPONSE']."<br>");
	} 
?>