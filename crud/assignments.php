<?php 
/* filename: assignments.php
 * author  : george corser (cis355 summer2015)
 * purpose : this program displays a list of people (customers)
 *           assigned to events
 * design  : 
			1. Ensure user is properly logged in
			2. Display all assignments (in HTML)
			    // display name from customers table and description from events table
 */
 
    // 1. Ensure user is properly logged in
	session_start();
	if(!isset($_SESSION["user"])){
		// Relocate to login page
		header('Location: login.php');
		exit;
	}
?>
<!-- 2. Display all assignments -->
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
    			<h3>Assignments</h3>
    		</div>
			<div class="row">
				<p>
					<a href="assign_create.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Person Name</th>
		                  <th>Event Description</th>
		                  <th>Comments</th>
						  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();

                       // display name from customers table and description from events table

                       $sql = 'SELECT assignments.id, customers.name, events.event_description, assignments.comments 
					      FROM assignments 
					      LEFT JOIN customers ON customers.id = assignments.assign_customer_id 
						  LEFT JOIN events    ON events.id    = assignments.assign_event_id
						  ORDER BY customers.name DESC;';

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['event_description'] . '</td>';
							   	echo '<td>'. $row['comments'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="assign_read.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="assign_update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="assign_delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
			
    </div> <!-- /container -->
  </body>
</html>