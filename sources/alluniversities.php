<?php
$user = 'a1467981';
$pass = '1467981';
$database = 'lab';

// establish database connection
$conn = oci_connect($user, $pass, $database);
if (!$conn) exit;
?>

<html>
<head>
    <title>Alle unis</title>
    <link rel="stylesheet" type="text/css" href="cssFile.css">
</head>
<body>
<?php
$sql = "SELECT * FROM uni order by name";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
?>
<table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
	<th>ID</th>
        <th>Land</th>
        <th>Stadt</th>
		<th>Name</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = oci_fetch_assoc($stmt)) {
        echo "<tr>";
		echo "<td align='center'>" . $row['UNIID'] . "</td>";
        echo "<td align='center'>" . $row['LAND'] . "</td>";
        echo "<td align='center'>" . $row['STADT'] . "</td>";
        echo "<td align='center'>" . $row['NAME'] . "</td>";
		
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Student(en) gefunden!</div>
<?php
oci_free_statement($stmt);
oci_close($conn);
?>
<br><a href="index.html">Back to Homepage</a>
</body>
</html>
