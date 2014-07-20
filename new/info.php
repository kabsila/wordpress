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
        <script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>        
        <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

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
            <div id="footDate" style="width: 50%; margin-bottom: 25px;"></div>
            <div id="footInfo" class="k-block"></div>
            <div class="footImage-section">
                <div id="footImageBox" class="k-block" style="padding: 10px 25px 25px 25px;">                    
                    <div class="k-header k-shadow" style="margin-bottom: 25px;"><strong>ภาพถ่ายเท้าทั้ง 2 ข้างในวันที่ทำการประเมิน</strong></div>
                    <div id="footImage"></div>
                    <div id="uploadFoot" style="padding-top: 25px;">upload image</div> 
                </div>
                <div id="pager"></div>            
                <div id="footResult" style="padding-top: 25px;">
                    <div class="k-header k-shadow k-block"><strong>ระดับความเสี่ยงของการเกิดแผลที่เท้า</strong></div> 
                    <div id="footRisk" class="k-block"></div>
                </div>
                <div id="footGrade" style="padding-top: 25px; padding-bottom: 25px;"></div> 
                <div id="footSlit" style="padding-bottom: 25px;"></div> 
            </div>
            <div id="footConclude-section" class="k-block" style="padding-bottom: 25px;margin-bottom: 25px;">
                <div class="k-header k-shadow"><strong>สรุปผลการตรวจเท้าในผู้ป่วยรายนี้</strong></div>
                <div id="footImageConclude"></div>
                <div id="footConclude"></div>
            </div>

        </div>


    </center>

    <script>

        templateLoader.loadExtTemplate("infoTemplate/_baseInfo.tmpl.htm");


        $("#uploadFoot").uploadFile({
            url: "get_db/getFoot_db.php?type=save&footID=<?php echo $id; ?>",
            multiple: true,
            fileName: "myfile",
            method: "POST",
            onSuccess: function(files, data, xhr)
            {
                dataSourceFootImage.read();

            }
        });

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
                    url: "get_db/getFoot_db.php?type=updateFoot",
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
                    url: "get_db/getFoot_db.php?type=readFootImage",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                destroy: {
                    url: "get_db/getFoot_db.php?type=destroyFootImage",
                    dataType: "json",
                    type: "POST"
                }
            },
            schema: {
                //data: "data",
                model: {
                    id: "id",
                    fields: {
                        imageID: {type: "number"}
                    }
                }
            },
            pageSize: 2,
            error: function(e) {
                alert(e);
            }

        });
        var dataSourceFootGrade = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=readFootGrade",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getFoot_db.php?type=updateFootGrade",
                    dataType: "json",
                    type: "POST"
                }
            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        footGrade: {type: "number"}
                    }
                }
            },            
            error: function(e) {
                alert(e);
            }

        });
        var dataSourceFootSlit = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=readFootSlit",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getFoot_db.php?type=updateFootSlit",
                    dataType: "json",
                    type: "POST"
                }
            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        prasat: {type: "boolean"},
                        lostBlood: {type: "boolean"},
                        virus: {type: "boolean"}
                    }
                }
            },            
            error: function(e) {
                alert(e);
            }

        });
        var dataSourceFootConclude = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=readFootConclude",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                }                
            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        prasat: {type: "boolean"},
                        lostBlood: {type: "boolean"},
                        virus: {type: "boolean"},
                        footGrade: {type: "number"}
                    }
                }
            },            
            error: function(e) {
                alert(e);
            }

        });
        var dataSourceFootConcludeImage = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getFoot_db.php?type=readFootImage",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                }
            },
            schema: {
               // data: "data",
                model: {
                    id: "id",
                    fields: {
                        imageID: {type: "number"}
                    }
                }
            },            
            error: function(e) {
                alert(e);
            }

        });

        templateLoader.loadExtTemplate("infoTemplate/_foot.tmpl.html");

        $(document).on("TEMPLATE_LOADED", function() {

            $("#pager").kendoPager({
                dataSource: dataSourceFootImage,
                previousNext: false,
                pageSize: true

                        //buttonCount: 0
            });


            $("#footInfo").kendoListView({
                template: kendo.template($("#footTemplate").html()),
                editTemplate: kendo.template($("#editFootTemplate").html()),
                dataSource: dataSourceFoot,
                edit: function(e) {
                    var dataItem = dataSourceFoot.at(0);
                    if (dataItem.FBS > 200) {
                        $('#FBS').prop('checked', true);
                    }
                    if (dataItem.HbA1C > 7) {
                        $('#HbA1C').prop('checked', true);
                    }
                    if (dataItem.age > 60) {
                        $('#age').prop('checked', true);
                    }
                    if (dataItem.status === 'nay') {
                        $('#status').prop('checked', true);
                    }
                    if (dataItem.smoke !== "cancelSmoke") {
                        $('#smoke').prop('checked', true);
                    }
                },
                save: function(e) {
                    footRiskFunction();
                    $("#footConclude").data("kendoListView").dataSourceFoot.read();
                    $("#footConclude").data("kendoListView").refresh();

                }
            });
            $("#footImage").kendoListView({
                dataSource: dataSourceFootImage,
                pageable: true,
                //navigatable: true,
                //editable: true,
                template: kendo.template($("#footImageTemplate").html()),
                editTemplate: kendo.template($("#editFootImageTemplate").html()),
                edit: function(e) {

                }

            });
            $("#footGrade").kendoListView({
                dataSource: dataSourceFootGrade,               
                editable: true,
                template: kendo.template($("#footGradeTemplate").html()),
                editTemplate: kendo.template($("#editFootGradeTemplate").html()),
                edit: function(e) {

                }

            });
            $("#footSlit").kendoListView({
                dataSource: dataSourceFootSlit,               
                editable: true,
                template: kendo.template($("#footSlitTemplate").html()),
                editTemplate: kendo.template($("#editFootSlitTemplate").html()),
                edit: function(e) {

                }

            });
            $("#footConclude").kendoListView({
                dataSource: dataSourceFootConclude,             
                template: kendo.template($("#footConcludeTemplate").html())               

            });
            $("#footImageConclude").kendoListView({
                dataSource: dataSourceFootConcludeImage,
               // pageable: true,
                //navigatable: true,
                //editable: true,
                template: kendo.template($("#footConcludeImageTemplate").html()),                
                edit: function(e) {

                }

            });

            $(".fancybox").fancybox({
                openEffect: 'elastic',
                closeEffect: 'elastic',
                //fitToView: true,
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });

        });
        $(function() {
            footRiskFunction();

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

        function footRiskFunction() {
            dataSourceFoot.fetch(function() {
                var dataItem = dataSourceFoot.at(0);
                if (!dataItem.foot1 && !dataItem.foot5 && !dataItem.foot6 && !dataItem.foot7 && !dataItem.foot8 && !dataItem.foot9) {
                    $("#footRisk").html("มีความเสี่ยงต่ำ");                   
                }else if (!dataItem.foot1 || !dataItem.foot5 || (dataItem.foot6 && dataItem.foot7) || dataItem.foot9 || dataItem.foot8) {
                    $("#footRisk").html("มีความเสี่ยงปานกลาง");
                } else if (dataItem.foot1 || dataItem.foot5 || (dataItem.foot6 && dataItem.foot7 && dataItem.foot8) || dataItem.foot9) {
                    $("#footRisk").html("มีความเสี่ยงสูง");
                } 
            });
        }

    </script>

</body>
</html>