<?php 

/* *******************************************************************
 * filename     : act_create.php
 * author       : George Corser
 * svsuid       : gpcorser
 * course       : cis355 
 * semester		: Winter 2016
 *
 * description  : This program displays an empty create screen 
					(if "create" button was clicked on list screen), or
					adds record to database (if submit button clicked)
 *
 * input        : either nothing, or $_POST superglobal
 * processing   : The program does the following. 
					if $_POST is not empty
						inserts a record
						redirects back to list screen
					else
						displays blank entry screen
 * output       : either a blank entry screen, or 
					a new record in the database table (activity)
 *
 * precondition : user must be logged in, 
				activities table must exist in gpcorser database
 * postcondition: either a blank entry screen, or 
					a new record in the database table (activity)
 * ******************************************************************* 
 */ 
 
session_start();
// if not loggedin redirect to act_list.php
if ($_SESSION['loggedin'] == false) header("Location: act_list.php");

	require 'database.php';

	// if values were passed, validate and insert
	if ( !empty($_POST)) {
			
		// get values
		$description = $_POST['description'];
		$points = $_POST['points'];
		$hu_activity = $_POST['hu_activity'];

		// validate input
		$descriptionError = null;
		$pointsError = null;
		$hu_activityError = null;
		$valid = true;
		if (empty($description)) {
			$descriptionError = 'Please enter description';
			$valid = false;
		}
		if (empty($points)) {
			$pointsError = 'Please enter points';
			$valid = false;
		} 
		// set hu_activity to 1 if nonzero
		if($hu_activity != 0) $hu_activity = 1;
		/*
		if (empty($hu_activity)) {
			$hu_activityError = 'Please enter hu_activity';
			$valid = false;
		}
		*/

		// insert record
		if ($valid) 
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO healthyu_activity (description,points,hu_activity) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($description,$points,$hu_activity));
			Database::disconnect();
			header("Location: act_list.php");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
			<div class="row">
				<h3>Create Activity</h3>
			</div>
	
			<form class="form-horizontal" action="act_create.php" method="post" enctype="multipart/form-data">
			
				<div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					<label class="control-label">description</label>
					<div class="controls">
						<input name="description" type="text"  placeholder="description" value="<?php echo !empty($description)?$description:'';?>">
						<?php if (!empty($descriptionError)): ?>
							<span class="help-inline"><?php echo $descriptionError;?></span>
						<?php endif; ?>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($pointsError)?'error':'';?>">
					<label class="control-label">points</label>
					<div class="controls">
						<input name="points" type="text" placeholder="points" value="<?php echo !empty($points)?$points:'';?>">
						<?php if (!empty($pointsError)): ?>
							<span class="help-inline"><?php echo $pointsError;?></span>
						<?php endif;?>
					</div>
				</div>
			  
				<div class="control-group <?php echo !empty($hu_activityError)?'error':'';?>">
					<label class="control-label">hu_activity</label>
					<div class="controls">
						<input name="hu_activity" type="text"  placeholder="1=yes, 0=no" value="<?php echo !empty($hu_activity)?$hu_activity:'';?>">
						<?php if (!empty($hu_activityError)): ?>
							<span class="help-inline"><?php echo $hu_activityError;?></span>
						<?php endif;?>
					</div>
				</div>
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="activity.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- span10 offset1 -->
    </div> <!-- container -->
</body>
</html>