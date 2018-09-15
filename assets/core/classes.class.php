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

  class Patient{

    public function createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress) {
      $result= insert("INSERT INTO patient(centerID,patientId,firstName,lastName,otherName,dob,gender,bloodGroup,homeAddress,phoneNumber,guardianName,guardianGender,guardianPhone,guardianRelation,guardianAddress) VALUES('$centerID','$patientId','$firstName','$lastName','$otherName','$dob','$gender','$bloodGroup','$homeAddress','$phoneNumber','$guardianName','$guardianGender','$guardianPhone','$guardianRelation','$guardianAddress') ");
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
