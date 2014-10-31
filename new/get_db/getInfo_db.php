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
$id = filter_input(INPUT_GET, "id");

if ($verb == "GET") {
    $arr = array();

    //$rs = mysql_query("SELECT general_info.*, address.* FROM general_info WHERE ID = $id");
    $rs = mysql_query("SELECT general_info.*, address.* FROM general_info, address WHERE general_info.ID = $id AND address.id = $id");

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
    $name = mysql_real_escape_string(filter_input(INPUT_POST, "name"));
    $sname = mysql_real_escape_string(filter_input(INPUT_POST, "sname"));
    $age = mysql_real_escape_string(filter_input(INPUT_POST, "age"));
    $name_d = mysql_real_escape_string(filter_input(INPUT_POST, "name_d"));
    $relation = mysql_real_escape_string(filter_input(INPUT_POST, "relation"));
    $h_blood = mysql_real_escape_string(filter_input(INPUT_POST, "h_blood"));
    $tai_y = mysql_real_escape_string(filter_input(INPUT_POST, "tai_y"));
    $h_fail = mysql_real_escape_string(filter_input(INPUT_POST, "h_fail"));
    $hi_fat = mysql_real_escape_string(filter_input(INPUT_POST, "hi_fat"));
    $h_lost_blood = mysql_real_escape_string(filter_input(INPUT_POST, "h_lost_blood"));
    $h_big = mysql_real_escape_string(filter_input(INPUT_POST, "h_big"));
    $cabg = mysql_real_escape_string(filter_input(INPUT_POST, "cabg"));
    $brain_blood = mysql_real_escape_string(filter_input(INPUT_POST, "brain_blood"));
    $other = mysql_real_escape_string(filter_input(INPUT_POST, "other"));
    $smoke = mysql_real_escape_string(filter_input(INPUT_POST, "smoke"));
    $whenCancelSmoke = mysql_real_escape_string(filter_input(INPUT_POST, "whenCancelSmoke"));    
    $numberSmoke = mysql_real_escape_string(filter_input(INPUT_POST, "numberSmoke"));

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "ID"));
    
    $hn = mysql_real_escape_string(filter_input(INPUT_POST, "hn"));
    $marriage = mysql_real_escape_string(filter_input(INPUT_POST, "marriage"));
    $kum = mysql_real_escape_string(filter_input(INPUT_POST, "kum"));
    $address_num = mysql_real_escape_string(filter_input(INPUT_POST, "address_num"));
    $moo = mysql_real_escape_string(filter_input(INPUT_POST, "moo"));
    $road = mysql_real_escape_string(filter_input(INPUT_POST, "road"));
    $aumphor = mysql_real_escape_string(filter_input(INPUT_POST, "aumphor"));
    $tumbol = mysql_real_escape_string(filter_input(INPUT_POST, "tumbol"));
    $city = mysql_real_escape_string(filter_input(INPUT_POST, "city"));
    $zipcode = mysql_real_escape_string(filter_input(INPUT_POST, "zipcode"));
    $longitude = mysql_real_escape_string(filter_input(INPUT_POST, "longitude"));
    $latitude = mysql_real_escape_string(filter_input(INPUT_POST, "latitude"));
    $date_accp = mysql_real_escape_string(filter_input(INPUT_POST, "date_accp"));

    $rs = mysql_query("UPDATE general_info SET "
            . "name = '$name', "
            . "sname = '$sname', "
            . "age = '$age', "
            . "name_d = '$name_d',"
            . "relation = '$relation',"
            . "h_blood = '$h_blood',"
            . "tai_y = '$tai_y',"
            . "h_fail = '$h_fail',"
            . "hi_fat = '$hi_fat',"
            . "h_lost_blood = '$h_lost_blood',"
            . "h_big = '$h_big',"
            . "other = '$other', "
            . "smoke = '$smoke', "
            . "whenCancelSmoke = '$whenCancelSmoke',"
            . "numberSmoke = '$numberSmoke', "
            . "hn = '$hn', "
            . "marriage = '$marriage', "
            . "kum = '$kum' "            
            . "WHERE ID = $employeeId") or die("Error in query: $rs. " . mysql_error());
    
    $rs2 = mysql_query("UPDATE address SET "            
            . "address_num = '$address_num', "
            . "moo = '$moo', "
            . "road = '$road', "
            . "aumphor = '$aumphor', "
            . "tumbol = '$tumbol', "
            . "city = '$city', "
            . "zipcode = '$zipcode', "
            . "longitude = '$longitude', "
            . "latitude = '$latitude', "
            . "date_accp = '$date_accp' "
            . "WHERE ID = $employeeId") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        
    }
}
?>