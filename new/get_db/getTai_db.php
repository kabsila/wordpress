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
    $rs = mysql_query("SELECT * FROM taidate WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "update") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateTai = mysql_real_escape_string(filter_input(INPUT_POST, "dateTai"));
    $resultTai = mysql_real_escape_string(filter_input(INPUT_POST, "resultTai"));

    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));
    $rs = mysql_query("UPDATE taidate SET "
            . "dateTai = '$dateTai', "
            . "resultTai = '$resultTai' "
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

    $taiID = filter_input(INPUT_GET, "taiID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    $dateTai = mysql_real_escape_string($request_vars["dateTai"]);
    $resultTai = mysql_real_escape_string($request_vars["resultTai"]);

    $rs = mysql_query("INSERT INTO taidate (id, dateTai, resultTai) VALUES "
            . "('$taiID', '$dateTai', '$resultTai')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateTai = mysql_real_escape_string(filter_input(INPUT_POST, "dateTai"));
    $resultTai = mysql_real_escape_string(filter_input(INPUT_POST, "resultTai"));
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));

    $rs = mysql_query("DELETE FROM taidate WHERE id = $employeeId AND number = $number") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM footdate WHERE id = $employeeId AND number = $number";
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "updateTai") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $urine = mysql_real_escape_string(filter_input(INPUT_POST, "urine"));
    $micro = mysql_real_escape_string(filter_input(INPUT_POST, "micro"));
    $creatine = mysql_real_escape_string(filter_input(INPUT_POST, "creatine"));
    $gfr = mysql_real_escape_string(filter_input(INPUT_POST, "gfr"));
    $result = mysql_real_escape_string(filter_input(INPUT_POST, "result"));    
    
    $rs = mysql_query("UPDATE tai SET "
            . "urine = '$urine', "
            . "micro = '$micro', "
            . "creatine = '$creatine',"
            . "gfr = '$gfr', "            
            . "result = '$result' "
            . "WHERE id = $employeeId ") or die("Error in query: $rs. " . mysql_error());
    
    if ($rs) {    
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "readTai") {

    $id = filter_input(INPUT_GET, "id");
    $arr = array();    
    
    $rs = mysql_query("SELECT tai.*, general_info.status, general_info.age "
            . "FROM tai, general_info "
            . "WHERE tai.id = general_info.id AND tai.id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}


?>