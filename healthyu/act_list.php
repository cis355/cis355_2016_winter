<!DOCTYPE html>
<!--
 *******************************************************************
 * filename     : act_list.php
 * author       : George Corser
 * svsuid       : gpcorser
 * course       : cis355 
 * semester		: Winter 2016
 *
 * description  : This program displays a list of activities
 *
 * input        : activities table from gpcorser database
 * processing   : The program does the following. 
					 1. head: include bootstrap files
					 2. body: display table
					 3. body (php/mysql): populate table
 * output       : a screen display of activities
 *
 * precondition : user must be logged in, 
				activities table must exist in gpcorser database
 * postcondition: a screen displays activities
 * ******************************************************************* 
 */
-->
<html lang="en">
<!-- 1. head: include bootstrap files -->
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    	<div class="row">
    		<h3>Activities</h3>
    	</div>
		<div class="row">
			<p>
				<a href="act_create.php" class="btn btn-success">Create</a>
				<a href="hu_login.php" class="btn btn-success">Login</a>
				<a href="hu_logout.php" class="btn btn-success">Logout</a>
			</p>
			<!-- 	 2. body: display table --> 
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
					  <th>Description</th>
					  <th>Points</th>
					  <th>HealthyU Flag</th>
					  <th>Buttons</th>
					</tr>
				</thead>
				<tbody>
				<!-- 3. body (php/mysql): populate table -->
				<?php 
					include 'database.php';
					$pdo = Database::connect();
					$sql = 'SELECT * FROM healthyu_activity ORDER BY id DESC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['description'] . '</td>';
						echo '<td>'. $row['points'] . '</td>';
						echo '<td>'. $row['hu_activity'] . '</td>';
						echo '<td width=250>';
						echo '<a class="btn" href="act_read.php?id='.$row['id'].'">Read</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="act_update.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="act_delete.php?id='.$row['id'].'">Delete</a>';
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