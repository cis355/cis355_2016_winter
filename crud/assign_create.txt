<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
	
		// keep track validation errors
		$customerError = null;
		$eventError = null;
		$commentsError = null;
		
		// keep track post values
		$customer = $_POST['customer'];    // same as HTML name= attribute in put box
		$event = $_POST['event'];
		$comments = $_POST['comments'];	
		
		// validate input
		$valid = true;

		if (empty($customer)) {
			$customerError = 'Please enter Customer';
			$valid = false;
		}
		
		if (empty($event)) {
			$eventError = 'Please enter Event';
			$valid = false;
		} 
		
		if (empty($comments)) {
			$commentsError = 'Please enter Comments';
			$valid = false;
		}
		

echo $date . $time . $location . $description;		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO assignments 
			    (assign_customer_id,assign_event_id,comments) 
				values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($customer,$event,$comments));
			Database::disconnect();
			header("Location: assignments.php");
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
		    			<h3>Create an Assignment</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="assign_create.php" method="post">
				
					  <div class="control-group">
					    <label class="control-label">Customer</label>
					    <div class="controls">
							<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY id DESC';
							echo "<select class='form-control' name='customer' id='customer_id'>";
							foreach ($pdo->query($sql) as $row) {
								echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
							}
							echo "</select>";
							Database::disconnect();
							?>
					    </div>	<!-- end controls -->
					  </div> <!-- end control group -->
					  
					  <div class="control-group">
					    <label class="control-label">Event</label>
					    <div class="controls">
							<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM events ORDER BY id DESC';
							echo "<select class='form-control' name='event' id='event_id'>";
							foreach ($pdo->query($sql) as $row) {
								echo "<option value='" . $row['id'] . " '> " . 
								    trim($row['event_description']) . " (" . 
									trim($row['event_location']) . ") " .
									"</option>";
							}
							echo "</select>";
							Database::disconnect();
							?>
					    </div>	<!-- end controls -->
					  </div> <!-- end control group -->
										  

					  <div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					    <label class="control-label">Comments</label>
					    <div class="controls">
					      	<input name="comments" type="text"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>">
					      	<?php if (!empty($commentsError)): ?>
					      		<span class="help-inline"><?php echo $commentsError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="events.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

	
  </body>
</html>