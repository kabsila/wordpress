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
 $id = filter_input(INPUT_GET, "id");

//$updateFootDate = filter_input(INPUT_POST, "updateFootDate");


if ($type == "readSugar") {
   
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM lab_result WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo json_encode($arr);
}

if ($type == "readSocial") {
   
    $arr = array();
    
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM social WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo json_encode($arr);
}




?>