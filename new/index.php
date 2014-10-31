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

        <link href="css/index.css" rel="stylesheet" />
        <style>
            html { height: 100%; width: 100%;}
            body { height: 100%; width: 100%;}        

        </style>


    </head>
    <body>
        <script type="text/x-kendo-template" id="template2">
            <div id="details-container">
            <h2> FirstName #:name#</h2>

            <dl>
            <dt>City: #:sname#</dt>

            </dl>
            </div>
        </script>
        <script type="text/x-kendo-tmpl" id="template">

            <td>#:name#</td>
            <td>#:sname#</td>
            <td><div>
            <a class="k-button k-edit-button" href="\\#"><span class="k-icon k-edit"></span></a>
            <a class="k-button k-delete-button" href="\\#"><span class="k-icon k-delete"></span></a>
            </div></td>


        </script>

        <script type="text/x-kendo-tmpl" id="editTemplate">
            <div>
            <dl>
            <dt>Name</dt>
            <dd><input type="text" data-bind="value:name" name="name" required="required" /></dd>
            <dt>Age</dt>
            <dd><input type="text" data-bind="value:sname" data-role="numerictextbox" data-type="number" name="age" required="required" /></dd>
            </dl>
            <div>
            <a class="k-button k-update-button" href="\\#"><span class="k-icon k-update"></span></a>
            <a class="k-button k-cancel-button" href="\\#"><span class="k-icon k-cancel"></span></a>
            </div>
            </div>
        </script>

        <script type="text/x-kendo-template" id="searchTemplate">
            <div class="toolbar">
            <label class="category-label" for="category">Show products by category:</label>
            <input type="search" id="category" style="width: 150px"/>
            </div>
        </script>
        <div id="contener">
            <div id="content">
                <div id="add">
                    <a class="k-button k-button-icontext k-add-button" href="#"><span class="k-icon k-add"></span>เพิ่มผู้ป่วย</a>
                </div>                
            </div>
        </div>

        <!--<div id="listView"></div>-->

        <div id="grid"></div>
        <div id="details"></div>
        <script>
            $("#listView").kendoListView({
                template: kendo.template($("#template").html()),
                editTemplate: kendo.template($("#editTemplate").html()),
                dataSource: {
                    transport: {
                        read: {
                            url: "testdb.php"
                        },
                        update: {
                            url: "testdb.php?type=update",
                            type: "POST"
                        },
                        create: {
                            url: "testdb.php?type=create",
                            dataType: "json",
                            type: "PUT",
                            complete: function (e) {
                                $("#grid").data("kendoGrid").dataSource.read();
                            }

                        },
                        destroy: {
                            url: "testdb.php?type=destroy",
                            dataType: "json",
                            type: "POST"
                        }
                    },
                    error: function (e) {
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

            $(function () {
                var grid = $("#grid").kendoGrid({
                    dataSource: {
                        transport: {
                            read: {
                                url: "testdb.php"
                            },
                            update: {
                                url: "testdb.php?type=update",
                                type: "POST"
                            },
                            create: {
                                url: "testdb.php?type=create",
                                dataType: "json",
                                type: "PUT",
                                complete: function (e) {
                                    $("#grid").data("kendoGrid").dataSource.read();
                                }

                            },
                            destroy: {
                                url: "testdb.php?type=destroy",
                                dataType: "json",
                                type: "POST"
                            }
                        },
                        error: function (e) {
                            alert(e.responseText);
                        },
                        schema: {
                            data: "data",
                            model: {
                                id: "ID",
                                fields: {
                                    name: {
                                        validation: {
                                            required: true
                                        }
                                        //editable: false
                                    },
                                    sname: {
                                        validation: {
                                            required: true
                                        }
                                    }
                                }
                            }
                        }
                    },
                    filterable: {
                        operators: {
                            string: {
                                contains: "มีคำว่า"
                            }
                        },
                        messages: {
                            info: "ใส่คำที่ต้องการค้นหา",
                            filter: "ค้นหา",
                            clear: "ยกเลิก"
                        },
                        extra: false
                    },
                    change: function () {
                        var text = "";
                        var grid = this;

                        grid.select().each(function () {
                            var dataItem = grid.dataItem($(this));
                            text += dataItem.id + dataItem.name + "\n";
                        });

                        // alert(text);
                    },
                    selectable: true,
                    columns: [{field: "name", title: "Firstname", width: 10},
                        {field: "sname", title: "Lastname", width: 10},
                        {command: [{
                                    name: "details",
                                    click: function (e) {
                                        var tr = $(e.target).closest("tr"); // get the current table row (tr)                                        // get the data bound to the current table row
                                        var data = this.dataItem(tr);
                                        window.location.replace("info.php?id=" + data.id);                                      //alert("testdb2.php?id=" + data.id);
                                    }
                                }], width: 10},
                        {title: "Click delete", command: 'destroy', width: 10}],
                    ///detailTemplate: kendo.template($("#template").html()),
                    // detailInit: detailInit,
                    editable: true,
                    navigable: true, // enables keyboard navigation in the grid
                    toolbar: ["create", "save", "cancel"]  // adds save and cancel buttons
                });

            });



        </script>


        <script>
            //$("#grid").kendoGrid({});
            /** $(function() {
             $("#add").kendoButton();
             var button = $("#add").data("kendoButton");
             button.bind("click", function(e) {
             alert(e.event.target.tagName);
             });
             });**/

            /** $(function() {
             $(".k-add-button").click(function(e) {
             var listView = $("#listView").data("kendoListView");
             listView.add();
             e.preventDefault();
             });
             });**/

            $(function () {
                $(".k-add-button").click(function (e) {
                    var listView = $("#grid").data("kendoGrid");
                    listView.addRow();
                    e.preventDefault();
                });
            });
        </script>

    </body>
</html>