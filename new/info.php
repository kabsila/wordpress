<?php
include_once ( 'connectDB.php' );

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

if ($verb == "GET") {
    echo $verb;
    echo $id;
}

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

        <link href="css/index.css" rel="stylesheet" />
        <link href="css/info.css" rel="stylesheet" />
        <style>
            html { height: 100%; width: 100%;}
            body { height: 100%; width: 100%;}        

        </style>


    </head>
    <body>

        <script type="text/x-kendo-tmpl" id="template">
            <div>
            <div class="actionButton">
            <a class="k-button k-edit-button" href="\\#"><span class="k-icon k-edit"></span><span>แก้ไข</span></a>
            <!--<a class="k-button k-delete-button" href="\\#"><span class="k-icon k-delete"></span></a>-->
            </div>
            <table id="baseInfoTable" border="1" align="center">
            <tr align="center">
            <td><strong>ชื่อ</strong></td>
            <td><strong>นามสกุล</strong></td>
            <td><strong>อายุ</strong></td>
            <td><strong>สถานภาพสมรส</strong></td>                       
            </tr>    
            <tr align="center">
            <td>#:name#</td>
            <td>#:sname#</td>
            <td>#:age#</td>
            <td>#:#</td>
            </tr>
            <tr>
            <td colspan="4"></td>
            </tr>
            <tr align="center">
            <td><strong>จำนวนสมาชิกในครอบครัว</strong></td>
            <td><strong>จำนวนผู้ดูแล</strong></td>
            <td><strong>ผู้ดูแลหลัก</strong></td>
            <td><strong>สัมพัธภาพในครอบครัว</strong></td>                       
            </tr>
            <tr align="center">
            <td>#:number_f#</td>
            <td>#:number_d#</td>
            <td>#:name_d#</td>
            <td>#:relation#</td>
            </tr>
            <tr>
            <td colspan="4"></td>
            </tr>
            <tr align="center">
            <td colspan="2"><strong>การสูบบุหรี่</strong></td>
            <td colspan="2"><strong>โรคร่วม</strong></td>                                   
            </tr>
            <tr align="center">
            <td colspan="2">#:smoke#</td>
            <td colspan="2">
            <pre>#:h_blood#</pre>
            <pre>#:tai_y#</pre>
            <pre>#:h_fail#</pre>
            <pre>#:hi_fat#</pre>
            <pre>#:h_lost_blood#</pre>
            <pre>#:h_big#</pre>
            <pre>#:cabg#</pre>
            <pre>#:brain_blood#</pre>
            </td>            
            </tr>
            </table>

            </div>
        </script>

        <script type="text/x-kendo-tmpl" id="editTemplate">
            <div>
            <div class="actionButton">
            <a class="k-button k-update-button" href="\\#"><span class="k-icon k-update"></span>บันทึก</a>
            <a class="k-button k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span>ยกเลิก</a>
            </div>
            <table id="baseInfoTable" border="1" align="center">
            <tr align="center">
            <td><strong>ชื่อ</strong></td>
            <td><strong>นามสกุล</strong></td>
            <td><strong>อายุ</strong></td>
            <td><strong>สถานภาพสมรส</strong></td>                       
            </tr>    
            <tr align="center">
            <td><input type="text" class="k-textbox" data-bind="value:name" name="name"/></td>
            <td><input type="text" class="k-textbox" data-bind="value:sname" name="sname"/></td>
            <td><input type="text" class="k-textbox" data-bind="value:age" name="age"/></td>
            <td><input type="text" class="k-textbox" data-bind="value:somros" name="somros"/></td>
            </tr>
            <tr>
            <td colspan="4"></td>
            </tr>
            <tr align="center">
            <td><strong>จำนวนสมาชิกในครอบครัว</strong></td>
            <td><strong>จำนวนผู้ดูแล</strong></td>
            <td><strong>ผู้ดูแลหลัก</strong></td>
            <td><strong>สัมพัธภาพในครอบครัว</strong></td>                       
            </tr>
            <tr align="center">
            <td><input type="text" class="k-textbox" data-bind="value: number_f" name="number_f"/></td>
            <td><input type="text" class="k-textbox" data-bind="value: number_d" name="number_d"/></td>
            <td><input type="text" class="k-textbox" data-bind="value: name_d" name="name_d"/></td>
            <td><input type="text" class="k-textbox" data-bind="value: relation" name="relation"/></td>
            </tr>
            <tr>
            <td colspan="4"></td>
            </tr>
            <tr align="center">
            <td colspan="2"><strong>การสูบบุหรี่</strong></td>
            <td colspan="2"><strong>โรคร่วม</strong></td>                                   
            </tr>
            <tr align="left">
            <td colspan="2">
            <pre><input type="radio" value="noSmoke"   name="smoke" data-bind="checked: selectedColor" />ไม่เคยสูบบุหรี่</pre>
            <pre><input type="radio" value="cancelSmoke" name="smoke" data-bind="checked: selectedColor" />เลิกสูบบุหรี<label>&nbsp;เมื่อ&nbsp;<input id="datePicker" data-bind="value:whenCancleSmoke" name="whenCancleSmoke"/></label></pre>
            <pre><input type="radio" value="stillSmoke"  name="smoke" data-bind="checked: selectedColor" />ยังสูบบุหรี่<label>&nbsp;ปริมาณ&nbsp;<input size="20" type="text" class="k-textbox" data-bind="value:smokeNumber" name="smokeNumber"/>&nbsp;มวลต่อวัน</label></pre>
            </td>
            <td colspan="2">
            <pre><input type="checkbox" name="h_blood" data-bind="checked: h_blood"/>ความดันโลหิตสูง</pre>
            <pre><input type="checkbox" name="hi_fat" data-bind="checked: hi_fat"/>ไขมันในเลือดสูง</pre>
            <pre><input type="checkbox" name="h_fail" data-bind="checked: h_fail"/>โรคหัวใจวาย</pre>
            <pre><input type="checkbox" name="h_lost_blood" data-bind="checked: h_lost_blood"/>หัวใจขาดเลือด</pre>
            <pre><input type="checkbox" name="h_big" data-bind="checked: h_big"/>กล้ามเนื้อหัวใจโต</pre>
            <pre><input type="checkbox" name="cabg" data-bind="checked: cabg"/>CABG</pre>
            <pre><input type="checkbox" name="brain_blood" data-bind="checked: brain_blood"/>โรคหลอดเลือดสมอง</pre>
            <pre><input type="checkbox" name="other" data-bind="checked: other"/>อื่น ๆ ระบุ</pre>
            </td>            
            </tr>
            </table>           
            </div>
        </script>
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
    <center><div id="baseInfoContainer"></div></center>

    <script>



        var dataSourceDb = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "getInfo_db.php",
                    data: {
                        id: <?php echo json_encode($id); ?>
                    }
                },
                update: {
                    url: "getInfo_db.php",
                    type: "POST"
                }
            },
            error: function(e) {
                alert(e.responseText);
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
                        h_blood: { type: "boolean" },
                        tai_y: { type: "boolean" },
                        h_fail: { type: "boolean" },
                        hi_fat: { type: "boolean" },
                        h_lost_blood: { type: "boolean" },
                        h_big: { type: "boolean" },
                        other: { type: "boolean" } 
                    }
                }
            }
        });

        $("#baseInfoContainer").kendoListView({
            template: kendo.template($("#template").html()),
            editTemplate: kendo.template($("#editTemplate").html()),
            dataSource: dataSourceDb,
            
            edit: function(e) {
                $("#datePicker").kendoDatePicker({
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
                var datepicker = $("#datePicker").data("kendoDatePicker");
                datepicker.enable(false);
                $('input:radio[name="smoke"]').change(
                        function() {
                            if ($(this).val() === 'cancelSmoke') {
                                 datepicker.enable(true);
                            }
                            else {
                                 datepicker.enable(false);
                                 $("#datePicker").val('');
                            }
                        });

            }

        });
//dataSourceDb.read();


        $("#baseInfo").kendoButton({
            click: function(e) {
                alert(e.event.target.tagName);
            }
        });





        /** 
         $("#listView").kendoListView({
         template: kendo.template($("#template").html()),
         editTemplate: kendo.template($("#editTemplate").html()),
         dataSource: {
         transport: {
         read: "testdb.php",
         update: {
         url: "testdb.php",
         type: "POST"
         }
         },
         error: function(e) {
         alert(e.responseText);
         },
         schema: {
         data: "data",
         model: {
         id: "ID",
         fields: {
         name: {editable: false},
         sname: {validation: {required: true}},
         age: {}
         }
         }
         }
         }
         });
         **/



    </script>


</body>
</html>