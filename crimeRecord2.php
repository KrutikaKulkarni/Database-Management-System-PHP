<html>
<style>
table, th, td {
  border: 1px solid black;
}
body.one {
    background-color: white;
    padding-top: 100px;
    padding-right: 30px;
    padding-bottom: 50px;
    padding-left: 80px;
  }
  body {
      background-image: url("maxresdefault.jpg");
  }
}
</style>
<?php
include 'connection.php';
global $conn;
//Query-1
   if (isset($_POST['query1'])){
   $dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   $dbh->beginTransaction();
   $date2=$_POST['date2'];
   $stmt=$dbh->prepare('SELECT FIR_ID,Govt_id_no AS GOVT_ID ,Inv_status AS INVESTIGATION_STATUS FROM INVESTIGATION_DETAILS WHERE START_DATE >= "'.$date2.'" ORDER BY FIR_ID ASC');
   $stmt->execute();
    echo "<table>
    <tr>
      <th>FIR_ID</th>
      <th>GOVT_ID</th>
	  <th>INVESTIGATION_STATUS </th>

    </tr>";
    while($row=$stmt->fetch()){

    echo "<tr>
    <td>".$row["FIR_ID"]."</td>
    <td>".$row["GOVT_ID"]."</td>
	<td>".$row["INVESTIGATION_STATUS"]."</td>
    </tr>";

  }

echo "</table>";
$dbh = null;
}
//Query-2
if (isset($_POST['query2'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
//$date=$_POST['date'];
$stmt=$dbh->prepare('SELECT DISTINCT EVIDENCE_NAME, EVIDENCE_DESC AS DESCRIPTION FROM EVIDENCE JOIN FIR ON EVIDENCE.FIR_ID=FIR.FIR_ID WHERE CRIME_TYPE="Robbery"');
$stmt->execute();
 echo "<table>
 <tr>
   <th>Evidence Name</th>
   <th>Description</th>
 </tr>";
 while($row=$stmt->fetch()){

 echo "<tr>
 <td>".$row[0]."</td>
 <td>".$row[1]."</td>
 </tr>";
}

echo "</table>";
$dbh = null;
}
//Query-3
if (isset($_POST['query3'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$empid=$_POST['empid'];
$stmt=$dbh->prepare('SELECT FIR_ID, F.First_name AS OFFICER_NAME, Date_of_Crime AS CRIME_DATE From FIR AS F 
  WHERE EMP_ID IN (SELECT D.EMP_ID from DEPARTMENT AS D WHERE EMP_ID IN (SELECT I.EMP_ID from INVESTIGATION_OFFICER AS I WHERE EMP_ID= "'.$empid.'"));');
$stmt->execute();
 echo "<table>
 <tr>
   <th>FIR_ID</th>
   <th>OFFICER_NAME</th>
   <th>CRIME_DATE</th>
 </tr>";
 while($row=$stmt->fetch()){

 echo "<tr>
 <td>".$row[0]."</td>
 <td>".$row[1]."</td>
 <td>".$row[2]."</td>
 </tr>";

}

echo "</table>";
$dbh = null;
}
//Query 4
if (isset($_POST['query4'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$vicname=$_POST['vicname'];
$stmt=$dbh->prepare('SELECT W.Witness_id as WITNESS_NO,W.Witness_name as NAME_OF_WITNESS 
  FROM WITNESS As W JOIN VICTIM As V ON  W.GOVT_ID_NO=V.GOVT_ID_NO 
  WHERE VICTIM_NAME="'.$vicname.'"
  LIMIT 1');

$stmt->execute();
echo "<table>
<tr>
  <th>WITNESS_NO</th>
  <th>NAME_OF_WITNESS</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}

//Query 5
if (isset($_POST['query5'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
//$date=$_POST['date'];
$stmt=$dbh->prepare('SELECT FIR_ID, FIRST_NAME AS NAME, DATE_OF_CRIME, CRIME_TYPE, LOCATION, FIR_STATUS FROM FIR WHERE POL_STAT_ID IN
  (SELECT POL_STAT_ID FROM DEPARTMENT WHERE POL_STAT_ID IN 
  (SELECT POL_STAT_ID FROM POLICE_STATION WHERE CITY="Dallas"))');

$stmt->execute();
echo "<table>
<tr>
  <th>FIR_ID</th>
  <th>NAME</th>
  <th>DATE_OF_CRIME</th>
  <th>CRIME_TYPE</th>
  <th>LOCATION</th>
  <th>FIR_STATUS</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
<td>".$row[2]."</td>
<td>".$row[3]."</td>
<td>".$row[4]."</td>
<td>".$row[5]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
//Query 6
if (isset($_POST['query6'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$desgn=$_POST['desgn'];
$stmt=$dbh->prepare('SELECT DESGN_NAME,COUNT(D.EMP_ID) AS Number_of_Employees
  FROM DESIGNATION D INNER JOIN INVESTIGATION_OFFICER I ON (D.EMP_ID=I.EMP_ID)
  WHERE DESGN_NAME ="'.$desgn.'"');

$stmt->execute();
echo "<table>
<tr>
  <th>DESGINATION NAME</th>
  <th>NUMBER OF EMPLOYESS</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
//Query 7
if (isset($_POST['query7'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$stmt=$dbh->prepare('SELECT DEPT_NAME, COUNT(D.POL_STAT_ID) AS Number_of_PoliceStations_Having_This_Dept 
  FROM DEPARTMENT D JOIN POLICE_STATION P ON D.POL_STAT_ID=P.POL_STAT_ID 
  WHERE D.POL_STAT_ID="CH001";');

$stmt->execute();
echo "<table>
<tr>
  <th>DEPARTMENT NAME</th>
  <th>NUMBER OF POLICE STATIONS HAVING THIS DEPARTMENT</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
//Query 8
if (isset($_POST['query8'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$stmt=$dbh->prepare('SELECT FIR_STATUS,COUNT(*)
  FROM FIR F INNER JOIN INVESTIGATION_DETAILS I 
  WHERE F.FIR_ID=I.FIR_ID 
  AND F.GOVT_ID_NO=I.GOVT_ID_NO
  AND CRIME_TYPE="Robbery"
  GROUP BY FIR_STATUS
  HAVING COUNT(*)>=2');

$stmt->execute();
echo "<table>
<tr>
  <th>FIR_STATUS</th>
  <th>COUNT</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
//Query 9
if (isset($_POST['query9'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$stmt=$dbh->prepare('SELECT POL_STAT_NAME,FIRST_NAME AS FName,LAST_NAME AS LName,Date_of_crime,Crime_type
  FROM POLICE_STATION P INNER JOIN FIR F ON (P.POL_STAT_ID=F.POL_STAT_ID)
  WHERE F.POL_STAT_ID IN
 (SELECT POL_STAT_ID FROM POLICE_STATION
  WHERE POL_STAT_ID="CH001")
  ORDER BY CRIME_TYPE ASC');

$stmt->execute();
echo "<table>
<tr>
  <th>Police Station Name</th>
  <th>First Name</th>
  <th>Last Name </th>
  <th> Date of Crime</th>
  <th>Crime Type</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
<td>".$row[2]."</td>
<td>".$row[3]."</td>
<td>".$row[4]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
//Query 10
if (isset($_POST['query10'])){
$dbh = new PDO("mysql:hos=localhost:80;dbname=crms","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$dbh->beginTransaction();
$name=$_POST['name'];
$stmt=$dbh->prepare('SELECT TYPE_ID,Nature_of_crime AS CRIME
  FROM TYPE_OF_CRIME,FIR 
  WHERE FIR.FIR_ID=TYPE_OF_CRIME.FIR_ID
  AND NATURE_OF_CRIME="'.$name.'"');

$stmt->execute();
echo "<table>
<tr>
  <th>TYPE ID</th>
  <th>Nature of Crime</th>
</tr>";
while($row=$stmt->fetch()){

echo "<tr>
<td>".$row[0]."</td>
<td>".$row[1]."</td>
</tr>";

}

echo "</table>";
$dbh = null;
}
?>
</html>