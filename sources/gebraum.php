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
<a href='alluniversities.php'>Alle Universitaten</a><br>
<!-- ENTER UNI NUMBER TO GET ALL OF ITS BUILDINGS AND ROOMS INFORMATION  -->
<div>
    <form id='searchform' action='gebraum.php' method='get'>
  Die Raune und Gebaude nach Universitaet suchen:
        <input id='enterID' name='enterID' type='text' size='20' placeholder="Uni ID_Number"
               value='<?php isset($_GET['enterID']) ? $_GET['enterID'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/>
        <br>
    </form>
</div>
<?php
if (isset($_GET['enterID'])) {
    $sql = "select fl.gebnummer as FLN, fl.stadt as STADT, fl.strasse as STR,fl.num AS NUM, a.stock as ST, a.sitzplatz as SI
                      from ( select uniId, gebnummer, stadt, strasse, num from gebaude where uniId = " . $_GET['enterID'] . ") fl
                      inner join raum a on a.gebnummer = fl.gebnummer";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    ?>
    <table style='border: 1px solid #DDDDDD'>
        <thead>
        <tr>
            <th>Raumnummer</th>
            <th>Adresse</th>
            <th>Stock</th>
			<th>Sitzplaetze</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = oci_fetch_assoc($stmt)) {
            echo "<tr>";
            echo "<td align='center'>" . $row['FLN'];
            echo "<td align='center'>" . $row['STADT'] . " - " . $row['STR'] . " Strasse  " . $row['NUM'] . " </td>";
            echo "<td align='center'>" . $row['ST'] . "</td>";
			  echo "<td align='center'>" . $row['SI']. "</td>";;
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
<br>

