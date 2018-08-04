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
<!-- SEARCH ALL OFFERED SUBJECTS BY STUDIENRICHTUNG -->
<div>
    <form id='searchform' action='subject.php' method='get'>
        Suchen die Lehrveranstaltungen bei Studienrichtung:
        <input id='searchsubject' name='searchsubject' type='text' size='20' placeholder="Wirtschaftsinformatik"
               value='<?php isset($_GET['search']) ? $_GET['search'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/><br>
    </form>
</div>
<?php
if (isset($_GET['search'])) {
    $sql = "select  v.typ, v.ectsanzahl, l.name, l.semester from (select lvnummer, name, semester, studienrichtung 
	from lehrveranstaltung where lvnummer = " . $_GET['search'] . ") l inner join vorlesung v on v.lvnummer=l.lvnummer";
                      
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmtsubject);
    ?>
    <table style='border: 1px solid #DDDDDD'>
        <thead>
        <tr>
		<th>Typ</th>
            <th>Lehrveranstaltung</th>
            <th>Semester</th>
            <th>ECTS</th>
            
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
    <div>Insgesamt <?php echo oci_num_rows($stmt); ?> datasets gefunden!</div>
    <?php
    oci_free_statement($stmt);
	oci_close($conn);
}
?>



  
