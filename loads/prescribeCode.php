<?php
include '../assets/core/connection.php';
     //generate presciptionCode
        $codesql = select("SELECT prescribeCode From prescriptions order by prescribeCode DESC limit 1");
        if(count($codesql) >=1){
            foreach($codesql as $coderow){
                $id = $coderow['prescribeCode'];
                $oldid = explode("-",$id);
                $newID = $oldid[1]+1;
                $prescribeCode = $oldid[0]."-".$newID;
            }
        }else{
            $prescribeCode = "PRSCB-1";
        }

?>

