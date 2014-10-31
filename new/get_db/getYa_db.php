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
    $rs = mysql_query("SELECT * FROM ya WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "update") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $yaName = mysql_real_escape_string(filter_input(INPUT_POST, "ya_name"));
    $yaEat = mysql_real_escape_string(filter_input(INPUT_POST, "ya_eat"));
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "ya_order"));
    
    $rs = mysql_query("UPDATE ya SET "
            . "ya_name = '$yaName', "
            . "ya_eat = '$yaEat' "
            . "WHERE id = $employeeId AND ya_order = $number") or die("Error in query: $rs. " . mysql_error());
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

    $yaID = filter_input(INPUT_GET, "yaID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $yaName = mysql_real_escape_string($request_vars["ya_name"]);
    $yaEat = mysql_real_escape_string($request_vars["ya_eat"]);

    $rs = mysql_query("INSERT INTO ya (id, ya_name, ya_eat) VALUES "
            . "('$yaID', '$yaName', '$yaEat')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $yaName = mysql_real_escape_string(filter_input(INPUT_POST, "ya_name"));
    $yaEat = mysql_real_escape_string(filter_input(INPUT_POST, "ya_eat"));
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "ya_order"));

    $rs = mysql_query("DELETE FROM ya WHERE id = $employeeId AND ya_order = $number") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM footdate WHERE id = $employeeId AND number = $number";
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}


?>