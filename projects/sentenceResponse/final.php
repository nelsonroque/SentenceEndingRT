<?php
session_start();
?>
<html>
<head>
<title>Sentence Response Task</title>
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://cognitivetask.com/turk_coding/projects/DARTS/assets/css/style.css">
</head>
<body>
<div class="container">
	<center>
    <div id="instruct_area">
      <h1>Thank you for Participating!</h1>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <div class="instructions_large">
            <p><?php echo "<a href='".$_SESSION['next_task_URL']."'>"; ?>Click here to continue to Part 2</a></p>
            <hr>
            	<div class="unique_code">
	            	<?php
      						#echo($_SESSION['part_id']);
                  session_destroy();
					     ?>
				  </div>
            </center>
          </div>
        </div>
      </div>
      </div>
    </div>
</div>
</body>
</html>