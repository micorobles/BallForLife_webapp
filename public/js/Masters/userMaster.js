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

            if (!$('#tblUser').hasClass('dataTable')) {

                $('#tblUser thead tr').clone(true).appendTo('#tblUser thead');
                $('#tblUser thead tr:nth-child(2) th').each(function (i) {
                    var title = $(this).text();
                    $(this).html("<input type='text' class='form-control form-control-sm' placeholder='" + title + "' />");
                });

                // $('input', this).on('keyup change', function () {
                //     if (self.$tblUser.column(i).search() !== this.value) {
                //         self.$tblUser
                //             .column(i)
                //             .search(this.value)
                //             .draw();
                //     }
                // });
            }

            self.$tblUser = $('#tblUser').DataTable({
                orderCellsTop: true, // Keeps the sorting on the first row, not the second
                responsive: true,
                select: true,
                language: {
                    lengthMenu: "_MENU_ Entries"
                }
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
