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

    $rs = mysql_query("SELECT foot.*,max(lab_result.HbA1C) AS HbA1C ,max(lab_result.FBS) AS FBS,general_info.age,"
            . "general_info.status, general_info.smoke,general_info.tai_y "
            . "FROM foot,general_info,lab_result "
            . "WHERE lab_result.id = general_info.ID "
            . "AND foot.id = general_info.ID AND general_info.ID = $id;") or die("Error in query: $rs. " . mysql_error());

    while ($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }
    //$arr = array_merge($arr, $arr3);
    //echo "{\"data\":" . json_encode($arr) . "}";
    //unset($arr);
    $arr2 = array();
    $rs = mysql_query("SELECT * FROM footDate WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr2[] = $obj;
    }
    //echo "{\"dataFootDate\":" . json_encode($arr2) . "}";

    echo "{\"data\":" . json_encode($arr) . ",\"dataFootDate\":" . json_encode($arr2) . "}";
}

// handle a POST  
if ($type == "update") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));

    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));
    $rs = mysql_query("UPDATE footDate SET "
            . "dateFoot = '$dateFoot', "
            . "resultFoot = '$resultFoot' "
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

    $footID = filter_input(INPUT_GET, "footID");
    $request_vars = Array();
    parse_str(file_get_contents('php://input'), $request_vars);

    // DISCLAIMER: It is better to use PHP prepared statements to communicate with the database.
    //             this provides better protection against SQL injection.
    //             [http://php.net/manual/en/pdo.prepared-statements.php][4]
    // get the parameters from the get. escape them to protect against sql injection.
    //$id2 = mysql_real_escape_string($request_vars["id2"]);
    $dateFoot = mysql_real_escape_string($request_vars["dateFoot"]);
    $resultFoot = mysql_real_escape_string($request_vars["resultFoot"]);

    $rs = mysql_query("INSERT INTO footdate (id, dateFoot, resultFoot) VALUES "
            . "('$footID', '$dateFoot', '$resultFoot')") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {

        echo json_encode($request_vars);
        //echo json_encode("OK");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "destroy") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $dateFoot = mysql_real_escape_string(filter_input(INPUT_POST, "dateFoot"));
    $resultFoot = mysql_real_escape_string(filter_input(INPUT_POST, "resultFoot"));
    $number = mysql_real_escape_string(filter_input(INPUT_POST, "number"));

    $rs = mysql_query("DELETE FROM footDate WHERE id = $employeeId AND number = $number") or die("Error in query: $rs. " . mysql_error());

    //echo "DELETE FROM footdate WHERE id = $employeeId AND number = $number";
    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "save") {

    $footID = filter_input(INPUT_GET, "footID");
    $output_dir = "footImage/";
    $random_digit = rand(00000, 99999);

    if (isset($_FILES["myfile"])) {
        $ret = array();

        $error = $_FILES["myfile"]["error"];
        if (!is_array($_FILES["myfile"]["name"])) { //single file
            $fileName = $random_digit . $_FILES["myfile"]["name"];
            $ret[$fileName] = $output_dir . $fileName;
            move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);


            $rs = mysql_query("INSERT INTO footimage (id, image) VALUES "
                    . "('$footID', '$fileName')") or die("Error in query: $rs. " . mysql_error());
        } else {
            $fileCount = count($_FILES["myfile"]["name"]);
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $random_digit . $_FILES["myfile"]["name"][$i];
                $ret[$fileName] = $output_dir . $fileName;
                move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);

                $rs2 = "INSERT INTO footimage (id, image) 
                             VALUES ('$footID', '$fileName')";
                $rs = mysql_query($rs) or die("Error in query: $rs. " . mysql_error());
            }
        }
        echo json_encode($ret);
    }
}
?>