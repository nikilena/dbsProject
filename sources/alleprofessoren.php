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
    <title>Alle professoren</title>
    <link rel="stylesheet" type="text/css" href="cssFile.css">
</head>
<body>
<?php
$sql = "SELECT * FROM professor order by nachname";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
?>
<table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
        <th>Id_Nummer</th>
        <th>Name</th>
		<th>email</th>
        <th>Geburtsdatum</th>
        <th>Gehalt</th>
		<th>Uni_Id</th>
		
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = oci_fetch_assoc($stmt)) {
        echo "<tr>";
        echo "<td align='center'>" . $row['IDNUMMER'] . "</td>";
        echo "<td align='center'>" . $row['NACHNAME'] . " " . $row['VORNAME'] . "</td>";
        echo "<td align='center'>" . $row['EMAIL'] . "</td>";
		echo "<td align='center'>" . $row['GEBURTSDATUM'] . "</td>";
		echo "<td align='center'>" . $row['GEHALT'] . "</td>";
		echo "<td align='center'>" . $row['UNIID'] . "</td>";
		
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Professor(en) gefunden!</div>
<?php
oci_free_statement($stmt);
oci_close($conn);
?>
<br><a href="index.html">Back to Homepage</a>
</body>
</html>
