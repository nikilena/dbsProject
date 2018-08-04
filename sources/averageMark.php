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
<!-- SEARCH AVERAGE MARK BY STUDENT CARD NUMBER  -->
<div>
    <form id='searchform' action='averageMark.php' method='get'>
        Matrikelnummer einfuegen um durchschnittliche Note zu sehen:
        <input id='search' name='search' type='text' size='20' placeholder="matrikelnummer"
               value='<?php isset($_GET['search']) ? $_GET['search'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/>
        <br>
    </form>
</div>
<?php
if (isset($_GET['search'])) {
    $sql = "select s.vorname AS VORNAME, s.nachname AS NACHNAME, AVG(p.note) AS NOTE from (select matrikelnummer, note from prufungmachen
		where matrikelnummer = " . $_GET['search'] . ")p inner join student s on 
	p.matrikelnummer = s.matrikelnummer GROUP BY s.vorname, s.nachname";   

    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $numRows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    if ($numRows) {
        ?>
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                 <th>Nachname</th>
                <th>Vorname</th>
                <th>Durchschnittliche Note</th>
            </tr>
            </thead>
            <tbody>
        <?php
              while ($row = oci_fetch_assoc($stmt)) {
            echo "<tr>";
            echo "<td align='center'>" . $row['VORNAME']. "  </td>";
            echo "<td align='center'>" . $row['NACHNAME'] . "</td>";
            echo "<td align='center'>" . $row['NOTE'] . "</td>";
            echo "</tr>";
        }
        ?>
       </tbody>
        </table>
        <div>Insgesamt <?php echo oci_num_rows($stmt); ?> datasets gefunden!<?php } else {
        ?> <b>(<?php echo oci_num_rows($stmt); ?> entries gefunden!)</b> <?php }
    ?></div><br>
        
    <?php
    oci_free_statement($stmt);
	oci_close($conn);
}
?>

<br><a href="index.php">Back to Homepage</a>
</body>
</html>