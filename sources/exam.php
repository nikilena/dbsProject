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
<a href='allestudenten.php'>Alle Studenten</a><br>
<!-- SEARCH EXAM INFORMATION AFTER THE STUDENT CARD NUMBER  -->
<div>
    <form id='searchform' action='exam.php' method='get'>
        Klausur information bei matrikelnummer suchen:
        <input id='search' name='search' type='text' size='20' placeholder="SCN"
               value='<?php isset($_GET['search']) ? $_GET['search'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/>
        <br>
    </form>
</div>
<?php
if (isset($_GET['search'])) {
    $sql = "select pe.vorname || '  ' || pe.nachname as LN, p.prufnummer, p.idnummer, bo.nachname, p.note, p.prufdatum from
                (select idnummer, matrikelnummer, prufnummer, note, prufdatum from prufungmachen where matrikelnummer = " . $_GET['search'] . ") p
                inner join professor bo on p.idnummer = bo.idnummer
                inner join student pe on p.matrikelnummer = pe.matrikelnummer";

    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $numRows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    if ($numRows) {
        ?>
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
                <th>Name</th>
                <th>Pruefung Nummer</th>
                <th>Professor ID</th>
                <th>Professor Nachname</th>
                <th>Note</th>
				<th>Pruf_Datum</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($res as $col) {
                echo "<tr>";
                foreach ($col as $item) {
                    echo "<td align='center'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>";
                }
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
<br>

