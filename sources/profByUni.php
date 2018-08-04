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
    <title>University database</title>
    <link rel="stylesheet" type="text/css" href="cssFile.css">
</head>
<body>

<!-- ENTER UNI NUMBER TO GET ALL PROFESSORS THAT WORK IN THIS UNIVERSITY  -->
<div>
    <form id='searchform' action='profByUni.php' method='get'>
  Die Raune und Gebaude nach Universitaet suchen:
        <input id='enterID' name='enterID' type='text' size='20' placeholder="Uni ID_Number"
               value='<?php isset($_GET['enterID']) ? $_GET['enterID'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/>
        <br>
    </form>
</div>
<?php
if (isset($_GET['enterID'])) {
    $sql = "select fl.stadt as FLN, a.idnummer as NUM, a.vorname as VOR, a.nachname AS NACH, a.email as MAIL
                      from ( select uniId, stadt from uni where uniId = " . $_GET['enterID'] . ") fl
                      inner join professor a on a.uniId = fl.uniId";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    ?>
    <table style='border: 1px solid #DDDDDD'>
        <thead>
        <tr>
            <th>Name</th>
            <th>Prof_Id</th>
            <th>Email</th>
			<th>Stadt</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = oci_fetch_assoc($stmt)) {
            echo "<tr>";
            echo "<td align='center'>" . $row['VOR']. " " . $row['NACH']. " </td>";
            echo "<td align='center'>" . $row['NUM'] . "</td>";
            echo "<td align='center'>" . $row['MAIL'] . "</td>";
			  echo "<td align='center'>" . $row['FLN']. "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <div>Insgesamt <?php echo oci_num_rows($stmt); ?> entries gefunden!</div>
    <?php
    oci_free_statement($stmt);
	oci_close($conn);
}
?>
<br><a href="index.html">Back to Homepage</a>
