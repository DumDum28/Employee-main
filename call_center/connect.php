<?php
    $contact = $_POST['contact'];
    $contact_number = $_POST['contact_number'];
    $patient_name = $_POST['patient_name'];
    $patient_age = $_POST['patient_age'];
    $cause = $_POST['cause'];
    $start_point = $_POST['start_point'];
    $hospital = $_POST['hospital'];

    //database connection
    $con = new mysqli('localhost', 'root', '', 'for_test');
    if($con->connect_error){
        die('Connection Failed : '.$con->connect_error);
    }else{
        $stm = $con->prepare("insert into emergency_report(contact, contact_number, patient_name, patient_age, cause, start_point, hospital) 
            values(?, ?, ?, ?, ?, ?, ?)");
        $stm->bind_param("ssssiss", $contact, $contact_number, $patient_name, $patient_age, $cause, $start_point, $hospital);
        $stm->execute();
        echo "Emergency Report Submitted Successfully";
        $stm->close();
        $con->close();
    }
?>



