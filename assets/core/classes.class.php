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



    public function find_all(){
      $result=query("SELECT * FROM student ") ;
      return $result;
    }

      public function insert_student($student_name,$email){
          $result = insert("INSERT INTO student(stdent_name,email) VALUES('$student_name','$email') ");
          return $result;
      }


  }

  class Faculty{

    public function add_faculty($faculty_id,$faculty_name) {
      $result= insert("INSERT INTO faculty(faculty_id,faculty_name) VALUES ('$faculty_id','$faculty_name')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM faculty ") ;
      return $result;
    }

      public function find_all1($faculty_id){
      $result=query("SELECT * FROM faculty WHERE faculty='".$faculty_id."'") ;
      return $result;
    }

      public function chk_fac($faculty_name){
      $result=query("SELECT * FROM faculty WHERE faculty_name='".$faculty_name."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

 class Department{

    public function add_department($faculty_id,$dept_id,$dept_name) {
      $result= insert("INSERT INTO department(faculty_id,dept_id,dept_name) VALUES ('$faculty_id','$dept_id','$dept_name')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM department ") ;
      return $result;
    }

      public function find_all1($faculty_id){
      $result=query("SELECT * FROM department WHERE faculty_id='".$faculty_id."'") ;
      return $result;
    }

      public function ch_dep($faculty_id,$dept_name){
      $result=query("SELECT * FROM department WHERE faculty_id='".$faculty_id."' || dept_name='".$dept_name."' ") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

 class Semester{

    public function add_sem($faculty_id,$dept_id,$sem_id,$sem,$academic_yr) {
      $result= insert("INSERT INTO semester(faculty_id,dept_id,sem_id,sem,academic_yr) VALUES ('$faculty_id','$dept_id','$sem_id','$sem','$academic_yr')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM semester ") ;
      return $result;
    }

      public function find_all1($faculty_id,$dept_id){
      $result=query("SELECT * FROM semester WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."'") ;
      return $result;
    }

      public function ch_sem($faculty_id,$sem){
      $result=query("SELECT * FROM semester WHERE faculty_id='".$faculty_id."' AND sem='".$sem."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

 class Level{

    public function add_level($level,$faculty_id,$dept_id,$sem_id,$academic_yr) {
      $result= insert("INSERT INTO level_tb(level,faculty_id,dept_id,sem_id,academic_yr) VALUES ('$level','$faculty_id','$dept_id','$sem_id','$academic_yr')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM level_tb ") ;
      return $result;
    }

      public function find_all1($faculty_id,$dept_id,$sem_id){
      $result=query("SELECT * FROM level_tb WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."' AND sem_id='".$sem_id."'") ;
      return $result;
    }

      public function ch_level($faculty_id,$dept_id,$sem_id,$level,$academic_yr){
      $result=query("SELECT * FROM level_tb WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."' AND sem_id='".$sem_id."' AND level='".$level."' AND academic_yr='".$academic_yr."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

 class Session_School{

    public function add_sess($session_id,$session_name,$faculty_id,$dept_id,$sem_id,$academic_yr,$level) {
      $result= insert("INSERT INTO session(session_id,session_name,faculty_id,dept_id,sem_id,academic_yr,level) VALUES ('$session_id','$session_name','$faculty_id','$dept_id','$sem_id','$academic_yr','$level')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM session ") ;
      return $result;
    }

    public function ch_sess($faculty_id,$dept_id,$sem_id,$level,$academic_yr,$session_name){
      $result=query("SELECT * FROM session WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."' AND sem_id='".$sem_id."' AND level='".$level."' AND academic_yr='".$academic_yr."' AND session_name='".$session_name."'") ;
      return $result;
    }

      public function find_all1($faculty_id,$dept_id,$sem_id){
      $result=query("SELECT * FROM session WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."' AND sem_id='".$sem_id."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

 class Venue{

    public function add_venue($venue_id,$venue,$faculty_id,$dept_id) {
      $result= insert("INSERT INTO venue(venue_id,venue,faculty_id,dept_id) VALUES ('$venue_id','$venue','$faculty_id','$dept_id')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM venue ") ;
      return $result;
    }

      public function find_all1($faculty_id,$dept_id){
      $result=query("SELECT * FROM venue WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."' ") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

   class Course{

    public function add_course($course_id,$faculty_id,$course_name,$dept_id) {
      $result= insert("INSERT INTO course(course_id,faculty_id,course_name,dept_id) VALUES ('$course_id','$faculty_id','$course_name','$dept_id')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM course ") ;
      return $result;
    }
    public function chk_cos($course_id,$course_name,$dept_id){
      $result=query("SELECT * FROM course WHERE course_name='".$course_name."' || $course_id='".$course_id."' && dept_id='".$dept_id."'") ;
      return $result;
    }
 public function find_all1($faculty_id,$dept_id){
      $result=query("SELECT * FROM course  WHERE faculty_id='".$faculty_id."' AND dept_id='".$dept_id."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }


   class Lecturer{

    public function add_lecture($lec_id,$lec_name,$faculty_id,$contact,$dept_id) {
      $result= insert("INSERT INTO lecture_tb(lec_id,lec_name,faculty_id,contact,dept_id) VALUES ('$lec_id','$lec_name','$faculty_id','$contact','$dept_id')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM lecture_tb ") ;
      return $result;
    }

    public function find_all1($faculty_id,$dept_id){
      $result=query("SELECT * FROM lecture_tb  WHERE faculty_id='".$faculty_id."' AND dept_id = '".$dept_id."'") ;
      return $result;
    }

    public function ch_lec($faculty_id,$lec_name){
      $result=query("SELECT * FROM lecture_tb  WHERE faculty_id='".$faculty_id."' AND lec_name = '".$lec_name."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }



   class Duration{

    public function add_duration($duration,$faculty_id) {
      $result= insert("INSERT INTO time_tb(duration,faculty_id) VALUES ('$duration','$faculty_id')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM time_tb ") ;
      return $result;
    }

    public function find_all1($faculty){
      $result=query("SELECT * FROM time_tb  WHERE faculty='".$faculty_id."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }



   class Day{

    public function add_day($day,$faculty_id,$dept_id) {
      $result= insert("INSERT INTO days_tb(days,faculty_id,dept_id) VALUES ('$day','$faculty_id','$dept_id')") ;
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM days_tb ") ;
      return $result;
    }

    public function find_all1($faculty_id){
      $result=query("SELECT * FROM days_tb WHERE faculty='".$faculty_id."'") ;
      return $result;
    }

    public function ch_day($day,$faculty_id,$dept_id){
      $result=query("SELECT * FROM days_tb WHERE faculty='".$faculty_id."' && dept_id='".$dept_id."' && day='".$day."'") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }



   class Timetable{

    public function add_timetable($lec_id,$course_id,$time_id,$day_id,$faculty_id,$venue_id,$dept_id,$session_id,$level,$academic_yr,$sem_id) {
      $result = insert("INSERT INTO timetable(lec_id,course_id,time_id,day_id,faculty_id,venue_id,dept_id,session_id,level,academic_yr,sem_id) VALUES('$lec_id','$course_id','$time_id','$day_id','$faculty_id','$venue_id','$dept_id','$session_id','$level','$academic_yr','$sem_id')");
      return $result;
    }

    public function find_all(){
      $result=query("SELECT * FROM timetable ") ;
      return $result;
    }
 public function find_all1($faculty_id){
      $result=query("SELECT * FROM timetable  WHERE faculty='".$faculty_id."'") ;
      return $result;
    }


 public function chech($lec_id,$venue_id,$time_id,$day_id,$course_id,$faculty_id,$dept_id,$sem_id,$academic_yr,$session_id){
      $result=query("SELECT * FROM timetable  WHERE lec_id='".$lec_id."' AND time_id='".$time_id."' AND venue_id='".$venue_id."' AND day_id='".$day_id."' AND course_id='".$course_id."' AND faculty_id='".$faculty_id."' && dept_id='".$dept_id."' && sem_id='".$sem_id."' && academic_yr='".$academic_yr."' && session_id='".$session_id."' ") ;
      return $result;
    }

 public function chech_dt($day_id,$time_id,$faculty_id,$dept_id,$sem_id,$academic_yr,$session_id){
      $result=query("SELECT * FROM timetable  WHERE time_id='".$time_id."' AND  day_id='".$day_id."' AND faculty_id='".$faculty_id."' && dept_id='".$dept_id."' && sem_id='".$sem_id."' && academic_yr='".$academic_yr."' && session_id='".$session_id."'  ") ;
      return $result;
    }

 public function chech_tv($time_id,$venue_id,$day_id,$faculty_id,$dept_id,$sem_id,$academic_yr,$session_id){
      $result=query("SELECT * FROM timetable  WHERE time_id='".$time_id."' AND  venue_id='".$venue_id."'  AND  day_id='".$day_id."' AND faculty_id='".$faculty_id."' && dept_id='".$dept_id."' && sem_id='".$sem_id."' && academic_yr='".$academic_yr."' && session_id='".$session_id."'  ") ;
      return $result;
    }

 public function chech_lc($lec_id,$course_id,$day_id,$faculty_id,$dept_id,$sem_id,$academic_yr,$session_id){
      $result=query("SELECT * FROM timetable  WHERE lec_id='".$lec_id."' AND  course_id='".$course_id."' AND  day_id='".$day_id."'  AND faculty_id='".$faculty_id."' && dept_id='".$dept_id."' && sem_id='".$sem_id."' && academic_yr='".$academic_yr."' && session_id='".$session_id."'  ") ;
      return $result;
    }


public function find_alls(){
      $result=query("SELECT * FROM timetable GROUP BY day_id") ;
      return $result;
    }

    public function update_admin($id,$username,$password){
      $result=update("UPDATE admin SET username='$username', password='$password' WHERE id='$id'") ;
      return $result;
    }

    public function delete_admin($id){
      $result=delete("DELETE FROM admin WHERE id='$id'") ;
      return $result;
    }

    public function number_of_admin(){
      $result=query("SELECT * FROM admin WHERE access='1'");
      $num = count($result);

      return $num;
    }

    public function number_of_admin2(){
      $result=query("SELECT * FROM admin WHERE access='2' ");
      $num = count($result);

      return $num;
    }

  }

  ?>
