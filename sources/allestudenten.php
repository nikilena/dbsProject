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
    <title>Alle studenten</title>
    <link rel="stylesheet" type="text/css" href="cssFile.css">
</head>
<body>
<?php
$sql = "SELECT * FROM student order by nachname";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
?>
<table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
        <th>Matrikelnummer</th>
        <th>Name</th>
		<th>Studienrichtung</th>
        <th>Semester</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = oci_fetch_assoc($stmt)) {
        echo "<tr>";
        echo "<td align='center'>" . $row['MATRIKELNUMMER'] . "</td>";
        echo "<td align='center'>" . $row['NACHNAME'] . " " . $row['VORNAME'] . "</td>";
        echo "<td align='center'>" . $row['STUDIENRICHTUNG'] . "</td>";
		echo "<td align='center'>" . $row['SEMESTER'] . "</td>";
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
