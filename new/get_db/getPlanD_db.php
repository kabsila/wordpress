<?php

include_once ( '../connectDB.php' );
mysql_select_db("diabetes") or die("Unable To Connect To Northwind");
mysql_query("SET NAMES UTF8");
//$arr = array();
//$rs = mysql_query("SELECT ID, name, sname FROM general_info");
//while ($obj = mysql_fetch_object($rs)) {
//  $arr[] = $obj;
//}
header("Content-type: application/json");
//$verb = filter_input(INPUT_SERVER, "REQUEST_METHOD");
$type = filter_input(INPUT_GET, "type");


//$updateFootDate = filter_input(INPUT_POST, "updateFootDate");


if ($type == "readTrainD") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM train_d WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updateTrainD") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));  
    
    $date = mysql_real_escape_string(filter_input(INPUT_POST, "date"));
    $mainD = mysql_real_escape_string(filter_input(INPUT_POST, "main_d"));
    $trainerName = mysql_real_escape_string(filter_input(INPUT_POST, "trainer_name"));    
    
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_id"));
    
    $rs = mysql_query("UPDATE train_d SET "
            . "date = '$date', "
            . "main_d = '$mainD', "
            . "trainer_name = '$trainerName' "                    
            . "WHERE id = $employeeId AND date_id = $number") or die("Error in query: $rs. " . mysql_error());
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "createTrainD") {

    //$id2 = mysql_real_escape_string(filter_input(INPUT_POST, "id2"));
    //$dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    // $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));    

    $trainDID = filter_input(INPUT_GET, "trainDID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $date = mysql_real_escape_string($request_vars["date"]);
    $mainD = mysql_real_escape_string($request_vars["main_d"]);
    $trainerName = mysql_real_escape_string($request_vars["trainer_name"]);
    

    $rs = mysql_query("INSERT INTO train_d (id, date, main_d, trainer_name) VALUES "
            . "('$trainDID', '$date', '$mainD', '$trainerName')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroyTrainD") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id")); 
   
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_id"));
 //echo "DELETE FROM social WHERE id = $employeeId AND order = $number";
    $rs = mysql_query("DELETE FROM train_d WHERE id = $employeeId AND date_id = $number") or die("Error in query: $rs. " . mysql_error());

   
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}

if ($type == "readPlanD") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM plan_d WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updatePlanD") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));  
    
    $mainTakecare = mysql_real_escape_string(filter_input(INPUT_POST, "main_takecare"));
    $takecare = mysql_real_escape_string(filter_input(INPUT_POST, "takecare"));
    $nameD = mysql_real_escape_string(filter_input(INPUT_POST, "name_d"));   
    $note = mysql_real_escape_string(filter_input(INPUT_POST, "note")); 
    
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "idd"));
    
    $rs = mysql_query("UPDATE plan_d SET "
            . "main_takecare = '$mainTakecare', "
            . "takecare = '$takecare', "
            . "name_d = '$nameD', " 
            . "note = '$note' "                   
            . "WHERE id = $employeeId AND idd = $number") or die("Error in query: $rs. " . mysql_error());
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "createPlanD") {

    //$id2 = mysql_real_escape_string(filter_input(INPUT_POST, "id2"));
    //$dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    // $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));    

    $planDID = filter_input(INPUT_GET, "planDID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $mainTakecare = mysql_real_escape_string($request_vars["main_takecare"]);
    $takecare = mysql_real_escape_string($request_vars["takecare"]);
    $nameD = mysql_real_escape_string($request_vars["name_d"]);
    $note = mysql_real_escape_string($request_vars["note"]);    

    $rs = mysql_query("INSERT INTO plan_d (id, main_takecare, takecare, name_d, note) VALUES "
            . "('$planDID', '$mainTakecare', '$takecare', '$nameD', '$note')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroyPlanD") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id")); 
   
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "idd"));
 //echo "DELETE FROM social WHERE id = $employeeId AND order = $number";
    $rs = mysql_query("DELETE FROM plan_d WHERE id = $employeeId AND idd = $number") or die("Error in query: $rs. " . mysql_error());

   
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}




?>