"use strict";
(function () {
    const UserMaster = function () {
        return new UserMaster.init();
    }
    UserMaster.init = function () {
        this.$tblUser = "";
        this.tblctr = 0;
    }
    UserMaster.prototype = {
        drawDataTables: function () {
            var self = this;

            // Check if the DataTable is already initialized, and destroy it if so
            if ($.fn.DataTable.isDataTable('#tblUser')) {
                $('#tblUser').DataTable().destroy();
            }

            if (!$('#tblUser').hasClass('dataTable')) {

                $('#tblUser thead tr').clone(true).appendTo('#tblUser thead');
                $('#tblUser thead tr:nth-child(2) th').each(function (i) {  
                    var title = $(this).text();
                    $(this).html("<input type='text' class='form-control form-control-sm' placeholder='" + title + "' />");

                    $('input', this).on('keyup change', function () {
                        if (self.$tblUser.column(i).search() !== this.value) {
                            self.$tblUser
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                    
                });

            }

            self.$tblUser = $('#tblUser').DataTable({
                orderCellsTop: true, // Keeps the sorting on the first row, not the second
                responsive: true,
                select: true,
                language: {
                    lengthMenu: "_MENU_ Entries",
                },
                processing: true,
                serverSide: true,
                order: [[4, "desc"]],
                dataSrc: "data",
                ajax: {
                    url: baseURL + "getUserList",
                    type: "POST",
                    datatype: "json",
                    data: function (d) {
                        d.draw = self.$tblUser ? self.$tblUser.settings()[0].iDraw : 1;
                        $('#tblUser thead tr:nth-child(2) th').each(function (index) {
                            var searchValue = $(this).find('input').val();  // Get input value
                            d['columns[' + index + '][search][value]'] = searchValue || "";  // Assign to DataTables payload
                        });
                    },
                    error: function (error) {
                        console.error(error);
                    },
                },
                columns: [
                    { data: "email" },
                    { data: "firstname" },
                    { data: "lastname" },
                    { data: "position" },
                    { data: "updated_at" },
                ],
                drawCallback: function (settings) {
                    console.log("Table drawn successfully");
                },
            });

            return this;

        },
    }

    UserMaster.init.prototype = UserMaster.prototype;

    $(document).ready(function () {
        var _U = UserMaster();
        _U.drawDataTables();
    });
})();
