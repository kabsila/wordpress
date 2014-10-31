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


if ($type == "readSocial") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM social WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updateSocial") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));  
    
    $date = mysql_real_escape_string(filter_input(INPUT_POST, "date"));
    $adl = mysql_real_escape_string(filter_input(INPUT_POST, "ADL"));
    $psycho = mysql_real_escape_string(filter_input(INPUT_POST, "Psycho"));
    $qol = mysql_real_escape_string(filter_input(INPUT_POST, "QOL"));
    $other = mysql_real_escape_string(filter_input(INPUT_POST, "other"));
    
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_order"));
    
    $rs = mysql_query("UPDATE social SET "
            . "date = '$date', "
            . "ADL = '$adl', "
            . "Psycho = '$psycho', "
            . "QOL = '$qol', "
            . "other = '$other' "          
            . "WHERE id = $employeeId AND date_order = $number") or die("Error in query: $rs. " . mysql_error());
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

    $socialID = filter_input(INPUT_GET, "socialID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $date = mysql_real_escape_string($request_vars["date"]);
    $adl = mysql_real_escape_string($request_vars["ADL"]);
    $psycho = mysql_real_escape_string($request_vars["Psycho"]);
    $qol = mysql_real_escape_string($request_vars["QOL"]);
    $other = mysql_real_escape_string($request_vars["other"]);
    

    $rs = mysql_query("INSERT INTO social (id, date, ADL, Psycho, QOL, other) VALUES "
            . "('$socialID', '$date', '$adl', '$psycho', '$qol', '$other')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id")); 
   
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "date_order"));
 //echo "DELETE FROM social WHERE id = $employeeId AND order = $number";
    $rs = mysql_query("DELETE FROM social WHERE id = $employeeId AND date_order = $number") or die("Error in query: $rs. " . mysql_error());

   
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}




?>