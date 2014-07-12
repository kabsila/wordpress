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
//$verb = $_SERVER["REQUEST_METHOD"];

if ($verb == "GET") {
    $arr = array();

    $rs = mysql_query("SELECT ID, name, sname FROM general_info");

    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    echo "{\"data\":" . json_encode($arr) . "}";
}

// handle a POST  
if ($verb == "POST") {

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
?>