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



if ($type == "updateBlood") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $risk1 = mysql_real_escape_string(filter_input(INPUT_POST, "risk1"));
    $risk2 = mysql_real_escape_string(filter_input(INPUT_POST, "risk2"));
    $risk3 = mysql_real_escape_string(filter_input(INPUT_POST, "risk3"));
    $risk3Text = mysql_real_escape_string(filter_input(INPUT_POST, "risk3Text"));
   
    
    
    $rs = mysql_query("UPDATE blood SET "
            . "risk1 = '$risk1', "
            . "risk2 = '$risk2', "
            . "risk3 = '$risk3', "
            . "risk3Text = '$risk3Text' "            
            . "WHERE id = $employeeId ") or die("Error in query: $rs. " . mysql_error());
    
    if ($rs) {    
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "readBlood") {

    $id = filter_input(INPUT_GET, "id");
    $arr = array();    
    
    $rs = mysql_query("SELECT * FROM blood WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . "}";
}

?>