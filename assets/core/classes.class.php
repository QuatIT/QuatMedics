<?php

  class User{

    public function createCenterAdmin($centerID,$centerName,$centerCategory,$centerLocation,$numOfStaff,$aboutCenter,$numOfBranches,$userName,$password,$accessLevel,$email) {
      $result= insert("INSERT INTO medicalcenter(centerID,centerName,centerCategory,centerLocation,numOfStaff,centerHistory,numOfBranches,userName,password,accessLevel,dateregistered,centerEmail) VALUES('$centerID','$centerName','$centerCategory','$centerLocation','$numOfStaff','$aboutCenter','$numOfBranches','$userName','$password','$accessLevel',CURDATE(),'$email' ) ");
      return $result;
    }

    public function find_by_centerID($centerID){
      $result=query("SELECT * FROM medicalcenter WHERE centerID='$centerID' ") ;
      return $result;
    }

    public function saveUserData($staffID,$firstName,$lastName,$otherName,$gender,$dob,$specialty,$staffCategory,$staffDepartment,$email,$centerID){
      $result=insert("INSERT INTO staff(staffID,firstName,lastName,otherName,gender,dob,specialty,staffCategory,departmentID,dateRegistered,email,centerID) VALUES('$staffID','$firstName','$lastName','$otherName','$gender','$dob','$specialty','$staffCategory','$staffDepartment',CURDATE(),'$email','$centerID' ) ");
      return $result;
    }

    public function saveUserCredential($staffID,$username,$password,$accessLevel,$centerID,$userID){
      $result=insert("INSERT INTO centerUser(userID,userName,password,accessLevel,centerID,dateRegistered,staffID) VALUES('$staffID','$username','$password','$accessLevel','$centerID',CURDATE(),'$userID' ) ") ;
      return $result;
    }

    public function centerAdminLogin($username,$password){
      $result=query("SELECT * FROM medicalCenter WHERE username='$username' && password='$password' ") ;
      return $result;
    }

    public function centerUserLogin($username,$password){
      $result=query("SELECT * FROM centerUser WHERE username='$username' && password='$password' ") ;
      return $result;
    }

    public function find_num_centerID(){
      $result=query("SELECT * FROM medicalcenter ");
      $num = count($result);

      return $num;
    }

    public function find_num_staffID(){
      $result=query("SELECT * FROM centerUser ");
      $num = count($result);

      return $num;
    }

  }


  class Consultation{

      public function consultAssignPatient($consultID,$staffID,$bodyTemperature,$pulseRate,$respirationRate,$bloodPressure,$weight,$otherHealth,$roomID,$patientID,$mode,$insuranceType,$insuranceNumber,$company,$status,$centerID){
          $result= insert("INSERT INTO consultation(consultID,staffID,bodyTemperature,pulseRate,respirationRate,bloodPressure,weight,otherHealth,roomID,patientID,mode,insuranceType,insuranceNumber,company,status,centerID) VALUES('$consultID','$staffID','$bodyTemperature','$pulseRate','$respirationRate','$bloodPressure','$weight','$otherHealth','$roomID','$patientID','$mode','$insuranceType','$insuranceNumber','$company','$status','$centerID') ");
          return $result;
    }

      public function createConsultRoom($consultRoomID,$centerID,$roomName,$status){
          $result= insert("INSERT INTO consultingroom(roomID,centerID,roomName,dateRegistered,status) VALUES('$consultRoomID','$centerID','$roomName',CURDATE(),'$status' ) ");
          return $result;
    }

      public function createAppointment($appointNumber,$staffID,$patientID,$appointDate,$appointTime){
          $result= insert("INSERT INTO doctorappointment(appointNumber,staffID,patientID,appointmentDate,appointmentTime) VALUES('$appointNumber','$staffID','$patientID','$appointDate','$appointTime') ");
          return $result;
    }

    public function find_by_room_id($roomID){
      $result=query("SELECT * FROM consultingroom WHERE roomID='".$roomID."'");
      return $result;
    }

    public function find_consultingroom(){
      $result=query("SELECT * FROM consultingroom");
      return $result;
    }

    public function loadConsultRoomByID($centerID){
      $result=query("SELECT * FROM consultingroom WHERE centerID='$centerID' ") ;
      return $result;
    }


    public function loadConsultRoom(){
      $result=query("SELECT * FROM consultingroom ") ;
      $num = count($result);

      return $num;
    }


    public function find_num_consults(){
      $result=query("SELECT * FROM consultation ");
      $num = count($result);

      return $num;
    }


    public function find_num_transfer(){
      $result=query("SELECT * FROM transfer ");
      $num = count($result);

      return $num;
    }


  }


  class Ward{

      public function createWard($WardID,$centerID,$wardName,$numOfBeds){
          $result= insert("INSERT INTO wardlist(WardID,centerID,wardName,numOfBeds,dateRegistered) VALUES('$WardID','$centerID','$wardName','$numOfBeds',CURDATE() ) ");
          return $result;
    }


    public function find_by_ward_id($wardID){
      $result=query("SELECT * FROM wardlist WHERE wardID='".$wardID."' ");
      return $result;
    }

    public function find_by_wardAssign_id($wardID){
      $result=query("SELECT * FROM wardassigns WHERE wardID='".$wardID."' ");
      return $result;
    }

    public function find_by_wardPatient_id($patientID){
      $result=query("SELECT * FROM wardassigns WHERE patientID='".$patientID."' ");
      return $result;
    }

    public function find_ward(){
      $result=query("SELECT * FROM wardlist ");
      return $result;
    }


    public function find_num_ward(){
      $result=query("SELECT * FROM wardlist ");
      $num = count($result);

      return $num;
    }


   public function saveBeds($centerID,$bedID,$bedNumber,$bedDescription,$bedCharge,$wardID,$bedStatus){
        $result = insert("INSERT INTO bedlist(centerID,bedID,bedNumber,bedDescription,BedCharge,wardID,status) VALUES('".$centerID."','".$bedID."','".$bedNumber."','".$bedDescription."','".$bedCharge."','".$wardID."','".$bedStatus."') ");
           return $result;
    }
      public function get_bed_id(){
  $result=query("SELECT * FROM bedlist WHERE wardID='".$_GET['wrdno']."'");
  $num = count($result);

  return $num;

  }

  }

  class Patient{

    public function createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress,$filedestination,$hometown) {
      $result= insert("INSERT INTO patient(centerID,patientId,firstName,lastName,otherName,dob,gender,bloodGroup,homeAddress,phoneNumber,guardianName,guardianGender,guardianPhone,guardianRelation,guardianAddress,dateRegistered,patient_image,hometown) VALUES('$centerID','$patientId','$firstName','$lastName','$otherName','$dob','$gender','$bloodGroup','$homeAddress','$phoneNumber','$guardianName','$guardianGender','$guardianPhone','$guardianRelation','$guardianAddress',CURDATE(),'$filedestination','$hometown' ) ");
      return $result;
    }


    public function find_patient(){
      $result=query("SELECT * FROM patient ");
      return $result;
    }


    public function find_by_patient_id($patientID){
      $result=query("SELECT * FROM patient WHERE patientID='".$patientID."' ");
      return $result;
    }


    public function find_num_Patient(){
      $result=query("SELECT * FROM patient ");
      $num = count($result);

      return $num;
    }

    public function find_num_staffID(){
      $result=query("SELECT * FROM centerUser ");
      $num = count($result);

      return $num;
    }


  }



  class Birth{

    public function RegisterBaby($babyID,$babyFirstName,$babyOtherName,$babylastName,$babyName,$dob,$motherName,$fatherName,$birthTime,$country,$status) {
      $result= insert("INSERT INTO birth(babyID,babyFirstName,babyOtherName,babylastName,fullname,dob,motherName,fatherName,birthTime,country,status,dateRegistered) VALUES('$babyID','$babyFirstName','$babyOtherName','$babylastName','$babyName','$dob','$motherName','$fatherName','$birthTime','$country','$status',CURDATE() ) ");
      return $result;
    }


    public function find_by_baby_id($babyID){
      $result=query("SELECT * FROM birth WHERE babyID='".$babyID."' ");
      return $result;
    }


    public function find_birth(){
      $result=query("SELECT * FROM birth ");
      return $result;
    }


    public function find_num_Birth(){
      $result=query("SELECT * FROM birth ");
      $num = count($result);

      return $num;
    }

  }


  class Death{

//    public function RegisterBaby($babyID,$babyFirstName,$babyOtherName,$babylastName,$babyName,$dob,$motherName,$fatherName,$birthTime,$country,$status) {
//      $result= insert("INSERT INTO birth(babyID,babyFirstName,babyOtherName,babylastName,fullname,dob,motherName,fatherName,birthTime,country,status,dateRegistered) VALUES('$babyID','$babyFirstName','$babyOtherName','$babylastName','$babyName','$dob','$motherName','$fatherName','$birthTime','$country','$status',CURDATE() ) ");
//      return $result;
//    }
//
//
//    public function find_by_baby_id($babyID){
//      $result=query("SELECT * FROM birth WHERE babyID='".$babyID."' ");
//      return $result;
//    }


//    public function find_birth(){
//      $result=query("SELECT * FROM birth ");
//      return $result;
//    }


    public function find_num_Death(){
      $result=query("SELECT * FROM death ");
      $num = count($result);

      return $num;
    }

  }




  class Lab{

    public function createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress) {
      $result= insert("INSERT INTO patient(centerID,patientId,firstName,lastName,otherName,dob,gender,bloodGroup,homeAddress,phoneNumber,guardianName,guardianGender,guardianPhone,guardianRelation,guardianAddress,dateRegistered) VALUES('$centerID','$patientId','$firstName','$lastName','$otherName','$dob','$gender','$bloodGroup','$homeAddress','$phoneNumber','$guardianName','$guardianGender','$guardianPhone','$guardianRelation','$guardianAddress',CURDATE() ) ");
      return $result;
    }


    public function find_by_patient_id($patientID){
      $result=query("SELECT * FROM patient WHERE patientID='".$patientID."' ");
      return $result;
    }


    public function find_num_Lab(){
      $result=query("SELECT * FROM lablist ");
      $num = count($result);

      return $num;
    }

    public function find_num_staffID(){
      $result=query("SELECT * FROM centerUser ");
      $num = count($result);

      return $num;
    }


  }



  class blood{

    public function Blood_IDAssign($bloodID,$donorID,$centerID,$donorName,$bloodGender,$bloodGroup,$phoneNumber,$dob,$lastDonate){
        $result= insert("INSERT INTO bloodbank(bloodID,donorID,centerID,donorName,gender,bloodgroup,phoneNumber,dob,lastDonate) VALUES('$bloodID','$donorID','$centerID','$donorID','$gender','$bloodgroup','$homeAddress','$phoneNumber','$dob','$lastDonate') ");
        return $result;
  }

  public function get_bld_amt(){
    $result=query("SELECT * FROM bloodgroup_tb ");
    $num = count($result);

    return $num;
  }
}

class Donor{
  public function donor_id($bloodID,$donorID,$centerID,$donorName,$bloodGender,$bloodGroup,$phoneNumber,$dob,$lastDonate){
    $result = insert("INSERT INTO bloodbank(bloodID,donorID,centerID,donorName,gender,bloodgroup,phoneNumber,dob,lastDonate) VALUES('$bloodID','$donorID','$centerID','$donorID','$gender','$bloodgroup','$homeAddress','$phoneNumber','$dob','$lastDonate') ");
    return $result;
}

public function get_donor_id(){
  $result=query("SELECT * FROM bloodbank");
  $num = count($result);

  return $num;

  }
}

class Dashboard{
//  public function donor_id($bloodID,$donorID,$centerID,$donorName,$bloodGender,$bloodGroup,$phoneNumber,$dob,$lastDonate){
//    $result = insert("INSERT INTO bloodbank(bloodID,donorID,centerID,donorName,gender,bloodgroup,phoneNumber,dob,lastDonate) VALUES('$bloodID','$donorID','$centerID','$donorID','$gender','$bloodgroup','$homeAddress','$phoneNumber','$dob','$lastDonate') ");
//    return $result;
//}

public function totalPatient($centerID){
  $result=query("SELECT * FROM patient WHERE centerID='$centerID' ");
  $num = count($result);

  return $num;

  }

public function privatePatient($centerID){
    $sql = "SELECT * FROM consultation WHERE mode='private' && DATE(doe) = CURDATE() && centerID='$centerID'  ";
  $result=query($sql);
  $num = count($result);

  return $num;

  }

public function insurancePatient($centerID){
  $result=query("SELECT * FROM consultation WHERE centerID='$centerID' && mode='insurance' && DATE(doe) = CURDATE() ");
  $num = count($result);

  return $num;

  }

public function companyPatient($centerID){
  $result=query("SELECT * FROM consultation WHERE centerID='$centerID' && mode='company' && DATE(doe) = CURDATE() ");
  $num = count($result);

  return $num;

  }

public function availableConsultingRoom($centerID){
  $result=query("SELECT * FROM consultingroom WHERE centerID='$centerID' && status='free' ");
  $num = count($result);

  return $num;

  }

public function occupiedConsultingRoom($centerID){
  $result=query("SELECT * FROM consultingroom WHERE centerID='$centerID' && status='occupied' ");
  $num = count($result);

  return $num;

  }

public function awaitingPatient($centerID,$roomID){
  $result=query("SELECT * FROM consultation WHERE centerID='$centerID' && roomID='$roomID' && status='sent_to_consulting' ");
  $num = count($result);

  return $num;

  }

public function numLabResults($centerID,$roomID){
  $result=query("SELECT * FROM labresults WHERE centerID='$centerID' && consultingRoom='$roomID' ");
  $num = count($result);

  return $num;

  }

public function numWardPatient($centerID,$roomID){
  $result=query("SELECT * FROM wardassigns WHERE centerID='$centerID' && consultingroom='$roomID' ");
  $num = count($result);

  return $num;

  }

public function numLabRequests($centerID){
  $result=query("SELECT * FROM labresults WHERE centerID='$centerID' && status='sent_to_lab' ");
  $num = count($result);

  return $num;

  }

public function numBloodDonor($centerID){
  $result=query("SELECT * FROM bloodbank WHERE centerID='$centerID' ");
  $num = count($result);

  return $num;

  }




}


  ?>
