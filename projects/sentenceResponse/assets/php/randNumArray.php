<?php
	session_start();

	function nRandNums_InRange($nums = '', $min = '', $max = '') {

	    $arr = array();

	    for ($i=0; $i<=$max; $i++) {
	        $arr[] = $i;
	    }

	    # for randomization
	    shuffle($arr);

	    return(array_slice($arr, 0, $nums));

	}


	  $randdata = nRandNums_InRange(10,0,958);

	  print_r(array_values($randdata));

?>