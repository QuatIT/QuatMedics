<?php

  class User{

    public function createCenterAdmin($centerID,$centerName,$centerCategory,$centerLocation,$numOfStaff,$aboutCenter,$numOfBranches,$userName,$password,$accessLevel) {
      $result= insert("INSERT INTO medicalcenter(centerID,centerName,centerCategory,centerLocation,numOfStaff,centerHistory,numOfBranches,userName,password,accessLevel) VALUES('$centerID','$centerName','$centerCategory','$centerLocation','$numOfStaff','$aboutCenter','$numOfBranches','$userName','$password','$accessLevel') ");
      return $result;
    }

    public function find_by_centerID($centerID){
      $result=query("SELECT * FROM medicalcenter WHERE centerID='$centerID' ") ;
      return $result;
    }

    public function saveUserData($staffID,$firstName,$lastName,$otherName,$gender,$dob,$specialty,$staffCategory,$staffDepartment){
      $result=insert("INSERT INTO staff(staffID,firstName,lastName,otherName,gender,dob,specialty,staffCategory,departmentID,dateRegistered) VALUES('$staffID','$firstName','$lastName','$otherName','$gender','$dob','$specialty','$staffCategory','$staffDepartment',CURDATE() ) ");
      return $result;
    }

    public function saveUserCredential($staffID,$username,$password,$accessLevel,$centerID){
      $result=insert("INSERT INTO centerUser(userID,userName,password,accessLevel,centerID,dateRegistered) VALUES('$staffID','$username','$password','$accessLevel','$centerID',CURDATE() ) ") ;
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

      public function consultAssignPatient($consultID,$staffID,$bodyTemperature,$pulseRate,$respirationRate,$bloodPressure,$weight,$otherHealth,$roomID,$patientID){
          $result= insert("INSERT INTO consultation(consultID,staffID,bodyTemperature,pulseRate,respirationRate,bloodPressure,weight,otherHealth,roomID,patientID) VALUES('$consultID','$staffID','$bodyTemperature','$pulseRate','$respirationRate','$bloodPressure','$weight','$otherHealth','$roomID','$patientID') ");
          return $result;
    }

      public function createConsultRoom($consultRoomID,$centerID,$roomName){
          $result= insert("INSERT INTO consultingroom(roomID,centerID,roomName,dateRegistered) VALUES('$consultRoomID','$centerID','$roomName',CURDATE() ) ");
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

    public function find_ward(){
      $result=query("SELECT * FROM wardlist ");
      return $result;
    }


    public function find_num_ward(){
      $result=query("SELECT * FROM wardlist ");
      $num = count($result);

      return $num;
    }



  }



  class Patient{

    public function createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress) {
      $result= insert("INSERT INTO patient(centerID,patientId,firstName,lastName,otherName,dob,gender,bloodGroup,homeAddress,phoneNumber,guardianName,guardianGender,guardianPhone,guardianRelation,guardianAddress,dateRegistered) VALUES('$centerID','$patientId','$firstName','$lastName','$otherName','$dob','$gender','$bloodGroup','$homeAddress','$phoneNumber','$guardianName','$guardianGender','$guardianPhone','$guardianRelation','$guardianAddress',CURDATE() ) ");
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

  ?>
