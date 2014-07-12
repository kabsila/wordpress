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

        <link href="css/index.css" rel="stylesheet" />
        <style>
            html { height: 100%; width: 100%;}
            body { height: 100%; width: 100%;}        

        </style>
        <script>
            $(function() {
                $("#refreshButton").kendoButton();
            });


        </script>
    </head>
    <body>
        <div id="grid"></div>
        
        <script>
            $(function() {
                $("#grid").kendoGrid({
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
                                    sname: {validation: {required: true}}
                                }
                            }
                        }
                    },
                    columns: [{field: "name", title: "Firstname"}, {field: "sname", title: "Lastname"}],
                    ///detailTemplate: kendo.template($("#template").html()),
                   // detailInit: detailInit,
                    editable: true,
                    navigable: true, // enables keyboard navigation in the grid
                    toolbar: ["save", "cancel"]  // adds save and cancel buttons
                });
            });

            
        </script>
    </body>
</html>