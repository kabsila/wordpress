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


if ($type == "readSugar") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM lab_result WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updateSugar") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));  
    
    $date = mysql_real_escape_string(filter_input(INPUT_POST, "date"));
    $fbs = mysql_real_escape_string(filter_input(INPUT_POST, "FBS"));
    $ldl = mysql_real_escape_string(filter_input(INPUT_POST, "LDL"));
    $hdl = mysql_real_escape_string(filter_input(INPUT_POST, "HDL"));
    $chol = mysql_real_escape_string(filter_input(INPUT_POST, "cholesterol"));
    $tg = mysql_real_escape_string(filter_input(INPUT_POST, "tg"));
    $cre = mysql_real_escape_string(filter_input(INPUT_POST, "creatinine"));
    $bun = mysql_real_escape_string(filter_input(INPUT_POST, "BUN"));
    $hba1c = mysql_real_escape_string(filter_input(INPUT_POST, "HbA1C"));
    
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_id"));
    
    $rs = mysql_query("UPDATE lab_result SET "
            . "date = '$date', "
            . "FBS = '$fbs', "
            . "LDL = '$ldl', "
            . "HDL = '$hdl', "
            . "cholesterol = '$chol', "
            . "tg = '$tg', "
            . "creatinine = '$cre', "
            . "BUN = '$bun', "
            . "HbA1C = '$hba1c' "
            . "WHERE id = $employeeId AND date_id = $number") or die("Error in query: $rs. " . mysql_error());
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "create") {

    //$id2 = mysql_real_escape_string(filter_input(INPUT_POST, "id2"));
    //$dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    // $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));    

    $sugarID = filter_input(INPUT_GET, "sugarID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $date = mysql_real_escape_string($request_vars["date"]);
    $fbs = mysql_real_escape_string($request_vars["FBS"]);
    $ldl = mysql_real_escape_string($request_vars["LDL"]);
    $hdl = mysql_real_escape_string($request_vars["HDL"]);
    $chol = mysql_real_escape_string($request_vars["cholesterol"]);
    $tg = mysql_real_escape_string($request_vars["tg"]);
    $cre = mysql_real_escape_string($request_vars["creatinine"]);
    $bun = mysql_real_escape_string($request_vars["BUN"]);
    $hba1c = mysql_real_escape_string($request_vars["HbA1C"]);

    $rs = mysql_query("INSERT INTO lab_result (id, date, FBS, LDL, HDL, cholesterol, tg, creatinine, BUN, HbA1C) VALUES "
            . "('$sugarID', '$date', '$fbs', '$ldl', '$hdl', '$chol', '$tg', '$cre', '$bun', '$hba1c')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id")); 
   
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_id"));

    $rs = mysql_query("DELETE FROM lab_result WHERE id = $employeeId AND date_id = $number") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM lab_result WHERE id = $employeeId AND date_id = $number"
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}




?>