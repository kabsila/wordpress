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
$verb = filter_input(INPUT_SERVER, "REQUEST_METHOD");

$updateFootDate = filter_input(INPUT_POST, "updateFootDate");


if ($verb == "GET") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();
    $rs = mysql_query("SELECT * FROM foot WHERE id = $id");
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }   
    //echo "{\"data\":" . json_encode($arr) . "}";
    
    //unset($arr);
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM footDate WHERE id = $id");
    while ($obj = mysql_fetch_object($rs)) {

        $arr2[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";
    
    echo "{\"data\":" . json_encode($arr) .",\"dataFootDate\":". json_encode($arr2) . "}";
}

// handle a POST  
if ($verb == "POST") {
    

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));
    $rs = '';
    if($updateFootDate){
        
        
        $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));
        $rs = mysql_query("UPDATE footDate SET "
            . "dateFoot = '$dateFoot', "
            . "resultFoot = '$resultFoot' "            
            . "WHERE id = $employeeId AND number = $number");
        
         
    }
    
    if ($rs) {
            echo json_encode($rs);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }

   
}

if ($verb == "PUT") {
    
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars );
    
    $id2 = mysql_real_escape_string($request_vars["id2"]);
    $dateFoot = mysql_real_escape_string($request_vars["dateFoot"]);
    $resultFoot = mysql_real_escape_string($request_vars["resultFoot"]);
   // $rs = '';
     $rs = mysql_query("INSERT INTO footDate (id, dateFoot, resultFoot) VALUES "
                . "('$id2', '$dateFoot', '$resultFoot')");  
     
    if ($rs) {
            echo json_encode($rs);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
             echo "INSERT INTO footDate (id, dateFoot, resultFoot) VALUES "
                . "('$id2', '$dateFoot', '$resultFoot')";
        }
}
?>