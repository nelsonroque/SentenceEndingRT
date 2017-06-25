<?php
session_start();

// if(!isset($_SESSION['consented'])){
//   header("Location: http://cognitivetask.com/turk_coding/projects/DARTS/consent.php");
//<?php echo("<form action='http://cognitivetask.com/turk_coding/projects/DARTS/assets/php/save.php' method='post'><br>");  line 81
// }

function nRandNums_InRange($nums = '', $min = '', $max = '') {

    $arr = array();

    for ($i=0; $i<=$max; $i++) {
        $arr[] = $i;
    }

    # for randomization
    shuffle($arr);

    return(array_slice($arr, 0, $nums));
}

if($_SESSION['trial'] == 0){
  # randomly sample n rows
  $N_ROWS = $_SESSION['MAX_TRIALS'];
  $DATA_ROWS = $_SESSION['DATA_TRIALS'];

  # get n rand numbers in range (no duplicates)
  $randdata = nRandNums_InRange($N_ROWS,0,$DATA_ROWS);

  $_SESSION['sampled_rows'] = $randdata;

  $i = 0;

  $_SESSION['QUALTRICS_ID'] = "NA";
  $_SESSION['ORG_TASK_START'] = "NA";
  $_SESSION['MTURK_UNIQUE_CODE'] = "NA";
  $_SESSION['CONDITION_CODE'] = "NA";
  $_SESSION['FREE_RESPONSE'] = $_SESSION['DATA_ARRAY'][$i];

}
elseif($_SESSION['trial'] == $_SESSION['MAX_TRIALS']){
  header("Location: http://cognitivetask.com/turk_coding/projects/DARTS/final.php");
}
elseif(($_SESSION['trial'] > 0) and ($_SESSION['trial'] != $_SESSION['MAX_TRIALS'])){
  $i = 1;

  $_SESSION['QUALTRICS_ID'] = "NA";
  $_SESSION['ORG_TASK_START'] = "NA";
  $_SESSION['MTURK_UNIQUE_CODE'] = "NA";
  $_SESSION['CONDITION_CODE'] = "NA";
  $_SESSION['FREE_RESPONSE'] = $_SESSION['DATA_ARRAY'][$i];
}
?>
<html>
<head>
<title>Data Coding</title>
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/style.css">
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <h1>Sentence Response Task</h1>
    </div>
    <div class="col-md-4">
      <h3>Trial: <?php echo($_SESSION['trial'] + 1);?> of <?php echo($_SESSION['MAX_TRIALS']);?> </h3>
      <?php # warning if no options selected
        if(!is_null($_SESSION['MSG_WARNING'])){
          echo("<div class='alert alert-warning'>");
          echo($_SESSION['MSG_WARNING']);
          echo("</div>");
      }?>
    </div>
  </div>
<hr>
  <div class="row">
    <div class="col-md-12">
        <button onclick="playAudio()" id="startButton" class="btn btn-large btn-success larger_button">START</button>
        <button id="endButton" class="btn btn-large btn-danger larger_button">END</button>
        <button onclick="end_TASK()" id="continueButton" class="btn btn-large btn-warning larger_button">CONTINUE TO QUESTIONNAIRE</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <hr>
      <hr>
      <!--<input type="submit" name="submit" Value="STOP" class="btn btn-large btn-danger larger_button">-->

      <hr>
      Page load time:<h3 id="page_load"></h3>
      Start time 1:<h3 id="start_time1"></h3>
      Start time 2:<h3 id="start_time2"></h3>
      Final time:<h3 id="final_time"></h3>
      RT 1:<h3 id="RT1"></h3>
      RT 2:<h3 id="RT2"></h3>
    </div>
  </div>
</div>

</body>
</html>
<script>
// Date.now() returns the number of milliseconds since 1970/01/01

// hide end button on page load
var endButton = document.getElementById("endButton");
var continueButton = document.getElementById("continueButton");
endButton.style.display = "none";
continueButton.style.display = "none";

// store page load time
var page_load_time = Date.now();
var pageloadtime  = document.getElementById("page_load");
pageloadtime.innerHTML = page_load_time;

// function to play audio
function playAudio() {
  // create audio object
  var audio = new Audio('assets/sounds/This_is_a_sentence.mp3');

  // start timer 1
  var timeStart1 = Date.now();

  // play audio
  audio.play();

  // start post-audio timer
  var timeStart2 = Date.now();

  // update start times
  var starttime1 = document.getElementById("start_time1");
  var starttime2 = document.getElementById("start_time2");
  starttime1.innerHTML = timeStart1;
  starttime2.innerHTML = timeStart2;

  // load buttons into vars for manipulation
  var startButton = document.getElementById("startButton");
  var endButton = document.getElementById("endButton");

  // toggle visual states
  startButton.style.display= "none";
  endButton.style.display= "block";
  endButton.addEventListener("click", function(){
    var endButton = document.getElementById("endButton");
    var continueButton = document.getElementById("continueButton");
    endButton.style.display= "none";
    continueButton.style.display= "block";

    var timeEnd = Date.now();
    var RT_1 = timeEnd - timeStart1;
    var RT_2 = timeEnd - timeStart2;

    var finaltime = document.getElementById("final_time");
    finaltime.innerHTML = timeEnd;
    
    var RT1 = document.getElementById("RT1");
    var RT2 = document.getElementById("RT2");
    RT1.innerHTML = RT_1;
    RT2.innerHTML = RT_2;
  });
}

function end_TASK () {
    window.location.assign("http://cognitivetask.com/sounds/projects/sentenceResponse/final.php")
}
function save_DATA () {
    window.location.assign("http://cognitivetask.com/sounds/projects/sentenceResponse/assets/php/save.php")
}
</script>