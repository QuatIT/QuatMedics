<?php
    include 'assets/core/connection.php';
if(isset($_POST['import'])){
		echo $filename=$_FILES["file"]["tmp_name"];


		 if($_FILES["file"]["size"] > 0) {

		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE){

	          //It wiil insert a row to our subject table from our csv file`
	           $sql = insert("INSERT into nhis_tb (code,generic_name,unit_of_pricing,price,level_of_prescribing,insurance_type) values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]')");
	         //we are using mysql_query function. it returns a resource on true else False on error
	          //$result = $db->sql( $sql);


	         }
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
					</script>";



			 //close of connection
//			mysql_close($conn);



		 }
}
?>
<form class="form-horizontal well" action="" method="post" name="upload_excel" enctype="multipart/form-data">

						<legend>Import CSV/Excel file</legend>
                    CSV/Excel File:
								<input type="file" name="file" id="file" class="input-large form-control">
						  <br>
							<button type="submit" id="submit" name="import" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
				</form>
