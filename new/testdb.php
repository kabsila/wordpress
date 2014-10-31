<?php

include_once ( 'connectDB.php' );
mysql_select_db("diabetes") or die("Unable To Connect To Northwind");
mysql_query("SET NAMES UTF8");
//$arr = array();

//$rs = mysql_query("SELECT ID, name, sname FROM general_info");

//while ($obj = mysql_fetch_object($rs)) {
  //  $arr[] = $obj;
//}
header("Content-type: application/json");
$verb = filter_input(INPUT_SERVER, "REQUEST_METHOD");
$type = filter_input(INPUT_GET, "type");

if ($verb == "GET") {
    $arr = array();

    $rs = mysql_query("SELECT ID, name, sname FROM general_info");

    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    echo "{\"data\":" . json_encode($arr) . "}";
}

// handle a POST  
if ($type == "update") {

    // DISCLAIMER: It is better to use PHP prepared statements to communicate with the database. 
    //             this provides better protection against SQL injection.
    //             [http://php.net/manual/en/pdo.prepared-statements.php][4]
    // get the parameters from the post. escape them to protect against sql injection.

    $lastName = mysql_real_escape_string($_POST["sname"]);
    $employeeId = mysql_real_escape_string($_POST["ID"]);

    $rs = mysql_query("UPDATE general_info SET sname = '" . $lastName . "' WHERE ID = " . $employeeId);

    if ($rs) {
        echo json_encode($rs);
    }
    else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Update failed for EmployeeID: " .$employeeId;
    }
}

if ($type == "create") {
    
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);
    
    $name = mysql_real_escape_string($request_vars["name"]);
    $sname = mysql_real_escape_string($request_vars["sname"]);
   
    $rs = mysql_query("INSERT INTO general_info (name, sname) VALUES "
            . "('$name', '$sname')") or die("Error in query: $rs. " . mysql_error());
    
    $lastid = mysql_insert_id();
    
    $rs = mysql_query("INSERT INTO address (id) VALUES "
            . "('$lastid')") or die("Error in query: $rs. " . mysql_error());
    
    $rs = mysql_query("INSERT INTO foot (id) VALUES "
            . "('$lastid')") or die("Error in query: $rs. " . mysql_error());
    
   $rs = mysql_query("INSERT INTO eye (id) VALUES "
            . "('$lastid')") or die("Error in query: $rs. " . mysql_error());
   
   $rs = mysql_query("INSERT INTO tai (id) VALUES "
            . "('$lastid')") or die("Error in query: $rs. " . mysql_error());
   
   $rs = mysql_query("INSERT INTO blood (id) VALUES "
            . "('$lastid')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {
        echo json_encode($rs);
    }
    else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Update failed for EmployeeID: " .$employeeId;
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "ID"));   

    $rs = mysql_query("DELETE FROM general_info WHERE id = $employeeId") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM footdate WHERE id = $employeeId AND number = $number";
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}
?>