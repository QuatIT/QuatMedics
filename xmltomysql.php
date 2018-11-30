<?php
include 'assets/core/connection.php';
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>Untitled Document</title>
	<meta name="Author" content=""/>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<table>
	<thead>
		<th>Male</th>
		<th>Female</th>
	</thead>
	<tbody>
		<?php
		$numberMale = 0;
		$numberfMale = 0;
		$getwardass = select("SELECT * FROM wardassigns WHERE dischargeDate='' OR dischargeDate='NULL'");
		echo count($getwardass);
		if($getwardass){
			foreach($getwardass as $wardrow){
				$patid = $wardrow['patientID'];

				$getgender = select("SELECT * FROM patient WHERE patientID='$patid'");
				foreach($getgender as $patrow){
					$patgen = $patrow['gender'];
				}

				 if($patgen = 'Male'){
						 $numberMale = $numberMale++;
					 }else{
						 $numberfMale = $numberfMale++;
					 }
			}
		}
		?>
		<tr>
			<td><?php echo $numberMale;?></td>
			<td></td>
		</tr>
	</tbody>
</table>

</body>
</html>
