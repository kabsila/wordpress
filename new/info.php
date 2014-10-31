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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdvwF7XYm-l-CeqTLrwHQCjDbIxThB1As&sensor=false&libraries=places&language=th"></script>
        <style>
            html { height: 100%; width: 100%;}
            body { height: 100%; width: 100%;}        

        </style>
<script type="text/x-kendo-template" id="chart">    
    # var date = new Date(value);#
    # var mnth = ("0" + (date.getMonth()+1)).slice(-2);#
    # var day  = ("0" + date.getDate()).slice(-2);#
    # var datee = [day , mnth, date.getFullYear()].join("-");#
    #=datee#
</script>

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
    <center>
        <div class="k-header k-shadow" id="baseInfoContainer" style="display: none;">            
        </div>
    </center>
    <center>
        <div id="footContainer" style="display: none;">
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
            <div class="k-block"></div>
        </div>
        <div id="taiContainer" style="display: none;">
            <div id="taiDate" style="width: 50%; margin-bottom: 25px;"></div>
            <div id="taiInfo" style="width: 60%; margin-bottom: 25px;"></div>
        </div>
        <div id="eyeContainer" style="display: none;">
            <div id="eyeDate" style="width: 50%; margin-bottom: 25px;"></div>
            <div id="eyeInfo" style="width: 60%; margin-bottom: 25px;"></div>
        </div>
        <div id="bloodContainer" style="display: none;">            
            <div id="bloodInfo" style="width: 60%; margin-bottom: 25px;"></div>
        </div>
        <div id="sugarContainer" style="display: none;">            
            <div id="sugarInfo" style="width: 90%; margin-bottom: 25px;"></div>
        </div>
        <div id="socialContainer" style="display: none;">            
            <div id="socialInfo" style="width: 90%; margin-bottom: 25px;"></div>
        </div>
        <div id="processContainer" style="display: none;">            
            <div id="processInfo" style="width: 800px; margin-bottom: 25px;"></div>
            <div id="processSocial" style="width: 800px; margin-bottom: 25px;"></div>
        </div>
         <div id="planDContainer" style="display: block;">            
            <div id="trainDInfo" style="width: 90%; margin-bottom: 25px;"></div>
            <div id="planDInfo" style="width: 90%; margin-bottom: 25px;"></div>
            <div id="visitHomeInfo" style="width: 90%; margin-bottom: 25px;"></div>
        </div>


    </center>

    <script>
        var map;
        var markers = [];
        var geocoder;
        var marker;
        //initialize();
        function initialize()
        {
            var myCenter = new google.maps.LatLng(15.241127, 104.851402);
            google.maps.visualRefresh = true;
            geocoder = new google.maps.Geocoder();
            var mapProp = {
                center: myCenter,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            clearOverlays();
            markers = [];
            marker = new google.maps.Marker({
                position: location,
                animation: google.maps.Animation.DROP,
                map: map
            });
            markers.push(marker);
            geocoder.geocode({'latLng': location}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
                var infowindow = new google.maps.InfoWindow({
                    content: 'Latitude: ' + location.lat().toFixed(4) + '<br>Longitude: ' + location.lng().toFixed(4) + '<br>' + results[0].formatted_address

                });
                infowindow.open(map, marker);
            });

            //$("#Latitude").bind("change", function (){
            //alert("ddd");
            //});



            $("#Latitude").val(location.lat().toFixed(5).toString());
            $("#Longitude").val(location.lng().toFixed(5).toString());
            $("#Latitude").change();
            $("#Longitude").change();

            // $("#Latitude").val("qwer");
            // $("#Longitude").val(location.lng().toFixed(5).toString());


        }
        function setAllMap(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function clearOverlays() {
            setAllMap(null);
        }
    </script>
    <script>

        templateLoader.loadExtTemplate("infoTemplate/_baseInfo.tmpl.htm");

        $("#uploadFoot").uploadFile({
            url: "get_db/getFoot_db.php?type=save&footID=<?php echo $id; ?>",
            multiple: true,
            fileName: "myfile",
            method: "POST",
            onSuccess: function (files, data, xhr)
            {
                dataSourceFootImage.read();

            }
        });

        $("#baseInfo").kendoButton({
            click: function (e) {
                $("#baseInfoContainer").slideToggle(1000);
            }
        });
        $("#foot").kendoButton({
            click: function (e) {
                $("#footContainer").slideToggle(1000);
            }
        });
        $("#tai").kendoButton({
            click: function (e) {
                $("#taiContainer").slideToggle(1000);
            }
        });
        $("#blood").kendoButton({
            click: function (e) {
                $("#bloodContainer").slideToggle(1000);
            }
        });
        $("#eye").kendoButton({
            click: function (e) {
                $("#eyeContainer").slideToggle(1000);
            }
        });
        $("#sugar").kendoButton({
            click: function (e) {
                $("#sugarContainer").slideToggle(1000);
            }
        });
        $("#social").kendoButton({
            click: function (e) {
                $("#socialContainer").slideToggle(1000);
            }
        });
        $("#process").kendoButton({
            click: function (e) {                
                $("#processContainer").slideToggle(1000);               
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
            error: function (e) {
                alert(e);
            },
            schema: {
                data: "data",
                model: {
                    id: "ID",
                    fields: {
                        name: "name",
                        sname: "sname",
                        marriage: {type: "string"},
                        hn: "hn",
                        kum: "kum",
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
                        whenCancelSmoke: {type: "date"},
                        address_num: "address_num",
                        moo: "moo",
                        road: "road",
                        aumphor: "aumphor",
                        tumbol: "tumbol",
                        city: "city",
                        zipcode: "zipcode",
                        longitude: "longitude",
                        latitude: "latitude",
                        date_accp: {type: "date"}

                    }
                }

            }

        });
        var dataSourceYa = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getYa_db.php?type=read",
                    dataType: "json",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getYa_db.php?type=update",
                    dataType: "json",
                    type: "POST"
                },
                create: {
                    url: "get_db/getYa_db.php?type=create&yaID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $(".k-grid").data("kendoGrid").dataSource.read();
                    }

                },
                destroy: {
                    url: "get_db/getYa_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }

            },
            error: function (e) {
                alert(e.status);
            },
            //autoSync: true,
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        id: {type: "number"},
                        ya_order: {type: "number"},
                        ya_name: "ya_name",
                        ya_eat: "ya_eat"

                    }
                }
            }

        });
        var dataSourceListYa = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getListYa_db.php?type=read",
                    dataType: "json"
                }
            }
        });


        $(document).on("TEMPLATE_LOADED", function () {
            $("#baseInfoContainer").kendoListView({
                template: kendo.template($("#baseInfoTemplate").html()),
                editTemplate: kendo.template($("#editBaseInfoTemplate").html()),
                dataSource: dataSourceDb,
                dataBound: function () {
                    $(".k-grid", this.element).each(function () {
                        var dom = $(this);
                        dom.kendoGrid({
                            dataSource: dataSourceYa,
                            selectable: true,
                            // toolbar: [{name: "create", text: "เพิ่มรายชื่อยาที่ได้รับ"}],
                            columns: [
                                {
                                    field: "ya_name",
                                    title: "ชื่อยา",
                                    //template: "#= ya_name#",
                                    width: "500px"
                                },
                                {
                                    field: "ya_eat",
                                    title: "วิธีรับประทาน"
                                            //width: "100px"
                                }
                            ],
                            scrollable: false
                                    // editable: "popup",
                                    //navigable: true


                        });
                    });
                },
                edit: function (e) {
                    $(".datePicker").kendoDatePicker({
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
                            function () {
                                if ($(this).val() === 'cancelSmoke') {
                                    // datepicker.enable(true);
                                }
                                else {
                                    // datepicker.enable(false);
                                    //$("#datePicker").val('');
                                }
                            });

                    $(".k-grid", this.element).each(function () {
                        var dom = $(this);
                        dom.kendoGrid({
                            dataSource: dataSourceYa,
                            selectable: true,
                            toolbar: [{name: "create", text: "เพิ่มรายชื่อยาที่ได้รับ"}],
                            columns: [
                                {
                                    field: "ya_name",
                                    title: "ชื่อยา",
                                    editor: serviceItemAutoCompleteEditor,
                                    template: "#= ya_name#",
                                    width: 40
                                },
                                {
                                    field: "ya_eat",
                                    title: "วิธีรับประทาน",
                                    width: 10
                                },
                                {
                                    command: ["edit", "destroy"],
                                    title: "&nbsp;",
                                    width: 20
                                }
                            ],
                            editable: "popup",
                            navigable: true,
                            cancel: function(e) {
                                $(".k-grid").data("kendoGrid").dataSource.read();
                            },
                            sortable: {
                                mode: "single",
                                allowUnsort: false
                            }

                        });
                    });


                    initialize();

                    // $("#Latitude").val("qwer");
                    //$("#Longitude").val(location.lng().toFixed(5).toString());
                    //e.preventDefault();


                }

            });

        });

        function serviceItemAutoCompleteEditor(container, options) {
            $('<input  data-bind="value:' + options.field + '"/>')
                    .appendTo(container)
                    .kendoAutoComplete({
                        suggest: true,
                        dataTextField: "name_ya",
                        dataValueField: "name_ya",
                        placeholder: "Select an item",
                        minLength: 1,
                        dataSource: dataSourceListYa
                    }).data("kendoAutoComplete");
        }

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
                    complete: function (e) {
                        $("#footDate").data("kendoGrid").dataSource.read();
                    }

                },
                destroy: {
                    url: "get_db/getFoot_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }

            },
            error: function (e) {
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
            error: function (e) {
                alert(e);
            },
            change: function (e) {
                $("#footConclude").data("kendoListView").dataSource.read();
                $("#footConclude").data("kendoListView").refresh();
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
            error: function (e) {
                alert(e);
            },
            change: function (e) {
                //alert("sss");
                $("#footImageConclude").data("kendoListView").dataSource.read();
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
            error: function (e) {
                alert(e);
            },
            change: function (e) {
                $("#footConclude").data("kendoListView").dataSource.read();
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
            error: function (e) {
                alert(e);
            },
            change: function (e) {
                $("#footConclude").data("kendoListView").dataSource.read();
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
            error: function (e) {
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
            error: function (e) {
                alert(e);
            }

        });

        templateLoader.loadExtTemplate("infoTemplate/_foot.tmpl.html");

        $(document).on("TEMPLATE_LOADED", function () {

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
                edit: function (e) {
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
                save: function (e) {
                    footRiskFunction();


                }
            });
            $("#footImage").kendoListView({
                dataSource: dataSourceFootImage,
                pageable: true,
                //navigatable: true,
                //editable: true,
                template: kendo.template($("#footImageTemplate").html()),
                editTemplate: kendo.template($("#editFootImageTemplate").html()),
                edit: function (e) {

                }

            });
            $("#footGrade").kendoListView({
                dataSource: dataSourceFootGrade,
                editable: true,
                template: kendo.template($("#footGradeTemplate").html()),
                editTemplate: kendo.template($("#editFootGradeTemplate").html()),
                edit: function (e) {

                }

            });
            $("#footSlit").kendoListView({
                dataSource: dataSourceFootSlit,
                editable: true,
                template: kendo.template($("#footSlitTemplate").html()),
                editTemplate: kendo.template($("#editFootSlitTemplate").html()),
                edit: function (e) {

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
                edit: function (e) {

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
        $(function () {
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
                 cancel: function(e) {
                   $("#footDate").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });

        });

        function footRiskFunction() {
            dataSourceFoot.fetch(function () {
                var dataItem = dataSourceFoot.at(0);
                if (!dataItem.foot1 && !dataItem.foot5 && !dataItem.foot6 && !dataItem.foot7 && !dataItem.foot8 && !dataItem.foot9) {
                    $("#footRisk").html("มีความเสี่ยงต่ำ");
                } else if (!dataItem.foot1 || !dataItem.foot5 || (dataItem.foot6 && dataItem.foot7) || dataItem.foot9 || dataItem.foot8) {
                    $("#footRisk").html("มีความเสี่ยงปานกลาง");
                } else if (dataItem.foot1 || dataItem.foot5 || (dataItem.foot6 && dataItem.foot7 && dataItem.foot8) || dataItem.foot9) {
                    $("#footRisk").html("มีความเสี่ยงสูง");
                }
            });
        }

    </script>
    <script>

        var dataSourceTaiDate = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getTai_db.php?type=read",
                    dataType: "json",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getTai_db.php?type=update",
                    dataType: "json",
                    type: "POST"
                },
                create: {
                    url: "get_db/getTai_db.php?type=create&taiID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#taiDate").data("kendoGrid").dataSource.read();
                    }

                },
                destroy: {
                    url: "get_db/getTai_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }

            },
            error: function (e) {
                alert(e.status);
            },
            //autoSync: true,
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        id: {type: "number"},
                        dateTai: {type: "date"},
                        number: {type: "number"}

                    }
                }
            }

        });
        var dataSourceTai = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getTai_db.php?type=readTai",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getTai_db.php?type=updateTai",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        urine: {type: "boolean"},
                        creatine: {type: "number"},
                        age: {type: "number"}
                    }
                }

            }

        });

        templateLoader.loadExtTemplate("infoTemplate/_tai.tmpl.html");

        $(document).on("TEMPLATE_LOADED", function () {

            $("#taiInfo").kendoListView({
                template: kendo.template($("#taiTemplate").html()),
                editTemplate: kendo.template($("#editTaiTemplate").html()),
                dataSource: dataSourceTai,
                edit: function (e) {

                },
                save: function (e) {
                    var gfr;
                    var level;
                    dataSourceTai.fetch(function () {
                        var dataItem = dataSourceTai.at(0);
                        if (dataItem.status === 'nang' && dataItem.creatine <= 0.7) {
                            gfr = 144 * Math.pow((kendo.parseFloat(dataItem.creatine) / 0.7), -0.329) * Math.pow(0.993, dataItem.age);
                        } else if (dataItem.status === 'nang' && dataItem.creatine > 0.7) {
                            gfr = 144 * Math.pow((kendo.parseFloat(dataItem.creatine) / 0.7), -1.209) * Math.pow(0.993, dataItem.age);
                        } else if (dataItem.status !== 'nang' && dataItem.creatine <= 0.9) {
                            gfr = 141 * Math.pow((kendo.parseFloat(dataItem.creatine) / 0.7), -0.411) * Math.pow(0.993, dataItem.age);
                        } else if (dataItem.status !== 'nang' && dataItem.creatine > 0.9) {
                            gfr = 141 * Math.pow((kendo.parseFloat(dataItem.creatine) / 0.7), -1.209) * Math.pow(0.993, dataItem.age);
                        }

                        if (gfr > 90) {
                            level = 1;
                        } else if (gfr >= 60 && gfr <= 89) {
                            level = 2;
                        } else if (gfr >= 30 && gfr <= 59) {
                            level = 3;
                        } else if (gfr >= 15 && gfr <= 29) {
                            level = 4;
                        } else if (gfr < 15) {
                            level = 5;
                        }
                        dataItem.set("gfr", gfr);
                        dataItem.set("result", level);
                        dataSourceTai.sync();

                    });

                    dataSourceTai.read();

                }
            });
        });

        $(function () {

            $("#taiDate").kendoGrid({
                dataSource: dataSourceTaiDate,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [{field: "dateTai", title: "วันที่ตรวจ", format: "{0:dd/MM/yyyy}", width: 20},
                    {field: "resultTai", title: "ผลการตรวจ", width: 20},
                    {command: ["edit", "destroy"], title: "&nbsp;", width: 20}],
                ///detailTemplate: kendo.template($("#template").html()),
                // detailInit: detailInit,
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                 cancel: function(e) {
                   $("#taiDate").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });

        });
    </script>
    <script>
        var dataSourceEyeDate = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getEye_db.php?type=read",
                    dataType: "json",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getEye_db.php?type=update",
                    dataType: "json",
                    type: "POST"
                },
                create: {
                    url: "get_db/getEye_db.php?type=create&eyeID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#eyeDate").data("kendoGrid").dataSource.read();
                    }

                },
                destroy: {
                    url: "get_db/getEye_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }

            },
            error: function (e) {
                alert(e.status);
            },
            //autoSync: true,
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        id: {type: "number"},
                        dateEye: {type: "date"},
                        number: {type: "number"}

                    }
                }
            }

        });
        var dataSourceEye = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getEye_db.php?type=readEye",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getEye_db.php?type=updateEye",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                    }
                }

            }

        });

        templateLoader.loadExtTemplate("infoTemplate/_eye.tmpl.html");
        $(document).on("TEMPLATE_LOADED", function () {

            $("#eyeInfo").kendoListView({
                template: kendo.template($("#eyeTemplate").html()),
                editTemplate: kendo.template($("#editEyeTemplate").html()),
                dataSource: dataSourceEye,
                edit: function (e) {
                    $("#eyeDatePicker").kendoDatePicker({
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
                },
                save: function (e) {

                }
            });
        });

        $(function () {

            $("#eyeDate").kendoGrid({
                dataSource: dataSourceEyeDate,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [{field: "dateEye", title: "วันที่ตรวจ", format: "{0:dd/MM/yyyy}", width: 20},
                    {field: "resultEye", title: "ผลการตรวจ", width: 20},
                    {command: ["edit", "destroy"], title: "&nbsp;", width: 20}],
                ///detailTemplate: kendo.template($("#template").html()),
                // detailInit: detailInit,
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                 cancel: function(e) {
                   $("#eyeDate").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });

        });
    </script>
    <script>
        var dataSourceBlood = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getBlood_db.php?type=readBlood",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getBlood_db.php?type=updateBlood",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        risk1: {type: "boolean"},
                        risk2: {type: "boolean"},
                        risk3: {type: "boolean"}
                    }
                }

            }

        });

        templateLoader.loadExtTemplate("infoTemplate/_blood.tmpl.html");
        $(document).on("TEMPLATE_LOADED", function () {

            $("#bloodInfo").kendoListView({
                template: kendo.template($("#bloodTemplate").html()),
                editTemplate: kendo.template($("#editBloodTemplate").html()),
                dataSource: dataSourceBlood,
                edit: function (e) {

                },
                save: function (e) {

                }
            });
        });
    </script>

    <script>
        var dataSourceSugar = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getSugar_db.php?type=readSugar",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getSugar_db.php?type=updateSugar",
                    type: "POST"
                },
                create: {
                    url: "get_db/getSugar_db.php?type=create&sugarID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#sugarInfo").data("kendoGrid").dataSource.read();
                    }
                },
                destroy: {
                    url: "get_db/getSugar_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        date: {type: "date"},
                        fbs: "FBS",
                        ldl: "LDL",
                        hdl: "HDL",
                        chol: "cholesterol",
                        tg: {type: "string"},
                        cre: "creatinine",
                        bun: "BUN",
                        hba1c: "HbA1C"
                    }
                }

            }

        });

        // templateLoader.loadExtTemplate("infoTemplate/_sugar.tmpl.html");
        // $(document).on("TEMPLATE_LOADED", function () {

        $(function () {
            $("#sugarInfo").kendoGrid({
                dataSource: dataSourceSugar,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [
                    {
                        field: "date",
                        title: "วันที่",
                        format: "{0:dd/MM/yyyy}",
                        width: 12
                    },
                    {
                        field: "fbs",
                        title: "FBS",
                        width: 9
                    },
                    {
                        field: "ldl",
                        title: "LDL",
                        width: 9
                    },
                    {
                        field: "hdl",
                        title: "HDL",
                        width: 9
                    },
                    {
                        field: "chol",
                        title: "cholesterol",
                        width: 13
                    },
                    {
                        field: "tg",
                        title: "tg",
                        width: 9
                    },
                    {
                        field: "cre",
                        title: "creatinine",
                        width: 9
                    },
                    {
                        field: "bun",
                        title: "BUN",
                        width: 9
                    },
                    {
                        field: "hba1c",
                        title: "HbA1c",
                        width: 9
                    },
                    {
                        command: ["edit", "destroy"],
                        title: "&nbsp;",
                        width: 20
                    }
                ],
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                 cancel: function(e) {
                   $("#sugarInfo").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });

        });
        //});
    </script>

    <script>
        var dataSourceSocial = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getSocial_db.php?type=readSocial",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getSocial_db.php?type=updateSocial",
                    type: "POST"
                },
                create: {
                    url: "get_db/getSocial_db.php?type=create&socialID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#socialInfo").data("kendoGrid").dataSource.read();
                    }
                },
                destroy: {
                    url: "get_db/getSocial_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        date: {type: "date"},
                        ADL: {type: "string"},
                        QOL: {type: "string"},
                        Psycho: {type: "string"},
                        other: {type: "string"}

                    }
                }

            }

        });

        //  templateLoader.loadExtTemplate("infoTemplate/_social.tmpl.html");
        //  $(document).on("TEMPLATE_LOADED", function () {

        $(function () {

            $("#socialInfo").kendoGrid({
                dataSource: dataSourceSocial,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [
                    {
                        field: "date",
                        title: "วันที่",
                        format: "{0:dd/MM/yyyy}",
                        width: 20
                    },
                    {
                        field: "ADL",
                        title: "ADL",
                        editor: riskDropDownEditor,
                        template: "#var ad;if(ADL == 2){ad = 'ความเสี่ยงปานกลาง';}else if(ADL == 1){ad = 'ความเสี่ยงต่ำ';}else if(ADL == 3){ad = 'ความเสี่ยงสูง';}else if(ADL == 4){ad = 'เกิดโรค';}##=ad#",
                        width: 20
                    },
                    {
                        field: "Psycho",
                        title: "Psycho",
                        editor: riskDropDownEditor,
                        template: "#var ad;if(Psycho == 2){ad = 'ความเสี่ยงปานกลาง';}else if(Psycho == 1){ad = 'ความเสี่ยงต่ำ';}else if(Psycho == 3){ad = 'ความเสี่ยงสูง';}else if(Psycho == 4){ad = 'เกิดโรค';}##=ad#",
                        width: 20
                    },
                    {
                        field: "QOL",
                        title: "QOL",
                        editor: riskDropDownEditor,
                        template: "#var ad;if(QOL == 2){ad = 'ความเสี่ยงปานกลาง';}else if(QOL == 1){ad = 'ความเสี่ยงต่ำ';}else if(QOL == 3){ad = 'ความเสี่ยงสูง';}else if(QOL == 4){ad = 'เกิดโรค';}##=ad#",
                        width: 20
                    },
                    {
                        field: "other",
                        title: "อื่น ๆ",
                        width: 20
                    },
                    {
                        command: ["edit", "destroy"],
                        title: "&nbsp;",
                        width: 30
                    }
                ],
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                 cancel: function(e) {
                   $("#socialInfo").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });

        });

        function riskDropDownEditor(container, options) {
            $('<input required data-text-field="riskLevel" data-value-field="id" data-bind="value:' + options.field + '"/>')
                    .appendTo(container)
                    .kendoDropDownList({
                        autoBind: false,
                        dataSource: {
                            data: [
                                {id: 0, riskLevel: ""},
                                {id: 1, riskLevel: "ความเสี่ยงต่ำ"},
                                {id: 2, riskLevel: "ความเสี่ยงปานกลาง"},
                                {id: 3, riskLevel: "ความเสี่ยงสูง"},
                                {id: 4, riskLevel: "เกิดโรค"}
                            ]
                        }
                    });
        }
        // });
    </script>
    <script>

        var dataSourceChart = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getChart_db.php?type=readSugar&id=<?php echo $id; ?>"
                }
            }
        });
        
         var dataSourceChartSocial = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getChart_db.php?type=readSocial&id=<?php echo $id; ?>"
                }
            }
        });
        
        $("#processInfo").kendoChart({
            categoryAxis: {
                field: "date",
                labels: {
                    template: kendo.template($("#chart").html())
                }
            },
            dataSource: dataSourceChart,
            series: [
                {name: "FBS", type: "line", field: "FBS", color: "red"},
                {name: "LDL", type: "line", field: "LDL", color: "green"},
                {name: "HDL", type: "line", field: "HDL", color: "blue"},
                {name: "cholesterol", type: "line", field: "cholesterol", color: "LightSeaGreen"},
                {name: "tg", type: "line", field: "tg", color: "yellow"},
                {name: "creatinine", type: "line", field: "creatinine", color: "Chocolate"},
                {name: "BUN", type: "line", field: "BUN", color: "DarkMagenta"},
                {name: "HbA1C", type: "line", field: "HbA1C", color: "HotPink"}
            ],
            tooltip: {
                visible: true,
                shared: false,
                format: "N0"
            },
            legend: {
                position: "top"
            },
            title: {
                text: "ผลการตรวจ"
            }            
        });

        $("#processSocial").kendoChart({
            categoryAxis: {
                field: "date",
                labels: {
                    template: kendo.template($("#chart").html())
                }
            },
            dataSource: dataSourceChartSocial,
            series: [
                {name: "ADL", type: "line", field: "ADL", color: "red"},
                {name: "Psycho", type: "line", field: "Psycho", color: "green"},
                {name: "QOL", type: "line", field: "QOL", color: "blue"}
                
            ],
            tooltip: {
                visible: true,
                shared: false,
                color: 'white',
                //format: "N0",
                template: "#var tp;if(value === '1'){tp = 'ความเสี่ยงต่ำ'}else if(value === '2'){tp = 'ความเสี่ยงปานกลาง'}else if(value === '3'){tp = 'ความเสี่ยงสูง'}else if(value === '4'){tp = 'เกิดโรค'}##=tp#"
            },
            legend: {
                position: "top"
            },
            title: {
                text: "สภาวะด้านจิตสังคม"
            },
            valueAxis: {
                min: 1,
                max: 4,
                majorUnit: 1,
                labels: {
                    template: "#var tp;if(value == 1){tp = 'ความเสี่ยงต่ำ'}else if(value == 2){tp = 'ความเสี่ยงปานกลาง'}else if(value == 3){tp = 'ความเสี่ยงสูง'}else if(value == 4){tp = 'เกิดโรค'}##=tp#"
                }
            }
            
        });

        //dataSourceChart.read();

    </script>
    
    <script>
        var dataSourceTrainD = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getPlanD_db.php?type=readTrainD",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getPlanD_db.php?type=updateTrainD",
                    type: "POST"
                },
                create: {
                    url: "get_db/getPlanD_db.php?type=createTrainD&trainDID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#trainDInfo").data("kendoGrid").dataSource.read();
                    }
                },
                destroy: {
                    url: "get_db/getPlanD_db.php?type=destroyTrainD",
                    dataType: "json",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        date: {type: "date"},
                        main_d: {type: "string"},
                        trainer_name: {type: "string"}                       

                    }
                }

            }

        });
        var dataSourcePlanD = new kendo.data.DataSource({
            batch: true,
            transport: {
                read: {
                    url: "get_db/getPlanD_db.php?type=readPlanD",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                create: {
                    url: "get_db/getPlanD_db.php?type=createPlanD&planDID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#planDInfo").data("kendoGrid").dataSource.read();
                    }
                },
                update: {
                    url: "get_db/getPlanD_db.php?type=updatePlanD",                    
                    type: "POST"                     
                },
                
                destroy: {
                    url: "get_db/getPlanD_db.php?type=destroyPlanD",
                    dataType: "json",
                    type: "POST"
                }
            },           
            
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        main_takecare: {type: "string"},
                        takecare: {type: "string"},
                        name_d: {type: "string"},
                        note: {type: "string"}  

                    }
                }

            }

        });
        
        //dataSourcePlanD.sync();
        
        $(function () {

            $("#trainDInfo").kendoGrid({
                dataSource: dataSourceTrainD,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [
                    {
                        field: "date",
                        title: "วันที่",
                        format: "{0:dd/MM/yyyy}",
                        width: 10
                    },
                    {
                        field: "main_d",
                        title: "ประเด็นที่ดูแล",                        
                        width: 20
                    },
                    {
                        field: "trainer_name",
                        title: "ชื่อผู้ดูแล",
                        width: 20
                    },
                    
                    {
                        command: ["edit", "destroy"],
                        title: "&nbsp;",
                        width: 10
                    }
                ],
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                cancel: function(e) {
                   $("#trainDInfo").data("kendoGrid").dataSource.read();
                },
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });
            
            $("#planDInfo").kendoGrid({
                dataSource: dataSourcePlanD,
               // selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [
                    {
                        field: "main_takecare",
                        title: "ประเด็นที่ดูแล",                        
                        width: 20
                    },
                    {
                        field: "takecare",
                        title: "แนวทางการดูแล",                        
                        width: 20
                    },
                    {
                        field: "name_d",
                        title: "ผู้ทีดูแล",
                        width: 20
                    },
                    {
                        field: "note",
                        title: "หมายเหตุ",
                        width: 20
                    },
                    
                    {
                        command: ["edit", "destroy"],
                        title: "&nbsp;",
                        width: 18
                    }
                ],
                editable: "popup", //"inline",
                cancel: function(e) {
                   $("#planDInfo").data("kendoGrid").dataSource.read();
                },
                navigable: true,
                batch: true
                
            });

        });
        
        
    </script>
    
    <script>
        var dataSourceVisitHome = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "get_db/getVisitHome_db.php?type=read",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "get_db/getVisitHome_db.php?type=update",
                    type: "POST"
                },
                create: {
                    url: "get_db/getVisitHome_db.php?type=create&VisitHomeID=<?php echo $id; ?>",
                    dataType: "json",
                    type: "PUT",
                    complete: function (e) {
                        $("#trainDInfo").data("kendoGrid").dataSource.read();
                    }
                },
                destroy: {
                    url: "get_db/getVisitHome_db.php?type=destroy",
                    dataType: "json",
                    type: "POST"
                }
            },
            error: function (e) {
                alert(e);
            },
            change: function (e) {

            },
            schema: {
                data: "data",
                model: {
                    id: "id",
                    fields: {
                        n: {type: "string"},
                        osm: {type: "string"},
                        staff: {type: "string"},
                        rub_type: {type: "string"},
                        family_envi: {type: "string"},
                        visit_order: {type: "string"}

                    }
                }

            }

        });
        
        $(function () {

            $("#visitHomeInfo").kendoGrid({
                dataSource: dataSourceVisitHome,
                selectable: true,
                toolbar: [{name: "create", text: "เพิ่มผลการตรวจ"}],
                columns: [
                    {
                        field: "visit_order",
                        title: "การเยี่ยมครั้งที่",                        
                        width: 10
                    },
                    {
                                title: "ผู้เยี่ยม",
                                columns: [ 
                                {
                                    field: "n",
                                    title: "พยาบาล"
                                    //width: 20
                                },
                                {
                                    field: "osm",
                                    title: "อสม."
                                    //width: 20
                                },
                                {
                                    field: "staff",
                                    title: "เจ้าหน้าที่"
                                    //width: 20
                                }
                                ]
                    },
                    {
                        field: "rub_type",
                        title: "บุคคลที่ได้รับการเยี่ยม",
                        width: 20
                    },
                    
                    {
                        command: ["edit", "destroy"],
                        title: "&nbsp;",
                        width: 10
                    }
                ],
                editable: "popup", //"inline",
                navigable: true,
                batch: true,
                cancel: function(e) {
                   $("#trainDInfo").data("kendoGrid").dataSource.read();
                },
                resizable: true,
                sortable: {
                    mode: "single",
                    allowUnsort: false
                }// enables keyboard navigation in the grid
            });
            
            

        });
    </script>
</body>
</html>