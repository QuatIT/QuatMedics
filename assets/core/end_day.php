<?php
include 'connection.php';
include 'connection2.php';

@session_start();
$dateToday = trim(date('Y-m-d'));

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }
}
/*
function bedlist(){

//	check number of local bedlist columns
$sql = "select count(*) as lbedlist from information_schema.columns where table_schema='$dbname' and table_name='bedlist'";
	$lbedcolumn_sql = select($sql);
foreach($lbedcolumn_sql as $lbedcolumn_row){}

//	check number of remote bedlist columns
	$rbedcolumn_sql = select2("select count(*) as rbedlist from information_schema.columns where table_schema='$dbname2' and table_name='bedlist'");
foreach($rbedcolumn_sql as $rbedcolumn_row){}


	if($lbedcolumn_row['lbedlist'] = $rbedcolumn_row['rbedlist']){

//check table remote_bedlist
		$rbedlimit_sql = select2("SELECT * FROM bedlist WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rbedlimit_sql)>=1){
	foreach($rbedlimit_sql as $rbedlimit_row){

		//search where local_doe is greater than remote_doe
		$local_bedlist_sql = select("SELECT * FROM bedlist WHERE centerID='".$_SESSION['centerID']."' && doe >= '".$rbedlimit_row['doe']."' ");
		foreach($local_bedlist_sql as $lbed_row){

			//check duplication in remote
			$rbedlist_duplicate_sql = select2("select * from bedlist where bedID='".$lbed_row['bedID']."' ");

			if(count($rbedlist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$bed_insert = insert2("INSERT INTO quatitso_quatmedic.bedlist(centerID,bedID,bedNumber,bedDescription,BedCharge,wardID,status,doe) VALUES('".$lbed_row['centerID']."','".$lbed_row['bedID']."','".$lbed_row['bedNumber']."','".$lbed_row['bedDescription']."','".$lbed_row['BedCharge']."','".$lbed_row['wardID']."','".$lbed_row['status']."','".$lbed_row['doe']."') ");


				if($bed_insert){
					echo "R_BEDLIST UPDATED";
				}else{
					echo "ERROR: R_BEDLIST";
				}
		}

		}
		}
		}else{


		//search local_bedlist
		$local_bedlist_sql = select("SELECT * FROM bedlist WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_bedlist_sql as $lbed_row){

			//check duplication in remote
			$rbedlist_duplicate_sql = select2("select * from bedlist where bedID='".$lbed_row['bedID']."' ");

			if(count($rbedlist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$bed_insert = insert2("INSERT INTO quatitso_quatmedic.bedlist(centerID,bedID,bedNumber,bedDescription,BedCharge,wardID,status,doe) VALUES('".$lbed_row['centerID']."','".$lbed_row['bedID']."','".$lbed_row['bedNumber']."','".$lbed_row['bedDescription']."','".$lbed_row['BedCharge']."','".$lbed_row['wardID']."','".$lbed_row['status']."','".$lbed_row['doe']."') ");


				if($bed_insert){
					echo "R_BEDLIST UPDATED";
				}else{
					echo "ERROR: R_BEDLIST";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_bedsql = select2("select * from bedlist where centerID !='".$_SESSION['centerID']."' ");
		if(count($remote_bedsql)>=1){
		foreach($remote_bedsql as $remote_bedrow){

			echo $remote_bedrow['bedID'];


				//insert into local_bedlist
				$lo_bedinsert=insert("INSERT INTO bedlist(centerID,bedID,bedNumber,bedDescription,BedCharge,wardID,status,doe) VALUES('".$remote_bedrow['centerID']."','".$remote_bedrow['bedID']."','".$remote_bedrow['bedNumber']."','".$remote_bedrow['bedDescription']."','".$remote_bedrow['BedCharge']."','".$remote_bedrow['wardID']."','".$remote_bedrow['status']."','".$remote_bedrow['doe']."') ");




			}


		}



			}else{
				echo "TABLE L_BEDLIST is NOT EQUAL to TABLE R_BEDLIST";
			}


}


function birth(){

//	check number of local bedlist columns
$sql = "select count(*) as lbirth from information_schema.columns where table_schema='$dbname' and table_name='birth'";
	$lbirthcolumn_sql = select($sql);
foreach($lbirthcolumn_sql as $lbirthcolumn_row){}

//	check number of remote bedlist columns
	$rbirthcolumn_sql = select2("select count(*) as rbirth from information_schema.columns where table_schema='$dbname2' and table_name='birth'");
foreach($rbirthcolumn_sql as $rbirthcolumn_row){}

	if($lbirthcolumn_row['lbirth'] = $rbirthcolumn_row['rbirth']){

//check table remote_bedlist
		$rbirthlimit_sql = select2("SELECT * FROM birth WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rbirthlimit_sql)>=1){
	foreach($rbirthlimit_sql as $rbirthlimit_row){

		//search where local_doe is greater than remote_doe
		$local_birth_sql = select("SELECT * FROM birth WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$rbirthlimit_row['dateRegistered']."' ");
		foreach($local_birth_sql as $lbirth_row){

			//check duplication in remote
			$rbirth_duplicate_sql = select2("select * from quatitso_quatmedic.birth where babyID='".$lbirth_row['babyID']."' ");

			if(count($rbirth_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$birth_insert = insert2("INSERT INTO quatitso_quatmedic.birth(babyID,centerID,babyFirstName,babylastName,babyOtherName,fullname,dob,motherName,fatherName,birthTime,country,status,dateRegistered,doe) VALUES('".$lbirth_row['babyID']."','".$lbirth_row['centerID']."','".$lbirth_row['babyFirstName']."','".$lbirth_row['babylastName']."','".$lbirth_row['babyOtherName']."','".$lbirth_row['fullname']."','".$lbirth_row['dob']."','".$lbirth_row['motherName']."','".$lbirth_row['fatherName']."','".$lbirth_row['birthTime']."','".$lbirth_row['country']."','".$lbirth_row['status']."','".$lbirth_row['dateRegistered']."','".$lbirth_row['doe']."') ");


				if($birth_insert){
					echo "R_BIRTH UPDATED";
				}else{
					echo "ERROR: R_BIRTH";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_birth_sql = select("SELECT * FROM birth WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_birth_sql as $lbirth_row){

			//check duplication in remote
			$rbirth_duplicate_sql = select2("select * from birth where babyID='".$lbirth_row['babyID']."' ");

			if(count($rbirth_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$birth_insert = insert2("INSERT INTO quatitso_quatmedic.birth(babyID,centerID,babyFirstName,babylastName,babyOtherName,fullname,dob,motherName,fatherName,birthTime,country,status,dateRegistered,doe) VALUES('".$lbirth_row['babyID']."','".$lbirth_row['centerID']."','".$lbirth_row['babyFirstName']."','".$lbirth_row['babylastName']."','".$lbirth_row['babyOtherName']."','".$lbirth_row['fullname']."','".$lbirth_row['dob']."','".$lbirth_row['motherName']."','".$lbirth_row['fatherName']."','".$lbirth_row['birthTime']."','".$lbirth_row['country']."','".$lbirth_row['status']."','".$lbirth_row['dateRegistered']."','".$lbirth_row['doe']."') ");

				if($bed_insert){
					echo "R_BIRTH UPDATED";
				}else{
					echo "ERROR: R_BIRTH";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_birthsql = select2("select * from quatitso_quatmedic.birth WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_birthsql as $remote_birthrow){



				$lo_birthinsert = insert("INSERT INTO birth(babyID,centerID,babyFirstName,babylastName,babyOtherName,fullname,dob,motherName,fatherName,birthTime,country,status,dateRegistered,doe) VALUES('".$remote_birthrow['babyID']."','".$remote_birthrow['centerID']."','".$remote_birthrow['babyFirstName']."','".$remote_birthrow['babylastName']."','".$remote_birthrow['babyOtherName']."','".$remote_birthrow['fullname']."','".$remote_birthrow['dob']."','".$remote_birthrow['motherName']."','".$remote_birthrow['fatherName']."','".$remote_birthrow['birthTime']."','".$remote_birthrow['country']."','".$remote_birthrow['status']."','".$remote_birthrow['dateRegistered']."','".$remote_birthrow['doe']."') ");



			}


//		}




			}else{
				echo "TABLE L_BIRTH is NOT EQUAL to TABLE R_BIRTH";
			}


}



function bloodbank(){

//	check number of local bedlist columns
$sql = "select count(*) as lbloodbank from information_schema.columns where table_schema='$dbname' and table_name='bloodbank'";
	$lbloodcolumn_sql = select($sql);
foreach($lbloodcolumn_sql as $lbloodcolumn_row){}

//	check number of remote bedlist columns
	$rbloodcolumn_sql = select2("select count(*) as rbloodbank from information_schema.columns where table_schema='$dbname2' and table_name='bloodbank'");
foreach($rbloodcolumn_sql as $rbloodcolumn_row){}

	if($lbloodcolumn_row['lbloodbank'] = $rbloodcolumn_row['rbloodbank']){

//check table remote_bedlist
		$rbloodlimit_sql = select2("SELECT * FROM bloodbank WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rbloodlimit_sql)>=1){
	foreach($rbloodlimit_sql as $rbloodlimit_row){

		//search where local_doe is greater than remote_doe
		$local_blood_sql = select("SELECT * FROM bloodbank WHERE centerID='".$_SESSION['centerID']."' && lastDonate >= '".$rbloodlimit_row['lastDonate']."' ");
		foreach($local_blood_sql as $lblood_row){

			//check duplication in remote
			$rblood_duplicate_sql = select2("select * from quatitso_quatmedic.bloodbank where donorID='".$lbirth_row['donorID']."' ");

			if(count($rblood_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$blood_insert = insert2("INSERT INTO quatitso_quatmedic.bloodbank(bloodID,donorID,centerID,amtAvail,donorName,gender,bloodGroup,homeAddress,phoneNumber,dob,lastDonate,doe) VALUES('".$lblood_row['bloodID']."','".$lblood_row['donorID']."','".$lblood_row['centerID']."','".$lblood_row['amtAvail']."','".$lblood_row['donorName']."','".$lblood_row['gender']."','".$lblood_row['bloodGroup']."','".$lblood_row['homeAddress']."','".$lblood_row['phoneNumber']."','".$lblood_row['dob']."','".$lblood_row['lastDonate']."','".$lblood_row['doe']."') ");


				if($blood_insert){
					echo "R_BLOOD UPDATED";
				}else{
					echo "ERROR: R_BLOOD";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_blood_sql = select("SELECT * FROM bloodbank WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_blood_sql as $lblood_row){

			//check duplication in remote
			$rblood_duplicate_sql = select2("select * from bloodbank where donorID='".$lblood_row['donorID']."' ");

			if(count($rblood_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$blood_insert = insert2("INSERT INTO quatitso_quatmedic.bloodbank(bloodID,donorID,centerID,amtAvail,donorName,gender,bloodGroup,homeAddress,phoneNumber,dob,lastDonate,doe) VALUES('".$lblood_row['bloodID']."','".$lblood_row['donorID']."','".$lblood_row['centerID']."','".$lblood_row['amtAvail']."','".$lblood_row['donorName']."','".$lblood_row['gender']."','".$lblood_row['bloodGroup']."','".$lblood_row['homeAddress']."','".$lblood_row['phoneNumber']."','".$lblood_row['dob']."','".$lblood_row['lastDonate']."','".$lblood_row['doe']."') ");


				if($blood_insert){
					echo "R_BLOOD UPDATED";
				}else{
					echo "ERROR: R_BLOOD";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_bloodsql = select2("select * from quatitso_quatmedic.bloodbank WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_bloodsql as $remote_bloodrow){
//echo $remote_bloodrow['donorID'];

		$lo_bloodinsert = insert("INSERT INTO bloodbank(bloodID,donorID,centerID,amtAvail,donorName,gender,bloodGroup,homeAddress,phoneNumber,dob,lastDonate,doe) VALUES('".$remote_bloodrow['bloodID']."','".$remote_bloodrow['donorID']."','".$remote_bloodrow['centerID']."','".$remote_bloodrow['amtAvail']."','".$remote_bloodrow['donorName']."','".$remote_bloodrow['gender']."','".$remote_bloodrow['bloodGroup']."','".$remote_bloodrow['homeAddress']."','".$remote_bloodrow['phoneNumber']."','".$remote_bloodrow['dob']."','".$remote_bloodrow['lastDonate']."','".$remote_bloodrow['doe']."') ");



			}


//		}




			}else{
				echo "TABLE L_BLOOD is NOT EQUAL to TABLE R_BLOOD";
			}


}



function bloodgroup_tb(){

//	check number of local bedlist columns
$sql = "select count(*) as lbloodgroup_tb from information_schema.columns where table_schema='$dbname' and table_name='bloodgroup_tb'";
	$lbloodgcolumn_sql = select($sql);
foreach($lbloodgcolumn_sql as $lbloodgcolumn_row){}

//	check number of remote bedlist columns
	$rbloodgcolumn_sql = select2("select count(*) as rbloodgroup_tb from information_schema.columns where table_schema='$dbname2' and table_name='bloodgroup_tb'");
foreach($rbloodgcolumn_sql as $rbloodgcolumn_row){}

	if($lbloodgcolumn_row['lbloodgroup_tb'] = $rbloodgcolumn_row['rbloodgroup_tb']){

//check table remote_bedlist
		$rbloodglimit_sql = select2("SELECT * FROM bloodgroup_tb WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateInsert ASC LIMIT 1");
		if(count($rbloodglimit_sql)>=1){
	foreach($rbloodglimit_sql as $rbloodglimit_row){

		//search where local_doe is greater than remote_doe
		$local_bloodg_sql = select("SELECT * FROM bloodgroup_tb WHERE centerID='".$_SESSION['centerID']."' && dateInsert >= '".$rbloodglimit_row['dateInsert']."' ");
		foreach($local_bloodg_sql as $lbloodg_row){

			//check duplication in remote
			$rbloodg_duplicate_sql = select2("select * from quatitso_quatmedic.bloodgroup_tb where bloodID='".$lbirth_row['bloodID']."' ");

			if(count($rbloodg_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$bloodg_insert = insert2("INSERT INTO quatitso_quatmedic.bloodgroup_tb(bloodID,bloodGroup,charge,bloodBags,centerID,dateInsert,doe) VALUES('".$lbloodg_row['bloodID']."','".$lbloodg_row['bloodGroup']."','".$lbloodg_row['charge']."','".$lbloodg_row['bloodBags']."','".$lbloodg_row['centerID']."','".$lbloodg_row['dateInsert']."','".$lbloodg_row['doe']."') ");


				if($bloodg_insert){
					echo "R_BLOODGROUP UPDATED";
				}else{
					echo "ERROR: R_BLOODGROUP";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_bloodg_sql = select("SELECT * FROM bloodgroup WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_bloodg_sql as $lbloodg_row){

			//check duplication in remote
			$rbloodg_duplicate_sql = select2("select * from bloodgroup_tb where bloodID='".$lbloodg_row['bloodID']."' ");

			if(count($rbloodg_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$bloodg_insert = insert2("INSERT INTO quatitso_quatmedic.bloodgroup_tb(bloodID,bloodGroup,charge,bloodBags,centerID,dateInsert,doe) VALUES('".$lbloodg_row['bloodID']."','".$lbloodg_row['bloodGroup']."','".$lbloodg_row['charge']."','".$lbloodg_row['bloodBags']."','".$lbloodg_row['centerID']."','".$lbloodg_row['dateInsert']."','".$lbloodg_row['doe']."') ");


				if($bloodg_insert){
					echo "R_BLOODGROUP UPDATED";
				}else{
					echo "ERROR: R_BLOODGROUP";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_bloodgsql = select2("select * from quatitso_quatmedic.bloodgroup_tb WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_bloodgsql as $remote_bloodgrow){
echo $remote_bloodrow['bloodID'];

		$lo_bloodginsert = insert("INSERT INTO bloodgroup_tb(bloodID,bloodGroup,charge,bloodBags,centerID,dateInsert,doe) VALUES('".$lbloodg_row['bloodID']."','".$lbloodg_row['bloodGroup']."','".$lbloodg_row['charge']."','".$lbloodg_row['bloodBags']."','".$lbloodg_row['centerID']."','".$lbloodg_row['dateInsert']."','".$lbloodg_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_BLOODGROUP is NOT EQUAL to TABLE R_BLOODGROUP";
			}


}


function cat_nhis(){

//	check number of local bedlist columns
$sql = "select count(*) as lcat_nhis from information_schema.columns where table_schema='$dbname' and table_name='cat_nhis'";
	$lcat_nhiscolumn_sql = select($sql);
foreach($lbedcolumn_sql as $lbedcolumn_row){}

//	check number of remote bedlist columns
	$rcat_nhiscolumn_sql = select2("select count(*) as rcat_nhis from information_schema.columns where table_schema='$dbname2' and table_name='cat_nhis'");
foreach($rcat_nhiscolumn_sql as $rcat_nhiscolumn_row){}


	if($lcat_nhiscolumn_row['lcat_nhis'] = $rcat_nhiscolumn_row['rcat_nhis']){

//check table remote_bedlist
		$rcat_nhislimit_sql = select2("SELECT * FROM cat_nhis WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rcat_nhislimit_sql)>=1){
	foreach($rcat_nhislimit_sql as $rcat_nhislimit_row){

		//search where local_doe is greater than remote_doe
		$local_cat_nhislist_sql = select("SELECT * FROM cat_nhis WHERE centerID='".$_SESSION['centerID']."' && doe >= '".$rcat_nhislimit_row['doe']."' ");
		foreach($local_bedlist_sql as $lcat_nhis_row){

			//check duplication in remote
			$rcat_nhislist_duplicate_sql = select2("select * from cat_nhis where des_name='".$lcat_nhis_row['des_name']."' ");

			if(count($rcat_nhislist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$cat_nhis_insert = insert2("INSERT INTO quatitso_quatmedic.cat_nhis(des_name,levels,doe) VALUES('".$lcat_nhis_row['des_name']."','".$lcat_nhis_row['levels']."','".$lcat_nhis_row['doe']."') ");


				if($cat_nhis_insert){
					echo "R_CAT_NHIS UPDATED";
				}else{
					echo "ERROR: R_CAT_NHIS";
				}
		}

		}
		}
		}else{


		//search local_bedlist
//		$local_cat_nhislist_sql = select("SELECT * FROM cat_nhis WHERE centerID='".$_SESSION['centerID']."' ");
		$local_cat_nhislist_sql = select("SELECT * FROM cat_nhis ");
		foreach($local_cat_nhislist_sql as $lcat_nhis_row){

			//check duplication in remote
			$rcat_nhislist_duplicate_sql = select2("select * from cat_nhis where des_name='".$lcat_nhis_row['des_name']."' ");

			if(count($rcat_nhislist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$cat_nhis_insert = insert2("INSERT INTO quatitso_quatmedic.cat_nhis(des_name,levels,doe) VALUES('".$lcat_nhis_row['des_name']."','".$lcat_nhis_row['levels']."','".$lcat_nhis_row['doe']."') ");


				if($cat_nhis_insert){
					echo "R_CAT_NHIS UPDATED";
				}else{
					echo "ERROR: R_CAT_NHIS";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_cat_nhissql = select2("select * from cat_nhis ");
//		$remote_cat_nhissql = select2("select * from cat_nhis where centerID !='".$_SESSION['centerID']."' ");
		if(count($remote_cat_nhissql)>=1){
		foreach($remote_cat_nhissql as $remote_cat_nhisrow){

			echo $remote_cat_nhisrow['des_name'];


				//insert into local_bedlist
				$lo_cat_nhisinsert=insert("INSERT INTO cat_nhis(des_name,levels,doe) VALUES('".$remote_cat_nhisrow['des_name']."','".$remote_cat_nhisrow['levels']."','".$remote_cat_nhisrow['doe']."') ");




			}


		}



			}else{
				echo "TABLE L_CAT_NHIS is NOT EQUAL to TABLE R_CAT_NHIS";
			}


}
*/



function centeruser(){

//	check number of local bedlist columns
$sql = "select count(*) as lcenteruser from information_schema.columns where table_schema='$dbname' and table_name='centeruser'";
	$lcenterusercolumn_sql = select($sql);
foreach($lcenterusercolumn_sql as $lcenterusercolumn_row){}

//	check number of remote bedlist columns
	$rcenterusercolumn_sql = select2("select count(*) as rcenteruser from information_schema.columns where table_schema='$dbname2' and table_name='centeruser'");
foreach($rcenterusercolumn_sql as $rcenterusercolumn_row){}

	if($lcenterusercolumn_row['lcenteruser'] = $rcenterusercolumn_row['rcenteruser']){

//check table remote_bedlist
		$rcenteruserlimit_sql = select2("SELECT * FROM centeruser WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rcenteruserlimit_sql)>=1){
	foreach($rcenteruserlimit_sql as $rcenteruserlimit_row){

		//search where local_doe is greater than remote_doe
		$local_centeruser_sql = select("SELECT * FROM centeruser WHERE centerID='".$_SESSION['centerID']."' && doe >= '".$rcenteruserlimit_row['doe']."' ");
		foreach($local_centeruser_sql as $lcenteruser_row){

			//check duplication in remote
			$rcenteruser_duplicate_sql = select2("select * from quatitso_quatmedic.centeruser where userID='".$lcenteruser_row['userID']."' ");

			if(count($rcenteruser_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$centeruser_insert = insert2("INSERT INTO quatitso_quatmedic.centeruser(userID,centerID,staffID,userName,password,accessLevel,dateRegistered,doe) VALUES('".$lcenteruser_row['userID']."','".$lcenteruser_row['centerID']."','".$lcenteruser_row['staffID']."','".$lcenteruser_row['userName']."','".$lcenteruser_row['password']."','".$lcenteruser_row['accessLevel']."','".$lcenteruser_row['dateRegistered']."') ");


				if($blood_insert){
					echo "R_CENTERUSER UPDATED";
				}else{
					echo "ERROR: R_CENTERUSER";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_centeruser_sql = select("SELECT * FROM centeruser WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_centeruser_sql as $lcenteruser_row){

			//check duplication in remote
			$rcenteruser_duplicate_sql = select2("select * from centeruser where userID='".$lcenteruser_row['userID']."' ");

			if(count($rcenteruser_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$centeruser_insert = insert2("INSERT INTO quatitso_quatmedic.centeruser(userID,centerID,staffID,userName,password,accessLevel,dateRegistered,doe) VALUES('".$lcenteruser_row['userID']."','".$lcenteruser_row['centerID']."','".$lcenteruser_row['staffID']."','".$lcenteruser_row['userName']."','".$lcenteruser_row['password']."','".$lcenteruser_row['accessLevel']."','".$lcenteruser_row['dateRegistered']."') ");


				if($centeruser_insert){
					echo "R_CENTERUSER UPDATED";
				}else{
					echo "ERROR: R_CENTERUSER";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_centerusersql = select2("select * from quatitso_quatmedic.centeruser WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_centerusersql as $remote_centeruserrow){
//echo $remote_bloodrow['donorID'];

		$lo_centeruserinsert = insert("INSERT INTO centeruser(userID,centerID,staffID,userName,password,accessLevel,dateRegistered,doe) VALUES('".$lcenteruser_row['userID']."','".$lcenteruser_row['centerID']."','".$lcenteruser_row['staffID']."','".$lcenteruser_row['userName']."','".$lcenteruser_row['password']."','".$lcenteruser_row['accessLevel']."','".$lcenteruser_row['dateRegistered']."') ");



			}


//		}




			}else{
				echo "TABLE L_CENTERUSER is NOT EQUAL to TABLE R_CENTERUSER";
			}


}



function consultation(){

//	check number of local bedlist columns
$sql = "select count(*) as lconsultation from information_schema.columns where table_schema='$dbname' and table_name='consultation'";
	$lconsultationcolumn_sql = select($sql);
foreach($lconsultationcolumn_sql as $lconsultationcolumn_row){}

//	check number of remote bedlist columns
	$rconsultationcolumn_sql = select2("select count(*) as rconsultation from information_schema.columns where table_schema='$dbname2' and table_name='consultation'");
foreach($rconsultationcolumn_sql as $rconsultationcolumn_row){}

	if($lconsultationcolumn_row['lconsultation'] = $rconsultationcolumn_row['rconsultation']){

//check table remote_bedlist
		$rconsultationlimit_sql = select2("SELECT * FROM consultation WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateInsert ASC LIMIT 1");
		if(count($rconsultationlimit_sql)>=1){
	foreach($rconsultationlimit_sql as $rconsultationlimit_row){

		//search where local_doe is greater than remote_doe
		$local_consultation_sql = select("SELECT * FROM consultation WHERE centerID='".$_SESSION['centerID']."' && dateInsert >= '".$rconsultationlimit_row['dateInsert']."' ");
		foreach($local_consultation_sql as $lconsultation_row){

			//check duplication in remote
			$rconsultation_duplicate_sql = select2("select * from quatitso_quatmedic.consultation where consultID='".$lconsultation_row['consultID']."' ");

			if(count($rconsultation_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$consultation_insert = insert2("INSERT INTO quatitso_quatmedic.consultation(consultID,patientID,staffID,bodyTemperature,mode,insuranceType,insuranceNumber,company,pulseRate,respirationRate,bloodPressure,weight,otherHealth,roomID,centerID,status,dateInsert,doe) VALUES('".$lconsultation_row['consultID']."','".$lconsultation_row['patientID']."','".$lconsultation_row['staffID']."','".$lconsultation_row['bodyTemperature']."','".$lconsultation_row['mode']."','".$lconsultation_row['insuranceType']."','".$lconsultation_row['insuranceNumber']."','".$lconsultation_row['company']."','".$lconsultation_row['pulseRate']."','".$lconsultation_row['respirationRate']."','".$lconsultation_row['bloodPressure']."','".$lconsultation_row['weight']."','".$lconsultation_row['otherHealth']."','".$lconsultation_row['roomID']."','".$lconsultation_row['centerID']."','".$lconsultation_row['status']."','".$lconsultation_row['dateInsert']."','".$lconsultation_row['doe']."') ");


				if($consultation_insert){
					echo "R_CENTERUSER UPDATED";
				}else{
					echo "ERROR: R_CENTERUSER";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_consultation_sql = select("SELECT * FROM consultation WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_centeruser_sql as $lcenteruser_row){

			//check duplication in remote
			$rconsultation_duplicate_sql = select2("select * from consultation where consultID='".$lconsultation_row['consultID']."' ");

			if(count($rconsultation_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$consultation_insert = insert2("INSERT INTO quatitso_quatmedic.consultation(consultID,patientID,staffID,bodyTemperature,mode,insuranceType,insuranceNumber,company,pulseRate,respirationRate,bloodPressure,weight,otherHealth,roomID,centerID,status,dateInsert,doe) VALUES('".$lconsultation_row['consultID']."','".$lconsultation_row['patientID']."','".$lconsultation_row['staffID']."','".$lconsultation_row['bodyTemperature']."','".$lconsultation_row['mode']."','".$lconsultation_row['insuranceType']."','".$lconsultation_row['insuranceNumber']."','".$lconsultation_row['company']."','".$lconsultation_row['pulseRate']."','".$lconsultation_row['respirationRate']."','".$lconsultation_row['bloodPressure']."','".$lconsultation_row['weight']."','".$lconsultation_row['otherHealth']."','".$lconsultation_row['roomID']."','".$lconsultation_row['centerID']."','".$lconsultation_row['status']."','".$lconsultation_row['dateInsert']."','".$lconsultation_row['doe']."') ");


				if($consultation_insert){
					echo "R_CONSULTATION UPDATED";
				}else{
					echo "ERROR: R_CONSULTATION";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_consultationsql = select2("select * from quatitso_quatmedic.consultation WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_consultationsql as $remote_consultationrow){
//echo $remote_bloodrow['donorID'];

		$lo_consultationinsert = insert("INSERT INTO consultation(consultID,patientID,staffID,bodyTemperature,mode,insuranceType,insuranceNumber,company,pulseRate,respirationRate,bloodPressure,weight,otherHealth,roomID,centerID,status,dateInsert,doe) VALUES('".$lconsultation_row['consultID']."','".$lconsultation_row['patientID']."','".$lconsultation_row['staffID']."','".$lconsultation_row['bodyTemperature']."','".$lconsultation_row['mode']."','".$lconsultation_row['insuranceType']."','".$lconsultation_row['insuranceNumber']."','".$lconsultation_row['company']."','".$lconsultation_row['pulseRate']."','".$lconsultation_row['respirationRate']."','".$lconsultation_row['bloodPressure']."','".$lconsultation_row['weight']."','".$lconsultation_row['otherHealth']."','".$lconsultation_row['roomID']."','".$lconsultation_row['centerID']."','".$lconsultation_row['status']."','".$lconsultation_row['dateInsert']."','".$lconsultation_row['doe']."') ");


			}


//		}




			}else{
				echo "TABLE L_CONSULTATION is NOT EQUAL to TABLE R_CONSULTATION";
			}


}



function consultingroom(){

//	check number of local bedlist columns
$sql = "select count(*) as lconsultingroom from information_schema.columns where table_schema='$dbname' and table_name='consultingroom'";
	$lconsultationcolumn_sql = select($sql);
foreach($lconsultationcolumn_sql as $lconsultationcolumn_row){}

//	check number of remote bedlist columns
	$rconsultingroomcolumn_sql = select2("select count(*) as rconsultingroom from information_schema.columns where table_schema='$dbname2' and table_name='consultingroom'");
foreach($rconsultingroomcolumn_sql as $rconsultingroomcolumn_row){}

	if($lconsultingroomcolumn_row['lconsultingroom'] = $rconsultingroomcolumn_row['rconsultingroom']){

//check table remote_bedlist
		$rconsultingroomlimit_sql = select2("SELECT * FROM consultingroom WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rconsultingroomlimit_sql)>=1){
	foreach($rconsultingroomlimit_sql as $rconsultingroomlimit_row){

		//search where local_doe is greater than remote_doe
		$local_consultingroom_sql = select("SELECT * FROM consultingroom WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$rconsultingroomlimit_row['dateRegistered']."' ");
		foreach($local_consultingroom_sql as $lconsultingroom_row){

			//check duplication in remote
			$rconsultingroom_duplicate_sql = select2("select * from quatitso_quatmedic.consultingroom where roomID='".$lconsultingroom_row['roomID']."' ");

			if(count($rconsultingroom_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$consultingroom_insert = insert2("INSERT INTO quatitso_quatmedic.consultingroom(roomID,roomName,centerID,status,dateRegistered,doe) VALUES('".$lconsultingroom_row['roomID']."','".$lconsultingroom_row['roomName']."','".$lconsultingroom_row['centerID']."','".$lconsultingroom_row['status']."','".$lconsultingroom_row['dateRegistered']."','".$lconsultingroom_row['doe']."') ");


				if($consultation_insert){
					echo "R_CENTERUSER UPDATED";
				}else{
					echo "ERROR: R_CENTERUSER";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_consultation_sql = select("SELECT * FROM consultation WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_consultation_sql as $lconsultation_row){

			//check duplication in remote
			$rconsultation_duplicate_sql = select2("select * from consultation where consultID='".$lconsultation_row['consultID']."' ");

			if(count($rconsultation_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$consultation_insert = insert2("INSERT INTO quatitso_quatmedic.consultingroom(roomID,roomName,centerID,status,dateRegistered,doe) VALUES('".$lconsultingroom_row['roomID']."','".$lconsultingroom_row['roomName']."','".$lconsultingroom_row['centerID']."','".$lconsultingroom_row['status']."','".$lconsultingroom_row['dateRegistered']."','".$lconsultingroom_row['doe']."') ");


				if($consultation_insert){
					echo "R_CONSULTATION UPDATED";
				}else{
					echo "ERROR: R_CONSULTATION";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_consultationsql = select2("select * from quatitso_quatmedic.consultation WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_consultationsql as $remote_consultationrow){
//echo $remote_bloodrow['donorID'];

		$lo_consultationinsert = insert("INSERT INTO consultingroom(roomID,roomName,centerID,status,dateRegistered,doe) VALUES('".$lconsultingroom_row['roomID']."','".$lconsultingroom_row['roomName']."','".$lconsultingroom_row['centerID']."','".$lconsultingroom_row['status']."','".$lconsultingroom_row['dateRegistered']."','".$lconsultingroom_row['doe']."') ");



			}


//		}




			}else{
				echo "TABLE L_CONSULTATION is NOT EQUAL to TABLE R_CONSULTATION";
			}


}



function death(){

//	check number of local bedlist columns
$sql = "select count(*) as ldeath from information_schema.columns where table_schema='$dbname' and table_name='death'";
	$ldeathcolumn_sql = select($sql);
foreach($ldeathcolumn_sql as $ldeathcolumn_row){}

//	check number of remote bedlist columns
	$rdeathcolumn_sql = select2("select count(*) as rdeath from information_schema.columns where table_schema='$dbname2' and table_name='death'");
foreach($rdeathcolumn_sql as $rdeathcolumn_row){}

	if($ldeathcolumn_row['ldeath'] = $rdeathcolumn_row['rdeath']){

//check table remote_bedlist
		$rdeathlimit_sql = select2("SELECT * FROM death WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rdeathlimit_sql)>=1){
	foreach($rdeathlimit_sql as $rdeathlimit_row){

		//search where local_doe is greater than remote_doe
		$local_death_sql = select("SELECT * FROM death WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$rdeathlimit_row['dateRegistered']."' ");
		foreach($local_death_sql as $ldeath_row){

			//check duplication in remote
			$rdeath_duplicate_sql = select2("select * from quatitso_quatmedic.death where deathID='".$ldeath_row['deathID']."' ");

			if(count($rdeath_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$death_insert = insert2("INSERT INTO quatitso_quatmedic.death(deathID,patientID,centerID,deathDate,deathTime,reason,.dateRegistered,doe) VALUES('".$ldeath_row['deathID']."','".$ldeath_row['patientID']."','".$ldeath_row['centerID']."','".$ldeath_row['deathDate']."','".$ldeath_row['deathTime']."','".$ldeath_row['reason']."','".$ldeath_row['dateRegistered']."','".$ldeath_row['doe']."') ");


				if($death_insert){
					echo "DEATH UPDATED";
				}else{
					echo "ERROR: R_DEATH";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_death_sql = select("SELECT * FROM consultation WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_death_sql as $ldeath_row){

			//check duplication in remote
			$rdeath_duplicate_sql = select2("select * from death where roomID='".$ldeath_row['roomID']."' ");

			if(count($rdeath_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$death_insert = insert2("INSERT INTO quatitso_quatmedic.death(deathID,patientID,centerID,deathDate,deathTime,reason,.dateRegistered,doe) VALUES('".$ldeath_row['deathID']."','".$ldeath_row['patientID']."','".$ldeath_row['centerID']."','".$ldeath_row['deathDate']."','".$ldeath_row['deathTime']."','".$ldeath_row['reason']."','".$ldeath_row['dateRegistered']."','".$ldeath_row['doe']."') ");



				if($death_insert){
					echo "R_DEATH UPDATED";
				}else{
					echo "ERROR: R_DEATH";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_consultationsql = select2("select * from quatitso_quatmedic.death WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_consultationsql as $remote_consultationrow){
//echo $remote_bloodrow['donorID'];

		$lo_deathinsert = insert("INSERT INTO death(deathID,patientID,centerID,deathDate,deathTime,reason,.dateRegistered,doe) VALUES('".$ldeath_row['deathID']."','".$ldeath_row['patientID']."','".$ldeath_row['centerID']."','".$ldeath_row['deathDate']."','".$ldeath_row['deathTime']."','".$ldeath_row['reason']."','".$ldeath_row['dateRegistered']."','".$ldeath_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_DEATH is NOT EQUAL to TABLE R_DEATH";
			}


}



function department(){

//	check number of local bedlist columns
$sql = "select count(*) as ldepartment from information_schema.columns where table_schema='$dbname' and table_name='department'";
	$ldepartmentcolumn_sql = select($sql);
foreach($ldepartmentcolumn_sql as $ldepartmentcolumn_row){}

//	check number of remote bedlist columns
	$rdepartmentcolumn_sql = select2("select count(*) as rdepartment from information_schema.columns where table_schema='$dbname2' and table_name='department'");
foreach($rdepartmentcolumn_sql as $rdepartmentcolumn_row){}

	if($ldepartmentcolumn_row['ldepartment'] = $rdepartmentcolumn_row['rdepartment']){

//check table remote_bedlist
		$rdepartmentlimit_sql = select2("SELECT * FROM death WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rdepartmentlimit_sql)>=1){
	foreach($rdepartmentlimit_sql as $rdepartmentlimit_row){

		//search where local_doe is greater than remote_doe
		$local_department_sql = select("SELECT * FROM department WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$rdepartmentlimit_row['dateRegistered']."' ");
		foreach($local_department_sql as $ldepartment_row){

			//check duplication in remote
			$rdepartment_duplicate_sql = select2("select * from quatitso_quatmedic.department where departmentID='".$ldepartment_row['departmentID']."' ");

			if(count($rdepartment_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$department_insert = insert2("INSERT INTO quatitso_quatmedic.department(departmentID,centerID,departmentName,dateCreated,doe) VALUES('".$ldepartment_row['departmentID']."','".$ldepartment_row['centerID']."','".$ldepartment_row['departmentName']."','".$ldepartment_row['dateCreated']."','".$ldepartment_row['doe']."') ");


				if($department_insert){
					echo "L_DEPARTMENT UPDATED";
				}else{
					echo "ERROR: R_DEPARTMET";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_department_sql = select("SELECT * FROM department WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_department_sql as $ldepartment_row){

			//check duplication in remote
			$rdepartment_duplicate_sql = select2("select * from department where departmentID='".$ldepartment_row['departmentID']."' ");

			if(count($rdepartment_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$department_insert = insert2("INSERT INTO quatitso_quatmedic.department(departmentID,centerID,departmentName,dateCreated,doe) VALUES('".$ldepartment_row['departmentID']."','".$ldepartment_row['centerID']."','".$ldepartment_row['departmentName']."','".$ldepartment_row['dateCreated']."','".$ldepartment_row['doe']."') ");



				if($department_insert){
					echo "R_DEATH UPDATED";
				}else{
					echo "ERROR: R_DEATH";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_departmentsql = select2("select * from quatitso_quatmedic.department WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_departmentsql as $remote_departmentrow){
//echo $remote_bloodrow['donorID'];

		$lo_departmentinsert = insert("INSERT INTO department(departmentID,centerID,departmentName,dateCreated,doe) VALUES('".$ldepartment_row['departmentID']."','".$ldepartment_row['centerID']."','".$ldepartment_row['departmentName']."','".$ldepartment_row['dateCreated']."','".$ldepartment_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_DEPARTMENT is NOT EQUAL to TABLE R_DEPARTMENT";
			}


}



function dispensary_tb(){

//	check number of local bedlist columns
$sql = "select count(*) as ldispensary_tb from information_schema.columns where table_schema='$dbname' and table_name='dispensary_tb'";
	$ldispensary_tbcolumn_sql = select($sql);
foreach($ldispensary_tbcolumn_sql as $ldispensary_tbcolumn_row){}

//	check number of remote bedlist columns
	$rdispensary_tbcolumn_sql = select2("select count(*) as rdispensary_tb from information_schema.columns where table_schema='$dbname2' and table_name='dispensary_tb'");
foreach($rdispensary_tbcolumn_sql as $rdispensary_tbcolumn_row){}

	if($ldispensary_tbcolumn_row['ldispensary_tb'] = $rdispensary_tbcolumn_row['rdispensary_tb']){

//check table remote_bedlist
		$rdispensary_tblimit_sql = select2("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rdispensary_tblimit_sql)>=1){
	foreach($rdispensary_tblimit_sql as $rdispensary_tblimit_row){

		//search where local_doe is greater than remote_doe
		$local_dispensary_tb_sql = select("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$rdispensary_tblimit_row['dateRegistered']."' ");
		foreach($local_dispensary_tb_sql as $ldispensary_tb_row){

			//check duplication in remote
			$rdispensary_tb_duplicate_sql = select2("select * from quatitso_quatmedic.dispensary_tb where departmentID='".$ldispensary_tb_row['departmentID']."' ");

			if(count($rdispensary_tb_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$dispensary_tb_insert = insert2("INSERT INTO quatitso_quatmedic.dispensary_tb(request_id,medicine_id,medicine_name,medicine_type,centerID,expire_date,unit_price,no_of_piece,request_status,date_approval,requested_by,approved_by,doe) VALUES('".$ldispensary_tb_row['request_id']."','".$ldispensary_tb_row['medicine_id']."','".$ldispensary_tb_row['medicine_name']."','".$ldispensary_tb_row['medicine_type']."','".$ldispensary_tb_row['centerID']."','".$ldispensary_tb_row['expire_date']."','".$ldispensary_tb_row['unit_price']."','".$ldispensary_tb_row['no_of_piece']."','".$ldispensary_tb_row['request_status']."','".$ldispensary_tb_row['date_approval']."','".$ldispensary_tb_row['requested_by']."','".$ldispensary_tb_row['approved_by']."','".$ldispensary_tb_row['doe']."') ");


				if($dispensary_tb_insert){
					echo "L_DEPARTMENT UPDATED";
				}else{
					echo "ERROR: R_DEPARTMET";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_dispensary_tb_sql = select("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_dispensary_tb_sql as $ldispensary_tb_row){

			//check duplication in remote
			$rdispensary_tb_duplicate_sql = select2("select * from dispensary_tb where doe='".$ldispensary_tb_row['doe']."' ");

			if(count($rdispensary_tb_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$dispensary_tb_insert = insert2("INSERT INTO quatitso_quatmedic.dispensary_tb(request_id,medicine_id,medicine_name,medicine_type,centerID,expire_date,unit_price,no_of_piece,request_status,date_approval,requested_by,approved_by,doe) VALUES('".$ldispensary_tb_row['request_id']."','".$ldispensary_tb_row['medicine_id']."','".$ldispensary_tb_row['medicine_name']."','".$ldispensary_tb_row['medicine_type']."','".$ldispensary_tb_row['centerID']."','".$ldispensary_tb_row['expire_date']."','".$ldispensary_tb_row['unit_price']."','".$ldispensary_tb_row['no_of_piece']."','".$ldispensary_tb_row['request_status']."','".$ldispensary_tb_row['date_approval']."','".$ldispensary_tb_row['requested_by']."','".$ldispensary_tb_row['approved_by']."','".$ldispensary_tb_row['doe']."') ");


				if($dispensary_tb_insert){
					echo "R_DISPENSARY UPDATED";
				}else{
					echo "ERROR: R_DISPENSARY";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_dispensary_tbsql = select2("select * from quatitso_quatmedic.dispensary_tb WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_dispensary_tbsql as $remote_dispensary_tbrow){
//echo $remote_bloodrow['donorID'];

		$lo_dispensary_tbinsert = insert("INSERT INTO dispensary_tb(request_id,medicine_id,medicine_name,medicine_type,centerID,expire_date,unit_price,no_of_piece,request_status,date_approval,requested_by,approved_by,doe) VALUES('".$ldispensary_tb_row['request_id']."','".$ldispensary_tb_row['medicine_id']."','".$ldispensary_tb_row['medicine_name']."','".$ldispensary_tb_row['medicine_type']."','".$ldispensary_tb_row['centerID']."','".$ldispensary_tb_row['expire_date']."','".$ldispensary_tb_row['unit_price']."','".$ldispensary_tb_row['no_of_piece']."','".$ldispensary_tb_row['request_status']."','".$ldispensary_tb_row['date_approval']."','".$ldispensary_tb_row['requested_by']."','".$ldispensary_tb_row['approved_by']."','".$ldispensary_tb_row['doe']."') ");



			}


//		}




			}else{
				echo "TABLE L_DISPENSARY is NOT EQUAL to TABLE R_DISPENSAY";
			}


}




function docreview_tb(){

//	check number of local bedlist columns
$sql = "select count(*) as ldocreview_tb from information_schema.columns where table_schema='$dbname' and table_name='docreview_tb'";
	$ldocreview_tbcolumn_sql = select($sql);
foreach($ldocreview_tbcolumn_sql as $ldocreview_tbcolumn_row){}

//	check number of remote bedlist columns
	$rdocreview_tbcolumn_sql = select2("select count(*) as rdocreview_tb from information_schema.columns where table_schema='$dbname2' and table_name='docreview_tb'");
foreach($rdocreview_tbcolumn_sql as $rdocreview_tbcolumn_row){}

	if($ldocreview_tbcolumn_row['ldocreview_tb'] = $rdocreview_tbcolumn_row['rdocreview_tb']){

//check table remote_bedlist
		$rdocreview_tblimit_sql = select2("SELECT * FROM docreview_tb WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rdocreview_tblimit_sql)>=1){
	foreach($rdocreview_tblimit_sql as $rdocreview_tblimit_row){

		//search where local_doe is greater than remote_doe
		$local_docreview_tb_sql = select("SELECT * FROM docreview_tb WHERE centerID='".$_SESSION['centerID']."' && dateInsert >= '".$rdocreview_tblimit_row['dateInsert']."' ");
		foreach($local_docreview_tb_sql as $ldocreview_tb_row){

			//check duplication in remote
			$rdocreview_tb_duplicate_sql = select2("select * from quatitso_quatmedic.docreview_tb where reviewID='".$ldocreview_tb_row['reviewID']."' ");

			if(count($rdocreview_tb_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$docreview_tb_insert = insert2("INSERT INTO quatitso_quatmedic.docreview_tb(ReviewID,WardID,PatientID,staffID,DocReview,dateInsert,doe) VALUES('".$ldocreview_tb_row['ReviewID']."','".$ldocreview_tb_row['WardID']."','".$ldocreview_tb_row['PatientID']."','".$ldocreview_tb_row['staffID']."','".$ldocreview_tb_row['DocReview']."','".$ldocreview_tb_row['dateInsert']."','".$ldocreview_tb_row['doe']."') ");


				if($docreview_tb_insert){
					echo "L_DOCREVIEW UPDATED";
				}else{
					echo "ERROR: R_DOCREVIEW";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_docreview_tb_sql = select("SELECT * FROM docreview_tb WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_docreview_tb_sql as $ldocreview_tb_row){

			//check duplication in remote
			$rdocreview_tb_duplicate_sql = select2("select * from docreview_tb where ReviewID='".$ldocreview_tb_row['ReviewID']."' ");

			if(count($rdocreview_tb_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$docreview_tb_insert = insert2("INSERT INTO quatitso_quatmedic.docreview_tb(ReviewID,WardID,PatientID,staffID,DocReview,dateInsert,doe) VALUES('".$ldocreview_tb_row['ReviewID']."','".$ldocreview_tb_row['WardID']."','".$ldocreview_tb_row['PatientID']."','".$ldocreview_tb_row['staffID']."','".$ldocreview_tb_row['DocReview']."','".$ldocreview_tb_row['dateInsert']."','".$ldocreview_tb_row['doe']."') ");


				if($dispensary_tb_insert){
					echo "R_DOCREVIEW UPDATED";
				}else{
					echo "ERROR: R_DOCREVIEW";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_docreview_tbsql = select2("select * from quatitso_quatmedic.docreview_tb WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_docreview_tbsql as $remote_docreview_tbrow){
//echo $remote_bloodrow['donorID'];

		$lo_docreview_tbinsert = insert("INSERT INTO docreview_tb(ReviewID,WardID,PatientID,staffID,DocReview,dateInsert,doe) VALUES('".$ldocreview_tb_row['ReviewID']."','".$ldocreview_tb_row['WardID']."','".$ldocreview_tb_row['PatientID']."','".$ldocreview_tb_row['staffID']."','".$ldocreview_tb_row['DocReview']."','".$ldocreview_tb_row['dateInsert']."','".$ldocreview_tb_row['doe']."') ");



			}


//		}




			}else{
				echo "TABLE L_DOCREVIEW is NOT EQUAL to TABLE R_DOCREVIEW";
			}


}



function doctorappointment(){

//	check number of local bedlist columns
$sql = "select count(*) as ldoctorappointment from information_schema.columns where table_schema='$dbname' and table_name='doctorappointment'";
	$ldoctorappointmentcolumn_sql = select($sql);
foreach($ldoctorappointmentcolumn_sql as $ldoctorappointmentcolumn_row){}

//	check number of remote bedlist columns
	$rdoctorappointmentcolumn_sql = select2("select count(*) as rdoctorappointment from information_schema.columns where table_schema='$dbname2' and table_name='doctorappointment'");
foreach($rdoctorappointmentcolumn_sql as $rdoctorappointmentcolumn_row){}

	if($ldoctorappointmentcolumn_row['ldoctorappointment'] = $rdoctorappointmentcolumn_row['rdoctorappointment']){

//check table remote_bedlist
		$rdoctorappointmentlimit_sql = select2("SELECT * FROM doctorappointment WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($rdoctorappointmentlimit_sql)>=1){
	foreach($rdoctorappointmentlimit_sql as $rdoctorappointmentlimit_row){

		//search where local_doe is greater than remote_doe
		$local_doctorappointment_sql = select("SELECT * FROM doctorappointment WHERE centerID='".$_SESSION['centerID']."' && dateInsert >= '".$rdoctorappointmentlimit_row['dateInsert']."' ");
		foreach($local_doctorappointment_sql as $ldoctorappointment_row){

			//check duplication in remote
			$rdoctorappointment_duplicate_sql = select2("select * from quatitso_quatmedic.doctorappointment where reviewID='".$ldoctorappointment_row['reviewID']."' ");

			if(count($rdoctorappointment_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$doctorappointment_insert = insert2("INSERT INTO quatitso_quatmedic.doctorappointment(appointNumber,centerID,staffID,patientID,appointmentDate,appointmentTime,status,reason,sms,dateInsert) VALUES('".$ldoctorappointment_row['appointNumber']."','".$ldoctorappointment_row['centerID']."','".$ldoctorappointment_row['staffID']."','".$ldoctorappointment_row['patientID']."','".$ldoctorappointment_row['appointmentDate']."','".$ldoctorappointment_row['appointmentTime']."','".$ldoctorappointment_row['status']."','".$ldoctorappointment_row['reason']."','".$ldoctorappointment_row['sms']."','".$ldoctorappointment_row['dateInsert']."') ");


				if($doctorappointment_insert){
					echo "L_DOCTORAPPOINTMENT UPDATED";
				}else{
					echo "ERROR: R_DOCTORAPPOINTMENT";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_doctorappointment_sql = select("SELECT * FROM doctorappointment WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_doctorappointment_sql as $ldoctorappointment_row){

			//check duplication in remote
			$rdoctorappointment_duplicate_sql = select2("select * from doctorappointment where doe='".$ldoctorappointment_row['doe']."' ");

			if(count($rdoctorappointment_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$doctorappointment_insert = insert2("INSERT INTO quatitso_quatmedic.doctorappointment(appointNumber,centerID,staffID,patientID,appointmentDate,appointmentTime,status,reason,sms,dateInsert) VALUES('".$ldoctorappointment_row['appointNumber']."','".$ldoctorappointment_row['centerID']."','".$ldoctorappointment_row['staffID']."','".$ldoctorappointment_row['patientID']."','".$ldoctorappointment_row['appointmentDate']."','".$ldoctorappointment_row['appointmentTime']."','".$ldoctorappointment_row['status']."','".$ldoctorappointment_row['reason']."','".$ldoctorappointment_row['sms']."','".$ldoctorappointment_row['dateInsert']."') ");


				if($dispensary_tb_insert){
					echo "R_DOCTORAPPOINTMENT UPDATED";
				}else{
					echo "ERROR: R_DOCTORAPPOINTMENT";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_doctorappointmentsql = select2("select * from quatitso_quatmedic.doctorappointment WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_doctorappointmentsql as $remote_doctorappointmentrow){
//echo $remote_bloodrow['donorID'];

		$lo_doctorappointmentinsert = insert("INSERT INTO doctorappointment(appointNumber,centerID,staffID,patientID,appointmentDate,appointmentTime,status,reason,sms,dateInsert) VALUES('".$ldoctorappointment_row['appointNumber']."','".$ldoctorappointment_row['centerID']."','".$ldoctorappointment_row['staffID']."','".$ldoctorappointment_row['patientID']."','".$ldoctorappointment_row['appointmentDate']."','".$ldoctorappointment_row['appointmentTime']."','".$ldoctorappointment_row['status']."','".$ldoctorappointment_row['reason']."','".$ldoctorappointment_row['sms']."','".$ldoctorappointment_row['dateInsert']."') ");



			}


//		}




			}else{
				echo "TABLE L_DOCTORAPPOINTMENT is NOT EQUAL to TABLE R_DOCTORAPPOINTMENT";
			}


}



function emergency_patient(){

//	check number of local bedlist columns
$sql = "select count(*) as lemergency_patient from information_schema.columns where table_schema='$dbname' and table_name='emergency_patient'";
	$lemergency_patientcolumn_sql = select($sql);
foreach($lemergency_patientcolumn_sql as $lemergency_patientcolumn_row){}

//	check number of remote bedlist columns
	$remergency_patientcolumn_sql = select2("select count(*) as remergency_patient from information_schema.columns where table_schema='$dbname2' and table_name='emergency_patient'");
foreach($remergency_patientcolumn_sql as $remergency_patientcolumn_row){}

	if($lemergency_patientcolumn_row['lemergency_patient'] = $remergency_patientcolumn_row['remergency_patient']){

//check table remote_bedlist
		$remergency_patientlimit_sql = select2("SELECT * FROM emergency_patient WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($remergency_patientlimit_sql)>=1){
	foreach($remergency_patientlimit_sql as $remergency_patientlimit_row){

		//search where local_doe is greater than remote_doe
		$local_emergency_patient_sql = select("SELECT * FROM emergency_patient WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$remergency_patientlimit_row['dateRegistered']."' ");
		foreach($local_emergency_patient_sql as $lemergency_patient_row){

			//check duplication in remote
			$remergency_patient_duplicate_sql = select2("select * from quatitso_quatmedic.emergency_patient where emeID='".$lemergency_patient_row['emeID']."' ");

			if(count($remergency_patient_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$emergency_patient_insert = insert2("INSERT INTO quatitso_quatmedic.emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateAdmitted,dateRegistered,doe) VALUES('".$lemergency_patient_row['emeID']."','".$lemergency_patient_row['patientID']."','".$lemergency_patient_row['patientName']."','".$lemergency_patient_row['gender']."','".$lemergency_patient_row['centerID']."','".$lemergency_patient_row['gName']."','".$lemergency_patient_row['gMobile']."','".$lemergency_patient_row['gAddress']."','".$lemergency_patient_row['dateAdmitted']."','".$lemergency_patient_row['dateRegistered']."','".$lemergency_patient_row['doe']."') ");


				if($emergency_patient_insert){
					echo "L_emergency_patient UPDATED";
				}else{
					echo "ERROR: R_emergency_patient";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_emergency_patient_sql = select("SELECT * FROM emergency_patient WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_emergency_patient_sql as $lemergency_patient_row){

			//check duplication in remote
			$remergency_patient_duplicate_sql = select2("select * from emergency_patient where doe='".$lemergency_patient_row['doe']."' ");

			if(count($remergency_patient_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$emergency_patient_insert = insert2("INSERT INTO quatitso_quatmedic.emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateAdmitted,dateRegistered,doe) VALUES('".$lemergency_patient_row['emeID']."','".$lemergency_patient_row['patientID']."','".$lemergency_patient_row['patientName']."','".$lemergency_patient_row['gender']."','".$lemergency_patient_row['centerID']."','".$lemergency_patient_row['gName']."','".$lemergency_patient_row['gMobile']."','".$lemergency_patient_row['gAddress']."','".$lemergency_patient_row['dateAdmitted']."','".$lemergency_patient_row['dateRegistered']."','".$lemergency_patient_row['doe']."') ");



				if($dispensary_tb_insert){
					echo "R_emergency_patient UPDATED";
				}else{
					echo "ERROR: R_emergency_patient";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_emergency_patientsql = select2("select * from quatitso_quatmedic.emergency_patient WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_emergency_patientsql as $remote_emergency_patientrow){
//echo $remote_bloodrow['donorID'];

		$lo_emergency_patientinsert = insert("INSERT INTO
		emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateAdmitted,dateRegistered,doe) VALUES('".$lemergency_patient_row['emeID']."','".$lemergency_patient_row['patientID']."','".$lemergency_patient_row['patientName']."','".$lemergency_patient_row['gender']."','".$lemergency_patient_row['centerID']."','".$lemergency_patient_row['gName']."','".$lemergency_patient_row['gMobile']."','".$lemergency_patient_row['gAddress']."','".$lemergency_patient_row['dateAdmitted']."','".$lemergency_patient_row['dateRegistered']."','".$lemergency_patient_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_emergency_patient is NOT EQUAL to TABLE R_emergency_patient";
			}


}


function eme_vitals(){

//	check number of local bedlist columns
$sql = "select count(*) as leme_vitals from information_schema.columns where table_schema='$dbname' and table_name='eme_vitals'";
	$leme_vitalscolumn_sql = select($sql);
foreach($leme_vitalscolumn_sql as $leme_vitalscolumn_row){}

//	check number of remote bedlist columns
	$reme_vitalscolumn_sql = select2("select count(*) as reme_vitals from information_schema.columns where table_schema='$dbname2' and table_name='eme_vitals'");
foreach($reme_vitalscolumn_sql as $reme_vitalscolumn_row){}

	if($leme_vitalscolumn_row['leme_vitals'] = $reme_vitalscolumn_row['reme_vitals']){

//check table remote_bedlist
		$reme_vitalslimit_sql = select2("SELECT * FROM eme_vitals WHERE centerID='".$_SESSION['centerID']."' ORDER BY dateRegistered ASC LIMIT 1");
		if(count($reme_vitalslimit_sql)>=1){
	foreach($reme_vitalslimit_sql as $reme_vitalslimit_row){

		//search where local_doe is greater than remote_doe
		$local_eme_vitals_sql = select("SELECT * FROM eme_vitals WHERE centerID='".$_SESSION['centerID']."' && dateRegistered >= '".$reme_vitalslimit_row['dateRegistered']."' ");
		foreach($local_eme_vitals_sql as $leme_vitals_row){

			//check duplication in remote
			$reme_vitals_duplicate_sql = select2("select * from quatitso_quatmedic.eme_vitals where emeID='".$leme_vitals_row['emeID']."' ");

			if(count($reme_vitals_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$eme_vitals_insert = insert2("INSERT INTO quatitso_quatmedic.eme_vitals(emeID,centerID,patientID,bodyTemp,pulseRate,respirationRate,bloodPressure,weight,height,dateRegistered,doe) VALUES('".$leme_vitals_row['emeID']."','".$leme_vitals_row['centerID']."','".$leme_vitals_row['patientID']."','".$leme_vitals_row['bodyTemp']."','".$leme_vitals_row['pulseRate']."','".$leme_vitals_row['respirationRate']."','".$leme_vitals_row['bloodPressure']."','".$leme_vitals_row['weight']."','".$leme_vitals_row['height']."','".$leme_vitals_row['dateRegistered']."','".$leme_vitals_row['doe']."') ");


				if($eme_vitals_insert){
					echo "L_eme_vitals UPDATED";
				}else{
					echo "ERROR: R_eme_vitals";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_eme_vitals_sql = select("SELECT * FROM eme_vitals WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_eme_vitals_sql as $leme_vitals_row){

			//check duplication in remote
			$reme_vitals_duplicate_sql = select2("select * from eme_vitals where doe='".$leme_vitals_row['doe']."' ");

			if(count($reme_vitals_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$eme_vitals_insert = insert2("INSERT INTO quatitso_quatmedic.eme_vitals(emeID,centerID,patientID,bodyTemp,pulseRate,respirationRate,bloodPressure,weight,height,dateRegistered,doe) VALUES('".$leme_vitals_row['emeID']."','".$leme_vitals_row['centerID']."','".$leme_vitals_row['patientID']."','".$leme_vitals_row['bodyTemp']."','".$leme_vitals_row['pulseRate']."','".$leme_vitals_row['respirationRate']."','".$leme_vitals_row['bloodPressure']."','".$leme_vitals_row['weight']."','".$leme_vitals_row['height']."','".$leme_vitals_row['dateRegistered']."','".$leme_vitals_row['doe']."') ");



				if($eme_vitals_insert){
					echo "R_eme_vitals UPDATED";
				}else{
					echo "ERROR: R_eme_vitals";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_eme_vitalssql = select2("select * from quatitso_quatmedic.eme_vitals WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_eme_vitalssql as $remote_eme_vitalsrow){
//echo $remote_bloodrow['donorID'];

		$lo_eme_vitalsinsert = insert("INSERT INTO eme_vitals(emeID,centerID,patientID,bodyTemp,pulseRate,respirationRate,bloodPressure,weight,height,dateRegistered,doe) VALUES('".$leme_vitals_row['emeID']."','".$leme_vitals_row['centerID']."','".$leme_vitals_row['patientID']."','".$leme_vitals_row['bodyTemp']."','".$leme_vitals_row['pulseRate']."','".$leme_vitals_row['respirationRate']."','".$leme_vitals_row['bloodPressure']."','".$leme_vitals_row['weight']."','".$leme_vitals_row['height']."','".$leme_vitals_row['dateRegistered']."','".$leme_vitals_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_eme_vitals is NOT EQUAL to TABLE R_eme_vitals";
			}


}



function eme_ward(){

//	check number of local bedlist columns
$sql = "select count(*) as leme_ward from information_schema.columns where table_schema='$dbname' and table_name='eme_ward'";
	$leme_wardcolumn_sql = select($sql);
foreach($leme_wardcolumn_sql as $leme_wardcolumn_row){}

//	check number of remote bedlist columns
	$reme_wardcolumn_sql = select2("select count(*) as reme_ward from information_schema.columns where table_schema='$dbname2' and table_name='eme_ward'");
foreach($reme_wardcolumn_sql as $reme_wardcolumn_row){}

	if($leme_wardcolumn_row['leme_ward'] = $reme_wardcolumn_row['reme_ward']){

//check table remote_bedlist
		$reme_wardlimit_sql = select2("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($reme_wardlimit_sql)>=1){
	foreach($reme_wardlimit_sql as $reme_wardlimit_row){

		//search where local_doe is greater than remote_doe
		$local_eme_ward_sql = select("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."' && doe >= '".$reme_wardlimit_row['doe']."' ");
		foreach($local_eme_ward_sql as $leme_ward_row){

			//check duplication in remote
			$reme_ward_duplicate_sql = select2("select * from quatitso_quatmedic.eme_ward where emeID='".$leme_ward_row['emeID']."' ");

			if(count($reme_ward_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$eme_ward_insert = insert2("INSERT INTO quatitso_quatmedic.eme_ward(eme_medID,dateRegistered,prescrib_med,dosage,prescribed_by,patientID,emeID,centerID,nurseID,med_status,today_status,doc_comment,doe) VALUES('".$leme_ward_row['eme_medID']."','".$leme_ward_row['dateRegistered']."','".$leme_ward_row['prescrib_med']."','".$leme_ward_row['dosage']."','".$leme_ward_row['prescribed_by']."','".$leme_ward_row['patientID']."','".$leme_ward_row['emeID']."','".$leme_ward_row['centerID']."','".$leme_ward_row['nurseID']."','".$leme_ward_row['med_status']."','".$leme_ward_row['today_status']."','".$leme_ward_row['doc_comment']."','".$leme_ward_row['doe']."') ");


				if($eme_ward_insert){
					echo "L_eme_ward UPDATED";
				}else{
					echo "ERROR: R_eme_ward";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_eme_ward_sql = select("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_eme_ward_sql as $leme_ward_row){

			//check duplication in remote
			$reme_ward_duplicate_sql = select2("select * from eme_ward where doe='".$leme_ward_row['doe']."' ");

			if(count($reme_ward_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$eme_ward_insert = insert2("INSERT INTO quatitso_quatmedic.eme_ward(eme_medID,dateRegistered,prescrib_med,dosage,prescribed_by,patientID,emeID,centerID,nurseID,med_status,today_status,doc_comment,doe) VALUES('".$leme_ward_row['eme_medID']."','".$leme_ward_row['dateRegistered']."','".$leme_ward_row['prescrib_med']."','".$leme_ward_row['dosage']."','".$leme_ward_row['prescribed_by']."','".$leme_ward_row['patientID']."','".$leme_ward_row['emeID']."','".$leme_ward_row['centerID']."','".$leme_ward_row['nurseID']."','".$leme_ward_row['med_status']."','".$leme_ward_row['today_status']."','".$leme_ward_row['doc_comment']."','".$leme_ward_row['doe']."') ");



				if($eme_ward_insert){
					echo "R_eme_ward UPDATED";
				}else{
					echo "ERROR: R_eme_ward";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_eme_wardsql = select2("select * from quatitso_quatmedic.eme_ward WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_eme_wardsql as $remote_eme_wardrow){
//echo $remote_bloodrow['donorID'];

		$lo_eme_wardinsert = insert("INSERT INTO eme_ward(eme_medID,dateRegistered,prescrib_med,dosage,prescribed_by,patientID,emeID,centerID,nurseID,med_status,today_status,doc_comment,doe) VALUES('".$leme_ward_row['eme_medID']."','".$leme_ward_row['dateRegistered']."','".$leme_ward_row['prescrib_med']."','".$leme_ward_row['dosage']."','".$leme_ward_row['prescribed_by']."','".$leme_ward_row['patientID']."','".$leme_ward_row['emeID']."','".$leme_ward_row['centerID']."','".$leme_ward_row['nurseID']."','".$leme_ward_row['med_status']."','".$leme_ward_row['today_status']."','".$leme_ward_row['doc_comment']."','".$leme_ward_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_eme_ward is NOT EQUAL to TABLE R_eme_ward";
			}


}


function lablist(){

//	check number of local bedlist columns
$sql = "select count(*) as llablist from information_schema.columns where table_schema='$dbname' and table_name='lablist'";
	$llablistcolumn_sql = select($sql);
foreach($llablistcolumn_sql as $llablistcolumn_row){}

//	check number of remote bedlist columns
	$rlablistcolumn_sql = select2("select count(*) as rlablist from information_schema.columns where table_schema='$dbname2' and table_name='lablist'");
foreach($rlablistcolumn_sql as $rlablistcolumn_row){}

	if($llablistcolumn_row['llablist'] = $rlablistcolumn_row['rlablist']){

//check table remote_bedlist
		$rlablistlimit_sql = select2("SELECT * FROM lablist WHERE centerID='".$_SESSION['centerID']."' ORDER BY doe ASC LIMIT 1");
		if(count($rlablistlimit_sql)>=1){
	foreach($rlablistlimit_sql as $rlablistlimit_row){

		//search where local_doe is greater than remote_doe
		$local_lablist_sql = select("SELECT * FROM lablist WHERE centerID='".$_SESSION['centerID']."' && doe >= '".$rlablistlimit_row['doe']."' ");
		foreach($local_lablist_sql as $llablist_row){

			//check duplication in remote
			$rlablist_duplicate_sql = select2("select * from quatitso_quatmedic.lablist where emeID='".$llablist_row['emeID']."' ");

			if(count($rlablist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
			$lablist_insert = insert2("INSERT INTO quatitso_quatmedic.lablist(labID,labName,centerID,doe) VALUES('".$llablist_row['labID']."','".$llablist_row['labName']."','".$llablist_row['centerID']."','".$llablist_row['doe']."') ");


				if($lablist_insert){
					echo "L_lablist UPDATED";
				}else{
					echo "ERROR: R_lablist";
				}
		}

		}
		}
		}else{


		//search local_bedlist

		$local_lablist_sql = select("SELECT * FROM lablist WHERE centerID='".$_SESSION['centerID']."' ");
		foreach($local_lablist_sql as $llablist_row){

			//check duplication in remote
			$rlablist_duplicate_sql = select2("select * from lablist where doe='".$llablist_row['doe']."' ");

			if(count($rlablist_duplicate_sql) < 1){

			//insert local_bedlist into remote_bedlist
				$lablist_insert = insert2("INSERT INTO quatitso_quatmedic.lablist(labID,labName,centerID,doe) VALUES('".$llablist_row['labID']."','".$llablist_row['labName']."','".$llablist_row['centerID']."','".$llablist_row['doe']."') ");



				if($lablist_insert){
					echo "R_lablist UPDATED";
				}else{
					echo "ERROR: R_lablist";
				}
		}

		}


		}


		//REMOTE_BEDLIST TO LOCAL_BEDLIST
//		echo $_SESSION['centerID'];
		//fetch all from remote_bedlist
		$remote_lablistsql = select2("select * from quatitso_quatmedic.lablist WHERE centerID !='".$_SESSION['centerID']."' ");

		foreach($remote_lablistsql as $remote_lablistrow){
//echo $remote_bloodrow['donorID'];

		$lo_lablistinsert = insert("INSERT INTO lablist(labID,labName,centerID,doe) VALUES('".$llablist_row['labID']."','".$llablist_row['labName']."','".$llablist_row['centerID']."','".$llablist_row['doe']."') ");




			}


//		}




			}else{
				echo "TABLE L_lablist is NOT EQUAL to TABLE R_lablist";
			}


}


?>
