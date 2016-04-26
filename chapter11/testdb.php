<?php 

include 'database.php';

$pdo = Database::connect();

$sql = 'SELECT name FROM test_cust';

echo 'Customers <br />';
echo '--------- <br />';
foreach ($pdo->query($sql) as $row) {
	echo $row['name'] . ' <br />';
}
echo '<br />';

$sql = 'SELECT name FROM test_prod';

echo 'Products <br />';
echo '--------- <br />';
foreach ($pdo->query($sql) as $row) {
	echo $row['name'] . ' <br />';
}
echo '<br />';

$sql = '';
$sql .= 'SELECT test_cust.name, test_order.qty ';
$sql .= 'FROM test_order ';
$sql .= 'INNER JOIN test_cust ';
$sql .= 'WHERE test_cust.id = 1 AND test_order.cust_id = 1';

echo 'Quantities <br />';
echo '---------- <br />';

foreach ($pdo->query($sql) as $row) {
	echo $row['name'] . ' ';
	echo $row['qty'] . ' <br />';
}
echo '<br />';

echo 'done.';


Database::disconnect();
?>
