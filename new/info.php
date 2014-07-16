<?php
include_once ( 'connectDB.php' );
require_once 'lib/Kendo/Autoload.php';
mysql_select_db("diabetes") or die("Unable To Connect To Northwind");
mysql_query("SET NAMES UTF8");
//$arr = array();
//$rs = mysql_query("SELECT ID, name, sname FROM general_info");
//while ($obj = mysql_fetch_object($rs)) {
//  $arr[] = $obj;
//}

$verb = filter_input(INPUT_SERVER, "REQUEST_METHOD");
$id = filter_input(INPUT_GET, "id");
//$verb = $_SERVER["REQUEST_METHOD"];
//if ($verb == "GET") {
//echo $verb;
//  echo $id;
//}
// handle a POST  
if ($verb == "POST") {
    echo $verb;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!-- Common Kendo UI Web CSS -->
        <link href="styles/kendo.common.min.css" rel="stylesheet" />
        <!-- Default Kendo UI Web theme CSS -->
        <link href="styles/kendo.default.min.css" rel="stylesheet" />

        <!-- jQuery JavaScript -->
        <script src="js/jquery.min.js"></script>
        <!-- Kendo UI Web combined JavaScript -->
        <script src="js/kendo.web.min.js"></script>
        <script src="js/kendo.all.min.js"></script>
        <script src="js/cultures/kendo.culture.th-TH.min.js"></script>
        <script src="js/templateLoader.js"></script>
        
        <link href="css/index.css" rel="stylesheet" />
        <link href="css/info.css" rel="stylesheet" />
        <link href="css/uploadfile.min.css" rel="stylesheet" />
        <script src="js/jquery.uploadfile.min.js"></script>
        
       
        <style>
            html { height: 100%; width: 100%;}
            body { height: 100%; width: 100%;}        

        </style>


    </head>
    <body>



        <div id="container">
            <div id="content">
                <table id="table1" border="0" align="center">
                    <tr align="center">
                        <td><button class="bt-info" id="baseInfo" type="button">ข้อมูลพื้นฐาน</button></td>
                        <td><button class="bt-info" id="eye" type="button">ตา</button></td>
                        <td><button class="bt-info" id="tai" type="button">ไต</button></td>
                        <td><button class="bt-info" id="social" type="button">ด้านจิตสังคม</button></td>
                    </tr>
                    <tr align="center">
                        <td><button class="bt-info" id="sugar" type="button">การควบคุมระดับน้ำตาล</button></td>
                        <td><button class="bt-info" id="blood" type="button">หัวใจและหลอดเลือด</button></td>
                        <td><button class="bt-info" id="foot" type="button">เท้า</button></td>
                        <td><button class="bt-info" id="process" type="button">ประมวลผล</button></td>
                    </tr>
                </table>              
            </div>


        </div>

        <!-- <div id="listView"></div-->
    <center><div id="baseInfoContainer" style="display: none;"></div></center>
    <center>
        <div id="footContainer">
            <div id="footDate" style="width: 50%;"></div>
            <div id="footInfo"></div>
            <div class="k-header">
                <div id="footImage">upload</div>                   
            </div>
            
        </div>
    </center>

    <script>

        templateLoader.loadExtTemplate("infoTemplate/_baseInfo.tmpl.htm");

     //   $(document).ready(function()
    // {
            $("#footImage").uploadFile({
                url: "get_db/getFoot_db.php?type=save&footID=<?php echo $id; ?>",
                multiple: true,
                fileName: "myfile",
                method: "POST"
            });            
            
       // });

        $("#baseInfo").kendoButton({
            click: function(e) {
                $("#baseInfoContainer").slideToggle(1000);
            }
        });
        $("#foot").kendoButton({
            click: function(e) {
                $("#baseInfoContainer").slideToggle(1000);
            }
        });

        var dataSourceDb = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getInfo_db.php",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getInfo_db.php",
                    type: "POST"
                }
            },
            error: function(e) {
                alert(e);
            },
            schema: {
                data: "data",
                model: {
                    id: "ID",
                    fields: {
                        name: "name",
                        sname: "sname",
                        age: "age",
                        name_d: "name_d",
                        relation: "relation",
                        h_blood: {type: "boolean"},
                        tai_y: {type: "boolean"},
                        h_fail: {type: "boolean"},
                        hi_fat: {type: "boolean"},
                        h_lost_blood: {type: "boolean"},
                        h_big: {type: "boolean"},
                        cabg: {type: "boolean"},
                        brain_blood: {type: "boolean"},
                        whenCancelSmoke: {type: "date"}

                    }
                }

            }

        });



        $(document).on("TEMPLATE_LOADED", function() {
            $("#baseInfoContainer").kendoListView({
                template: kendo.template($("#baseInfoTemplate").html()),
                editTemplate: kendo.template($("#editBaseInfoTemplate").html()),
                dataSource: dataSourceDb,
                edit: function(e) {
                    $("#datePicker").kendoDatePicker({
                        format: "dd MMM yyyy",
                        parseFormats: ["yyyy/MM/dd"],
                        culture: "th-TH",
                        animation: {
                            close: {
                                effects: "fadeOut zoom:out",
                                duration: 300
                            },
                            open: {
                                effects: "fadeIn zoom:in",
                                duration: 300
                            }
                        }

                    });
                    // var datepicker = $("#datePicker").data("kendoDatePicker");
                    //datepicker.enable(false);

                    $('input:radio[name="smoke"]').change(
                            function() {
                                if ($(this).val() === 'cancelSmoke') {
                                    // datepicker.enable(true);
                                }
                                else {
                                    // datepicker.enable(false);
                                    //$("#datePicker").val('');
                                }
                            });
                }

            });
        });

    </script>
    <script>
        templateLoader.loadExtTemplate("infoTemplate/_foot.tmpl.html");




        var dataSourceFootDate = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=read",
                    dataType: "json",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getFoot_db.php?type=update",
                    dataType: "json",
                    type: "POST"
                },
                create: {
                    url: "get_db/getFoot_db.php?type=create&footID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function(e) {
                        $("#footDate").data("kendoGrid").dataSource.read();
                    }

                },
                destroy: {
                    url: "get_db/getFoot_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }

            },
            error: function(e) {
                alert(e.status);
            },
            //autoSync: true,
            schema: {
                data: "dataFootDate",
                model: {
                    id: "id",
                    fields: {
                        id: {type: "number"},
                        dateFoot: {type: "date"},
                        number: {type: "number"}

                    }
                }
            }

        });
        var dataSourceFoot = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=read",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getFoot_db.php?type=update",
                    type: "POST"
                }
            },
            error: function(e) {
                alert(e);
            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        foot1: {type: "boolean"},
                        foot2: {type: "boolean"},
                        foot3: {type: "boolean"},
                        foot4: {type: "boolean"},
                        foot5: {type: "boolean"},
                        foot6: {type: "boolean"},
                        foot7: {type: "boolean"},
                        foot8: {type: "boolean"},
                        foot9: {type: "boolean"},
                        foot10: {type: "boolean"},
                        foot11: {type: "boolean"},
                        foot12: {type: "boolean"},
                        FBS: {type: "number"},
                        HbA1C: {type: "number"},
                        tai_y: {type: "boolean"},
                        age: {type: "number"}


                    }
                }

            }

        });
        var dataSourceFootImage = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getInfo_db.php?type=readFootImage",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                }
            },
            error: function(e) {
                alert(e);
            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        name: "name"

                    }
                }

            }

        });
        $(document).on("TEMPLATE_LOADED", function() {

            $("#footInfo").kendoListView({
                template: kendo.template($("#footTemplate").html()),
                editTemplate: kendo.template($("#editFootTemplate").html()),
                dataSource: dataSourceFoot
            });
            $("#footImage").kendoListView({
                template: kendo.template($("#footImageTemplate").html()),
                editTemplate: kendo.template($("#editFootImageTemplate").html()),
                dataSource: dataSourceFootImage,
                edit: function(e) {

                }

            });
        });
        $(function() {
            $("#footDate").kendoGrid({
                dataSource: dataSourceFootDate,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [{field: "dateFoot", title: "วันที่ตรวจ", format: "{0:dd/MM/yyyy}", width: 20},
                    {field: "resultFoot", title: "ผลการตรวจ", width: 20},
                    {command: ["edit", "destroy"], title: "&nbsp;", width: 20}],
                ///detailTemplate: kendo.template($("#template").html()),
                // detailInit: detailInit,
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid


            });
        });

    </script>

</body>
</html>