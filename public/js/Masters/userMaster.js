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
                    { data: "id", visible: false },
                    { data: "email" },
                    { data: "firstname" },
                    { data: "lastname" },
                    { data: "position" },
                    {
                        data: "status",
                        render: function (data, type, row) {
                            const statuses = ['Active', 'Inactive', 'Ban', 'Pending'];
                            let optionsHTML = statuses
                                .map(status =>
                                    `<option value="${status}" ${data === status ? 'selected' : ''}>${status}</option>`
                                )
                                .join("");
                            // Return the dropdown HTML
                            return `
                                    <select class="form-select form-select-sm drpdownStatus" data-id=${row.id} disabled>
                                        ${optionsHTML}
                                    </select>
                                    
                                    `;
                        }
                    },
                    { data: "updated_at" },
                ],
                drawCallback: function (settings) {
                    $('.drpdownStatus').each(function () {
                        self.applyStatusColor(this);
                    });
                    console.log("Table drawn successfully");
                },
            });


            self.$tblUser.on('select', function (e, dt, type, indexes) {
                if (type === 'row') {
                    // Get data of selected rows
                    var selectedRow = self.$tblUser
                        .rows(indexes)
                        .data()
                        .toArray();  // Convert the data to an array if you want to work with it

                    // Iterate through the selected rows' data and log each row's data or process as needed
                    selectedRow.forEach(function (row) {
                        // console.log('Selected Row Data:', row); // Outputs the full row data
                        $('#btnDelete').prop('disabled', false);
                        $('#btnView').prop('disabled', false);
                        $('.drpdownStatus').prop('disabled', false);
                        console.log('Selected ID:', row.id); // Outputs the ID if "id" is part of the data
                    });
                }
            });

            return this;
        },

        applyStatusColor: function (dropdown) {
            const status = dropdown.options[dropdown.selectedIndex].value;
            // console.log(status);

            $(dropdown).removeClass('bg-success bg-warning bg-danger bg-secondary');
            switch (status) {
                case 'Active':
                    $(dropdown).addClass('bg-success text-white');
                    break;
                case 'Inactive':
                    $(dropdown).addClass('bg-warning');
                    break;
                case 'Ban':
                    $(dropdown).addClass('bg-danger');
                    break;
                case 'Pending':
                    $(dropdown).addClass('bg-info');
                    break;
                default:
                    dropdown.style.backgroundColor = '';
            }
        }
    }

    UserMaster.init.prototype = UserMaster.prototype;

    $(document).ready(function () {
        var _U = UserMaster();
        _U.drawDataTables();

        $(document).on('click', function (e) {
            if (
                !$(e.target).closest('#tblUser').length &&
                !$(e.target).closest('#btnDelete').length &&
                !$(e.target).closest('#btnView').length &&
                !$(e.target).closest('.drpdownStatus').length
            ) {
                // Deselect all rows if the click is outside the table or on specified buttons
                _U.$tblUser.rows().deselect();
                $('#btnDelete').prop('disabled', true);
                $('#btnView').prop('disabled', true);
            }
        });
    });
})();
