<html>
<head>
 <!--<title>CRIME RECORD MANAGEMENT</title>-->
 <!--<h1 align ="center">Crime Record Management</h1>-->
 <!-- Bootstrap core CSS -->
 <link href="dist/css/bootstrap.min.css" rel="stylesheet">

 <!-- Custom styles for this template -->
 <link href="starter-template.css" rel="stylesheet">

</head>
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
      background-image: url("paper-backgrounds.jpg");
  }
}
</style>

<body class ="one">

      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only"></span>
            </button>
            <a class="navbar-brand" style="color: #ffffff;" href="http://localhost:8012/crms">Crime Record Management</a>
          </div>
          </div>
      </nav>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="dist/js/bootstrap.min.js"></script>

<div align= "center">
<form name="query1" method="POST" action="crimeRecord2.php"><br>
<p align ="justify"><b>Query-1 Show the list of all cases that requires to be investigated on or after a particular date?</b><br>
  
  SELECT FIR_ID,Govt_id_no AS GOVT_ID ,Inv_status AS INVESTIGATION_STATUS 
  FROM INVESTIGATION_DETAILS WHERE
  START_DATE >= '2016-02-01'
  ORDER BY FIR_ID ASC;
  </p>
  Enter the date:<input type ="text" name="date2" size="30"/><br><br>
  <input type="submit" value="query1" name="query1"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align = "justify"><b>Query-2 Show the list of all the evidences associated with the crime robbery</b><br>
  SELECT DISTINCT EVIDENCE_NAME, EVIDENCE_DESC AS DESCRIPTION 
  FROM EVIDENCE JOIN FIR ON EVIDENCE.FIR_ID=FIR.FIR_ID 
  WHERE CRIME_TYPE='Robbery';
  </p>
  <input type="submit" value="query2" name="query2"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-3 Give the Officer Name, FIR_ID and Data of crime for a FIR assigned to a particular officer of a particular department. </b><br>
  SELECT FIR_ID, CONCAT(F.First_name,CONCAT('  ', F.Last_name)) AS OFFICER_NAME, Date_of_Crime AS CRIME_DATE From FIR AS F 
  WHERE EMP_ID IN (SELECT D.EMP_ID from DEPARTMENT AS D WHERE EMP_ID IN (SELECT I.EMP_ID from INVESTIGATION_OFFICER AS I WHERE EMP_ID= 60001002)); </p>
 
 Enter the Employee ID:<input type ="text" name="empid" size="30"/><br><br>
  <input type="submit" value="query3" name="query3"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-4 Display the Withness name and Witness number for a particular victim</b><br>
  SELECT W.Witness_id as WITNESS_NO,W.Witness_name as NAME_OF_WITNESS 
  FROM WITNESS As W JOIN VICTIM As V ON  W.GOVT_ID_NO=V.GOVT_ID_NO 
  WHERE VICTIM_NAME='Jenny'
  LIMIT 1; </p>
  Enter victim name:<input type ="text" name="vicname" size="30"/><br><br>
  <input type="submit" value="query4" name="query4"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-5 Display the details of the cases that have been reported in Dallas Police Station</b><br>
  SELECT FIR_ID, CONCAT(F.FIRST_NAME, CONCAT(' ',F.LAST_NAME)) AS NAME, DATE_OF_CRIME, CRIME_TYPE, LOCATION, FIR_STATUS FROM FIR WHERE POL_STAT_ID IN
  (SELECT POL_STAT_ID FROM DEPARTMENT WHERE POL_STAT_ID IN 
  (SELECT POL_STAT_ID FROM POLICE_STATION WHERE CITY='Dallas')); </p>
  <input type="submit" value="query5" name="query5"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-6 Give the count of number of Employees with a particular designation</b><br>
  SELECT DESGN_NAME,COUNT(D.EMP_ID) AS Number_of_Employees
  FROM DESIGNATION D INNER JOIN INVESTIGATION_OFFICER I ON (D.EMP_ID=I.EMP_ID)
  WHERE DESGN_NAME ='Captain';
  </p>
  Enter the Designation name:<input type="text" name="desgn" size="30"/><br><br>
  <input type="submit" value="query6" name="query6"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-7 Give the count of Number of Police stations having a given Department</b><br>
  SELECT DEPT_NAME, COUNT(D.POL_STAT_ID) AS Number_of_PoliceStations_Having_This_Dept 
  FROM DEPARTMENT D JOIN POLICE_STATION P ON D.POL_STAT_ID=P.POL_STAT_ID 
  WHERE D.POL_STAT_ID="CH001";
  </p>  
  <input type="submit" value="query7" name="query7"/><br><br><br>
</form>

<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-8 Give the count of how many FIR's are in the Status "Initiated","In-Progress" or "Completed" for Crime type "Robbery"</b><br>
  SELECT FIR_STATUS,COUNT(*)
  FROM FIR F INNER JOIN INVESTIGATION_DETAILS I 
  WHERE F.FIR_ID=I.FIR_ID 
  AND F.GOVT_ID_NO=I.GOVT_ID_NO
  AND CRIME_TYPE="Robbery"
  GROUP BY FIR_STATUS
  HAVING COUNT(*)>=2;
</p>
  <input type="submit" value="query8" name="query8"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-9 Give a list of all the FIR's filed in given Police Station </b><br>
  SELECT POL_STAT_NAME,FIRST_NAME AS FName,LAST_NAME AS LName,Date_of_crime,Crime_type
  FROM POLICE_STATION P INNER JOIN FIR F ON (P.POL_STAT_ID=F.POL_STAT_ID)
  WHERE F.POL_STAT_ID IN
 (SELECT POL_STAT_ID FROM POLICE_STATION
  WHERE POL_STAT_ID='CH001')
  ORDER BY CRIME_TYPE ASC;
  </p> 
  <input type="submit" value="query9" name="query9"/><br><br><br>
</form>
<form action="crimeRecord2.php" method="POST"><br>
  <p align ="justify"><b>Query-10 Fetch details of Nature of crimes which were used while filing a FIR </b><br>
  SELECT TYPE_ID,Nature_of_crime AS CRIME
  FROM TYPE_OF_CRIME,FIR 
  WHERE FIR.FIR_ID=TYPE_OF_CRIME.FIR_ID
  AND NATURE_OF_CRIME='Kidnapping';
  </p>
  Enter Crime name:<input type="text" name="name" size="30" /><br><br>
  <input type="submit" value="query10" name="query10"/><br>
</form>