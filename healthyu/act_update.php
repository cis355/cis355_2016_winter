<?php 

session_start();
// if not loggedin redirect to act_list.php
if ($_SESSION['loggedin'] == false) header("Location: act_list.php");

	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: act_list.php");
	}
	
	// if data was entered by the user
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE healthyu_activity  set description = ?, points = ?, hu_activity =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($description,$points,$hu_activity,$id));
			Database::disconnect();
			header("Location: act_list.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM healthyu_activity where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$description = $data['description'];
		$points = $data['points'];
		$hu_activity = $data['hu_activity'];
		Database::disconnect();
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
		    	<h3>Update Activity</h3>
		    </div>
    		
	    	<form class="form-horizontal" action="act_update.php?id=<?php echo $id?>" method="post">
					  
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
						<input name="hu_activity" type="text"  placeholder="1=yes, 0=no" value="<?php echo !empty($hu_activity)?$hu_activity:$hu_activity;?>">
						<?php if (!empty($hu_activityError)): ?>
							<span class="help-inline"><?php echo $hu_activityError;?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="act_list.php">Back</a>
				</div>
			</form>
		</div>
				
    </div> <!-- /container -->
  </body>
</html>