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

if ($type == "updateFoot") {

    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $foot1 = mysql_real_escape_string(filter_input(INPUT_POST, "foot1"));
    $foot2 = mysql_real_escape_string(filter_input(INPUT_POST, "foot2"));
    $foot3 = mysql_real_escape_string(filter_input(INPUT_POST, "foot3"));
    $foot4 = mysql_real_escape_string(filter_input(INPUT_POST, "foot4"));
    $foot5 = mysql_real_escape_string(filter_input(INPUT_POST, "foot5"));
    $foot6 = mysql_real_escape_string(filter_input(INPUT_POST, "foot6"));
    $foot7 = mysql_real_escape_string(filter_input(INPUT_POST, "foot7"));
    $foot8 = mysql_real_escape_string(filter_input(INPUT_POST, "foot8"));
    $foot9 = mysql_real_escape_string(filter_input(INPUT_POST, "foot9"));
    $foot10 = mysql_real_escape_string(filter_input(INPUT_POST, "foot10"));
    $foot11 = mysql_real_escape_string(filter_input(INPUT_POST, "foot11"));
    $foot12 = mysql_real_escape_string(filter_input(INPUT_POST, "foot12"));
    //$risk = mysql_real_escape_string(filter_input(INPUT_POST, "risk"));
    $boolFoot1 = filter_var($foot1, FILTER_VALIDATE_BOOLEAN);
    $boolFoot2 = filter_var($foot2, FILTER_VALIDATE_BOOLEAN);
    $boolFoot3 = filter_var($foot3, FILTER_VALIDATE_BOOLEAN);
    $boolFoot4 = filter_var($foot4, FILTER_VALIDATE_BOOLEAN);
    $boolFoot5 = filter_var($foot5, FILTER_VALIDATE_BOOLEAN);
    $boolFoot6 = filter_var($foot6, FILTER_VALIDATE_BOOLEAN);
    $boolFoot7 = filter_var($foot7, FILTER_VALIDATE_BOOLEAN);
    $boolFoot8 = filter_var($foot8, FILTER_VALIDATE_BOOLEAN);
    $boolFoot9 = filter_var($foot9, FILTER_VALIDATE_BOOLEAN);
    $boolFoot10 = filter_var($foot10, FILTER_VALIDATE_BOOLEAN);
    $boolFoot11 = filter_var($foot11, FILTER_VALIDATE_BOOLEAN);
    $boolFoot12 = filter_var($foot12, FILTER_VALIDATE_BOOLEAN);
    
    if (!$boolFoot1 && !$boolFoot5 && !$boolFoot6 && !$boolFoot7 && !$boolFoot8 && !$boolFoot9) {
        $risk = 'low';
    } else if (!$boolFoot1 || !$boolFoot5 || ($boolFoot6 && $boolFoot7) || $boolFoot9 || $boolFoot8) {
        $risk = 'mid';
    } else if ($boolFoot1 || $boolFoot5 || ($boolFoot6 && $boolFoot7 && $boolFoot8) || $boolFoot9) {
        $risk = 'hight';
    }     
    // echo intval(!$foot1 && !$foot5 && !$foot6 && !$foot7 && !$foot8 && !$foot9);
    // echo intval(!$foot1 || !$foot5 || ($foot6 && $foot7) || $foot9 || $foot8);
    // echo intval($foot1 || $foot5 || ($foot6 && $foot7 && $foot8) || $foot9);
    $rs = mysql_query("UPDATE foot SET "
            . "foot1 = '$foot1', "
            . "foot2 = '$foot2', "
            . "foot3 = '$foot3', "
            . "foot4 = '$foot4', "
            . "foot5 = '$foot5', "
            . "foot6 = '$foot6', "
            . "foot7 = '$foot7', "
            . "foot8 = '$foot8', "
            . "foot9 = '$foot9', "
            . "foot10 = '$foot10', "
            . "foot11 = '$foot11', "
            . "foot12 = '$foot12', "
            . "risk = '$risk' "
            . "WHERE id = $employeeId ") or die("Error in query: $rs. " . mysql_error());
    
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

if ($type == "readFootImage") {
    $id = filter_input(INPUT_GET, "id");
    $arr = array();


    $rs = mysql_query("SELECT * FROM footimage WHERE id = $id") or die("Error in query: $rs. " . mysql_error());
    while ($obj = mysql_fetch_object($rs)) {

        $arr[] = $obj;
    }
    ///echo "{\"dataFootDate\":" . json_encode($arr2) . "}";
    //echo "{\"data\":" . json_encode($arr) . "}";
    echo json_encode($arr);
}

if ($type == "destroyFootImage") {
    // $id = filter_input(INPUT_GET, "id");
    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $imageID = mysql_real_escape_string(filter_input(INPUT_POST, "imageID"));
    $image = mysql_real_escape_string(filter_input(INPUT_POST, "image"));
    $arr = array();

    $rs = mysql_query("DELETE FROM footimage WHERE id = $employeeId AND imageID = $imageID"); // or die("Error in query: $rs. " . mysql_error());
    $flgDelete = unlink("footImage/$image");
    ///echo "{\"dataFootDate\":" . json_encode($arr2) . "}";
    if ($rs && $flgDelete) {
        // echo "DELETE FROM footimage WHERE id = $employeeId AND imageID = $imageID";
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        // echo "DELETE FROM footimage WHERE id = $employeeId AND imageID = $imageID";
    }
}

if ($type == "readFootGrade") {

    $id = filter_input(INPUT_GET, "id");
    //$employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    //$footGrade = mysql_real_escape_string(filter_input(INPUT_POST, "footGrade"));   
    $arr = array();
    $rs = mysql_query("SELECT id, footGrade FROM foot WHERE id = $id") or die("Error in query: $rs. " . mysql_error());

    while ($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updateFootGrade") {
    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $footGrade = mysql_real_escape_string(filter_input(INPUT_POST, "footGrade"));


    $rs = mysql_query("UPDATE foot SET "
            . "footGrade = $footGrade "
            . "WHERE id = $employeeId") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "readFootSlit") {

    $id = filter_input(INPUT_GET, "id");
    //$employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    //$footGrade = mysql_real_escape_string(filter_input(INPUT_POST, "footGrade"));   
    $arr = array();
    $rs = mysql_query("SELECT id, prasat, lostBlood, virus, other FROM foot WHERE id = $id") or die("Error in query: $rs. " . mysql_error());

    while ($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }

    echo "{\"data\":" . json_encode($arr) . "}";
}

if ($type == "updateFootSlit") {
    $employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    $prasat = mysql_real_escape_string(filter_input(INPUT_POST, "prasat"));
    $lostBlood = mysql_real_escape_string(filter_input(INPUT_POST, "lostBlood"));
    $virus = mysql_real_escape_string(filter_input(INPUT_POST, "virus"));
    $other = mysql_real_escape_string(filter_input(INPUT_POST, "other"));


    $rs = mysql_query("UPDATE foot SET "
            . "prasat = '$prasat' ,"
            . "lostBlood = '$lostBlood',"
            . "virus = '$virus',"
            . "other = '$other'"
            . "WHERE id = $employeeId") or die("Error in query: $rs. " . mysql_error());

    if ($rs) {
        echo json_encode($rs);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}

if ($type == "readFootConclude") {

    $id = filter_input(INPUT_GET, "id");
    //$employeeId = mysql_real_escape_string(filter_input(INPUT_POST, "id"));
    //$footGrade = mysql_real_escape_string(filter_input(INPUT_POST, "footGrade"));   
    $arr = array();
    $rs = mysql_query("SELECT id, risk, footGrade, prasat, lostBlood, virus "
            . "FROM foot WHERE id = $id") or die("Error in query: $rs. " . mysql_error());

    while ($obj = mysql_fetch_object($rs)) {
        $arr[] = $obj;
    }

    echo "{\"data\":" . json_encode($arr) . "}";
}
?>