<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Events</h3>
    		</div>
			<div class="row">
				<p>
					<a href="event_create.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Date</th>
		                  <th>Time</th>
		                  <th>Location</th>
		                  <th>Description</th>
						  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM events ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['event_date'] . '</td>';
							   	echo '<td>'. $row['event_time'] . '</td>';
							   	echo '<td>'. $row['event_location'] . '</td>';
								echo '<td>'. $row['event_description'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="event_read.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="event_update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="event_delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
		
		<div id="dropdown"><!-- demonstrates back-end populated drop down list box -->
		<p>Demonstration of Back-end Populated Drop Down List Box</p>
		<?php
		
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		
		echo "<select class='form-control' name='customer_id' id='customer_id'>";
	    foreach ($pdo->query($sql) as $row) {
            echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
	    }
		echo "</select>";
		
	    Database::disconnect();
		
		?>
		</div> <!-- /dropdown -->
		<!-- now modify code so previous selection is auto-selected -->
		
    </div> <!-- /container -->
  </body>
</html>