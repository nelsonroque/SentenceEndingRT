<?php
session_start();

include('assets/php/next_task.php');

// if(!isset($_SESSION['consented'])){
  // header("Location: http://cognitivetask.com/sounds/projects/sentenceResponse/index.php");
// }

# ===============================================================================
# FUNCTIONS
# ===============================================================================

function myReadCSV($filename='') {
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

function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern
    );
} 

function gen_random_string($digits) {
  # list of all numbers and letters
  $all_nums = array('0','1','2','3','4','5','6','7','8','9');
  $all_letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

  $rand_string = '';

  # Shuffle both lists
  shuffle($all_nums);
  shuffle($all_letters);

  $i = 0;

  while ($i < $digits) {
    if ($i % 2 == 0) {
      $cur_rand = array_pop($all_nums);
    }
    else {
      $cur_rand = array_pop($all_letters);
    }

    $rand_string = "$rand_string"."$cur_rand";
    $i += 1;
  }

  return $rand_string;
}

# ===============================================================================
# GET URL PARAMETERS
# ===============================================================================

# if study name given, check if data folder exists, if doesn't create it, if does, set as foldername
if(isset($_GET['study']) && !empty($_GET['study'])) {
  $dirname = $_GET['study'];
  $_SESSION['study'] = $_GET['study'];
} else {
  $dirname = "no_study";
  $_SESSION['study'] = "DARTS";
}

# if study name given, check if data folder exists, if doesn't create it, if does, set as foldername
if(isset($_GET['read_file']) && !empty($_GET['read_file'])) {
  $file_2_read = $_GET['read_file'];
  $_SESSION['read_file'] = $_GET['read_file'];
} else {
  $file_2_read = "data.csv";
  $_SESSION['read_file'] = $file_2_read;
}

# get worker ID from url var
if(isset($_GET['MID']) && !empty($_GET['MID'])){
    $WORKER_ID = $_GET['MID'];
} else {
    $WORKER_ID = "NO_WORKER_ID";
}

# ===============================================================================
# GENERATE SESSION ID
# ===============================================================================

# generate participant code
$digits = 16;
$random_string = gen_random_string($digits);

# ===============================================================================
# SAVE SESSION VARS
# ===============================================================================

# set participant info
$_SESSION['trial'] = 0;
$_SESSION['MID'] = $WORKER_ID;
$_SESSION['part_id'] = $random_string;
$_SESSION['date'] = date("m.d.y");
$_SESSION['time'] = date("h:i:sa");

# get browser info
$ua=getBrowser();
$_SESSION['b_name'] = $ua['name'];
$_SESSION['b_ver'] = $ua['version'];
$_SESSION['b_plt'] = $ua['platform'];
$_SESSION['b_UA'] = $ua['userAgent'];
$_SESSION['next_task_URL'] = $link_to_next;


# ===============================================================================
# OPEN DATASET
# ===============================================================================

$path_prefix = "output/" . $dirname . "/";

if (!file_exists($path_prefix)) {
    mkdir("output/" . $dirname, 0777);
    exit;
}

# open file
#$myfile = 'http://cognitivetask.com/turk_coding/projects/DARTS/input/'.$_SESSION['read_file'];

# setup trial data array
#$array = myReadCSV($myfile);
$array = array("assets/sounds/This_is_a_sentence.mp3");
$_SESSION['DATA_ARRAY'] = $array;

# set max trials per person
$_SESSION['MAX_TRIALS'] = count($array);
$_SESSION['DATA_TRIALS'] = ($_SESSION['MAX_TRIALS'] - 1); #n rows - 1


# create file for session
$file_suffix = $_SESSION['study']."_";
$file_name = $file_suffix.$_SESSION['part_id'].".txt";
$_SESSION['filename'] = $_SERVER['DOCUMENT_ROOT']."/sounds/projects/sentenceResponse/".$path_prefix.$file_name;


# ===============================================================================
#  WRITE FILE HEADER
# ===============================================================================

# write file header on page load
$myfile = fopen($_SESSION['filename'], "a") or die("Unable to open file!");
$header = 'MID'."\t".'part_id'."\t".'date'."\t".'time'."\t".'b_name'."\t".'b_ver'."\t".'b_plt'."\t".'b_UA'."\t".'current_trial'."\t".'qualtrics_response_id'."\t".'condition'."\t"."img_name"."\t".'valence'."\t".'arousal'."\t".'RT'."\n";
fwrite($myfile, $header);
fclose($myfile);

# ===============================================================================
?>
<html>
<head>
<title>Data Coding</title>
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/style.css">
</head>
<body>

<div class="container">
  <div id="instruct_area">
  <h1>Instructions</h1>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <div class="instructions_large">
        <h3>Overview</h3>
        <ul>
        <li><p>This task can be administered before or after Questionnaire assessments in Qualtrics, just be sure to pass a few URL parameters (i.e. example.com/index.php?MID=A1726TGTJN181&EXP_TITLE=SentenceResponseTask&QualtricsID=123456) so the data file knows what to do.</p></li>
        <li><p>Assuming audio files have filenames with sentence content, that information can be saved to the datafile</p></li>
        <li><p>Assumming audio files have filenames with audio length in miliseconds, that information can be saved to the datafile</p></li>
        <li><p>For this task, you will press a button to start hearing a sentence, then press a button when the sentence is complete.</p></li>
        </ul>
        <hr>
      </div>
    </div>
  </div>
  </div>

  <div class="row">
    <!--<div class="col-md-12">
      <div class="instructions_large">
        <p>You will receive your unique code at the end of this task.</p>
        <hr>
      </div>
    </div>-->
    <div class="col-md-12">
      <button class="btn btn-large btn-success larger_button" onclick="start_CODING()">START CODING TASK</button>
    </div>
  </div>
  </div>
</div>

</body>

</html>
<script>
function start_CODING () {
    window.location.assign("http://cognitivetask.com/sounds/projects/sentenceResponse/task.php")
}
</script>