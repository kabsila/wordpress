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
    $rs = mysql_query("SELECT * FROM eyedate WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "update") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateEye = mysql_real_escape_string(filter_input(INPUT_POST, "dateEye"));
    $resultEye = mysql_real_escape_string(filter_input(INPUT_POST, "resultEye"));

    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));
    $rs = mysql_query("UPDATE eyedate SET "
            . "dateEye = '$dateEye', "
            . "resultEye = '$resultEye' "
            . "WHERE id = $employeeId AND number = $number") or die("Error in query: $rs. " . mysql_error());
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

    $eyeID = filter_input(INPUT_GET, "eyeID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $dateEye = mysql_real_escape_string($request_vars["dateEye"]);
    $resultEye = mysql_real_escape_string($request_vars["resultEye"]);

    $rs = mysql_query("INSERT INTO eyedate (id, dateEye, resultEye) VALUES "
            . "('$eyeID', '$dateEye', '$resultEye')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateEye = mysql_real_escape_string(filter_input(INPUT_POST, "dateEye"));
    $resultEye = mysql_real_escape_string(filter_input(INPUT_POST, "resultEye"));
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));

    $rs = mysql_query("DELETE FROM eyedate WHERE id = $employeeId AND number = $number") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM footdate WHERE id = $employeeId AND number = $number";
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "updateEye") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $result = mysql_real_escape_string(filter_input(INPUT_POST, "result"));
    $va = mysql_real_escape_string(filter_input(INPUT_POST, "va"));
    $nextDate = mysql_real_escape_string(filter_input(INPUT_POST, "nextDate"));
    
    
    $rs = mysql_query("UPDATE eye SET "
            . "result = '$result', "
            . "va = '$va', "
            . "nextDate = '$nextDate'"            
            . "WHERE id = $employeeId ") or die("Error in query: $rs. " . mysql_error());
    
    if ($rs) {    
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "readEye") {

    $id = filter_input(INPUT_GET, "id");
    $arr = array();    
    
    $rs = mysql_query("SELECT * FROM eye WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

?>