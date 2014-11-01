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


if ($type == "read") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM visit_home WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "update") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));  
    
    $n = mysql_real_escape_string(filter_input(INPUT_POST, "n"));
    $osm = mysql_real_escape_string(filter_input(INPUT_POST, "osm"));
    $staff = mysql_real_escape_string(filter_input(INPUT_POST, "staff")); 
    $visitOrder = mysql_real_escape_string(filter_input(INPUT_POST, "visit_order"));
    $rubType = mysql_real_escape_string(filter_input(INPUT_POST, "rub_type"));
    $familyEnvi = mysql_real_escape_string(filter_input(INPUT_POST, "family_envi"));
    
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "visit_number"));
    
    $rs = mysql_query("UPDATE visit_home SET "
            . "n = '$n', "
            . "osm = '$osm', "
            . "staff = '$staff', "
            . "visit_order = '$visitOrder', "
            . "rub_type = '$rubType', "
            . "family_envi = '$familyEnvi' "                                
            . "WHERE id = $employeeId AND visit_number = $number") or die("Error in query: $rs. " . mysql_error());
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

    $visitHomeID = filter_input(INPUT_GET, "VisitHomeID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $n = mysql_real_escape_string($request_vars["n"]);
    $osm = mysql_real_escape_string($request_vars["osm"]);
    $staff = mysql_real_escape_string($request_vars["staff"]);
    $visitOrder = mysql_real_escape_string($request_vars["visit_order"]);
    $rubType = mysql_real_escape_string($request_vars["rub_type"]);
    $familyEnvi = mysql_real_escape_string($request_vars["family_envi"]);    
    

    $rs = mysql_query("INSERT INTO visit_home (id, n, osm, staff, visit_order, rub_type, family_envi) VALUES "
            . "('$visitHomeID', '$n', '$osm', '$staff', '$visitOrder', '$rubType', '$familyEnvi')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id")); 
   
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "visit_number"));
 //echo "DELETE FROM social WHERE id = $employeeId AND order = $number";
    $rs = mysql_query("DELETE FROM visit_home WHERE id = $employeeId AND visit_number = $number") or die("Error in query: $rs. " . mysql_error());

   
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}






?>