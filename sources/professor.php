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
<title>Professor</title>
    <link rel="stylesheet" type="text/css" href="cssFile.css">
</head>
<body>
<a href='alleprofessoren.php'>Alle Professoren</a><br>
<!-- SEARCH PROFESSOR AFTER SURNAME -->
<div>
    <form id='searchform' action='professor.php' method='get'>
        Suchen Professor nach Nachname:
        <input id='searchSurname' name='searchSurname' type='text' size='20' placeholder="Schneider"
               value='<?php isset($_GET['searchSurname']) ? $_GET['searchSurname'] : null; ?>'/>
        <input id='submit' type='submit' value='Suchen!'/><br>
    </form>
</div>
<?php
if (isset($_GET['searchSurname'])) {
    $sqlSurname = "SELECT * FROM professor WHERE nachname like '%" . $_GET['searchSurname'] . "%'";
    $stmtSurname = oci_parse($conn, $sqlSurname);
    oci_execute($stmtSurname);
    ?>
   <table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
	<th>Idnummer</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
		<th>Geburtsdatum</th>
        <th>Gehalt</th>
		<th>Uni_Id</th>
		
    </tr>
    </thead>
    <tbody>
         <?php
    while ($row = oci_fetch_assoc($stmtSurname)) {
        echo "<tr>";
        echo "<td align='center'>" . $row['IDNUMMER'] . "</td>";
        echo "<td align='center'>" . $row['VORNAME'] . "</td>";
		echo "<td align='center'>" . $row['NACHNAME'] . "</td>";
        echo "<td align='center'>" . $row['EMAIL'] . "</td>";
		 echo "<td align='center'>" . $row['GEBURTSDATUM'] . "</td>";
		   echo "<td align='center'>" . $row['GEHALT'] . "</td>";
		    echo "<td align='center'>" . $row['UNIID'] . "</td>";
			 
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
        
    <div>Insgesamt <?php echo oci_num_rows($stmtSurname); ?> datasets gefunden!</div>
    <?php
    oci_free_statement($stmtSurname);
}
?>
<!-- SEARCH PROFESSOR AFTER ID -->
<div>
  <form id='searchform' action='professor.php' method='get'>
   
    Suche nach Id:
    <input id='searchId' name='searchId' type='text' size='20' placeholder="347"  
	value='<?php isset($_GET['searchId']) ? $_GET['searchId'] : null; ?>'/>
    <input id='submit' type='submit' value='Suchen!'/><br>
  </form>
</div>
 <br><br>
<?php
  if (isset($_GET['searchId'])) {
    $sqlId = "SELECT * FROM professor WHERE idnummer like '%" . $_GET['searchId'] . "%'";
    $stmtId = oci_parse($conn, $sqlId);
    oci_execute($stmtId);
    ?>
<table style='border: 1px solid #DDDDDD'>
    <thead>
    <tr>
	<th>Idnummer</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
		<th>Geburtsdatum</th>
        <th>Gehalt</th>
		<th>Uni_Id</th>
		
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = oci_fetch_assoc($stmtId)) {
        echo "<tr>";
        echo "<td align='center'>" . $row['IDNUMMER'] . "</td>";
        echo "<td align='center'>" . $row['VORNAME'] . "</td>";
		echo "<td align='center'>" . $row['NACHNAME'] . "</td>";
        echo "<td align='center'>" . $row['EMAIL'] . "</td>";
		 echo "<td align='center'>" . $row['GEBURTSDATUM'] . "</td>";
		   echo "<td align='center'>" . $row['GEHALT'] . "</td>";
		    echo "<td align='center'>" . $row['UNIID'] . "</td>";
			 
        echo "</tr>";
    }
    ?>
    </tbody>
</table>


<?php
oci_free_statement($stmtId);
  }
?>


<!-- ENTER NEW PROFESSOR INTO PROFESSOR TABLE -->
<div>
    <form id='insertform' action='professor.php' method='get'>
        Neue Professor einfuegen:
        <table style='border: 1px solid #DDDDDD'>
            <thead>
            <tr>
         <th>Idnummer</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Email</th>
		<th>Geburtsdatum</th>
        <th>Gehalt</th>
		<th>Uni_Id</th>
	
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input id='idnummer' name='idnummer' type='number' size='10' placeholder="347"
                           value='<?php isset($_GET['idnummer']) ? $_GET['idnummer'] : null; ?>'/>
                </td>
                <td>
                    <input id='vorname' name='vorname' type='text' size='20' placeholder="Thomas"
                           value='<?php isset($_GET['vorname']) ? $_GET['vorname'] : null; ?>'/>
                </td>
                <td>
                    <input id='nachname' name='nachname' type='text' size='20' placeholder="Klausner"
                           value='<?php isset($_GET['nachname']) ? $_GET['nachname'] : null; ?>'/>
                </td>
				<td>
                    <input id='email' name='email' type='text' size='25' placeholder="thomas_klausner@gmail.com"
                           value='<?php isset($_GET['email']) ? $_GET['email'] : null; ?>'/>
                </td>
                <td>
                    <input id='geburtsdatum' name='geburtsdatum' type='text' size='20' placeholder="e.g. 01-01-1985"
                           value='<?php isset($_GET['geburtsdatum']) ? $_GET['geburtsdatum'] : null; ?>'/>
                </td>
                <td>
                    <input id='gehalt' name='gehalt' type='number' size='10' placeholder="4000"
                           value='<?php isset($_GET['gehalt']) ? $_GET['gehalt'] : null;; ?>'/>
                </td>
                <td>
                    <input id='uniId' name='uniId' type='number' size='10' placeholder="45"
                           value='<?php isset($_GET['uniId']) ? $_GET['uniId'] : null; ?>'/>
                </td>
				
            </tr>
            </tbody>
        </table>
        <input id='submit' type='submit' value='Einfuegen!'/>
    </form>
</div>
<?php
//Handle insert
if (isset($_GET['idnummer'])) {
    $sql = "INSERT INTO professor VALUES(" . $_GET['idnummer'] . ",'"  . $_GET['vorname'] . "','" . $_GET['nachname'] . "','" . $_GET['email'] . "',
	to_date('" . $_GET['geburtsdatum'] . "','dd-mm-yyyy')  ,'" . $_GET  ['gehalt'] . "','" . $_GET  ['uniId'] . "')";
	
	
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err = oci_error($conn);
    $insert_err = oci_error($insert);
    if (!$conn_err & !$insert_err) {
        print("Erfolgreich eingefuegt!");
        print("<br>");
    } //Print potential errors and warnings
    else {
        print($conn_err);
        print_r($insert_err);
        print("<br>");
    }
    oci_free_statement($insert);

oci_close($conn);
  }
  
?>
<br><a href="index.html">Back to Homepage</a>
</body>
</html>




