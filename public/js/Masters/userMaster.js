import { ajaxRequest, showToast, showQuestionToast, isIziToastActive, ucfirst } from "../global/global-functions.js";
import { getProfileData } from "../Profile/profile.js";

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

                            return `
                                <div class="status-container">
                                    <span>${data}</span>
                                </div>
                            `;
                        }
                    },
                    { data: "updated_at" },
                ],
                drawCallback: function (settings) {
                    $('.status-container').each(function () {
                        self.applyStatusColor(this);
                    });
                    console.log("Table drawn successfully");
                },
            });


            self.$tblUser.on('select', function (e, dt, type, indexes) {
                if (type === 'row') {
                    // Get data of selected rows
                    // var selectedRow = self.$tblUser
                    //     .rows(indexes)
                    //     .data()
                    //     .toArray();  
                    var selectedRows = self.$tblUser.rows({ selected: true }).data().toArray();

                    self.isSingleSelection = selectedRows.length === 1;

                    self.selectedRowID = null;
                    self.rowIDs = [];
                    self.rowDetails = [];

                    // if (self.isSingleSelection) {
                    //     self.selectedRowID = selectedRows[0].id;
                    // }

                    // Iterate through the selected rows' data and log each row's data or process as needed
                    selectedRows.forEach(function (row) {
                        // self.selectedRowID = row.id;
                        // self.selectedRowFirstName = row.firstname;
                        // self.selectedRowLastName = row.lastname;
                        self.rowIDs.push(row.id);
                        self.rowDetails.push({
                            firstname: row.firstname,
                            lastname: row.lastname
                        });

                        $('.crud-buttons').prop('disabled', false);
                        // console.log('Selected ID:', row.id); // Outputs the ID if "id" is part of the data
                    });

                    // console.log(self.isSingleSelection);
                    if (self.isSingleSelection) {
                        self.selectedRowID = self.rowIDs[0];
                        $('.crud-buttons').prop('disabled', false);
                    } else {
                        $('.crud-buttons').prop('disabled', true);
                        $('#btnDeleteUser').prop('disabled', false);
                    }

                }
            });

            self.$tblUser.on('draw', function () {
                $('.status-container').each(function () {
                    self.applyStatusColor(this);
                });
                // console.log("Colors applied on draw event");
            });

            return this;
        },
        applyStatusColor: function (container) {
            const status = $(container).find('span').text().trim();
            // console.log("Applying color for status:", status);
            // console.log(status);

            $(container).removeClass('bg-success bg-warning bg-danger bg-secondary');
            switch (status) {
                case 'Active':
                    $(container).addClass('bg-success text-white');
                    break;
                case 'Inactive':
                    $(container).addClass('bg-warning');
                    break;
                case 'Ban':
                    $(container).addClass('bg-danger');
                    break;
                case 'Pending':
                    $(container).addClass('bg-info');
                    break;
                default:
                    $(container).css('background-color', '');
            }
            return this;
        },
        modifyUserStatusOrPassword: function () {
            var self = this;
            const modifyURL = baseURL + `modifyUser/${self.selectedRowID}`;

            // $('#frmUserProfile input:disabled').prop('disabled', false);

            let formData = new FormData($('#frmUserProfile')[0]);
            
            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            showQuestionToast({
                message: 'Are you sure you want to modify this user?',
                onYes: async function (instance, toast) {
                    const modifyUser = await ajaxRequest('POST', modifyURL, formData, {
                        contentType: false,
                        processData: false,
                    }).catch(function (error) {
                        console.error("AJAX error response:", error.responseText);
                        throw error;
                    });

                    if (!modifyUser) {
                        showToast('error', 'Error: ', modifyUser.message);
                    }

                    // console.log(modifyUser);
                    showToast('success', '', modifyUser.message);
                    $('#modifyUserModal').modal('hide');
                    self.$tblUser.ajax.reload();

                },
            });
        },
        deleteUser: function () {
            var self = this;

            const selectedNames = self.rowDetails.map(row => `${row.firstname} ${row.lastname}`).join(', ');
            const deleteMessage = self.isSingleSelection ? `Are you sure you want to delete ${selectedNames}?` 
                                  : `Are you sure you want to delete these users: ${selectedNames}?`;  

            showQuestionToast({
                message: deleteMessage,
                onYes: async function (instance, toast) {

                    try {
                        // Loop through selected IDs, handling both single and multiple deletions
                        const deletePromises = self.rowIDs.map(userID => {
                            const deleteURL = baseURL + `deleteUser/${userID}`;
                            return ajaxRequest('POST', deleteURL, '')
                                .then(deleteUser => {
                                    if (!deleteUser) throw new Error(deleteUser.message);
                                    return deleteUser.message;
                                });
                        });
        
                        // Wait for all deletion requests to complete
                        const results = await Promise.all(deletePromises);
                        results.forEach(message => showToast('success', '', message));
        
                        self.$tblUser.ajax.reload();
                    } catch (error) {
                        showToast('error', 'Error: ', error.message);
                    }
                },
            });
        },
        populateUserModal: async function () {
            var self = this;

            const getUserURL = baseURL + `getUser/${self.selectedRowID}`;
            const frmID = 'frmUserProfile';

            const getUser = await ajaxRequest('GET', getUserURL, '');

            if (!getUser) {
                showToast('error', 'Error: ', getUser.message);
            }

            const userDetails = getUser.data;

            var formInputs = [];

            $.each($(`#${frmID} [id*='modal-']`), function (i, e) {
                var $input = $(e);
                formInputs.push({
                    id: $input.attr('id'),
                    name: $input.attr('name'),
                    type: $input.attr('type'),
                    element: $input
                });
            });
            // console.log(formInputs);

            // console.log('FORM INPUTS: ', formInputs);
            $.each(userDetails, function (key, value) {
                var strippedKey = key.trim();

                // Find the form input element that matches the key
                var formInput = formInputs.find(input => input.name.replace('modal-', '') === strippedKey);

                if (formInput) {
                    // console.log('FORM INPUT: ', formInput);
                    if (formInput.type === 'text') {
                        formInput.element.val(value);
                    }

                    if (formInput.type === 'radio') {
                        $(`input[name="${formInput.name}"]`).each(function () {
                            if ($(this).val() === value) {
                                $(this).prop('checked', true);
                            }
                        });
                    }
                    if (formInput.name === 'modal-role' ) {
                        formInput.element.empty();
                        const roles = ['Admin', 'User'];
                         roles.forEach(role => {
                            const selected = value === role ? 'selected' : '';
                            formInput.element.append(`<option value="${role}" ${selected}>${role}</option>`)
                         });
                    }
                }
            });

            return this;
        },
        generatePassword: function () {
            var length = 8,
                characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()",
                password = '';

            for (var i = 0, n = characters.length; i < length; ++i) {
                password += characters.charAt(Math.floor(Math.random() * n));
            }

            return password;
        },
        copyPassword: function () {
            var passwordValue = $('#modal-password').val();

            // Create a temporary div with contentEditable
            const tempDiv = document.createElement("div");
            tempDiv.contentEditable = true; // Make it editable
            document.body.appendChild(tempDiv); // Append it to the body

            // Set the text and select it
            tempDiv.innerText = passwordValue;
            const range = document.createRange();
            range.selectNodeContents(tempDiv);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);

            // Copy the selected text
            try {
                const successful = document.execCommand("copy");
                if (successful) {
                    //  alert("Password copied to clipboard!");
                    showToast('info', '', 'Password copied to clipboard.');
                } else {
                    //  alert("Failed to copy password.");
                    showToast('error', '', 'Failed to copy password');
                }
            } catch (err) {
                console.error("Fallback: Unable to copy", err);
            }

            // Clean up: remove the temporary div and clear selection
            document.body.removeChild(tempDiv);
            selection.removeAllRanges();

            return this;
        }
    }



    UserMaster.init.prototype = UserMaster.prototype;

    $(document).ready(function () {
        var _U = UserMaster();
        _U.drawDataTables();

        ////////////////////////////////////////////////////////////////
        ///// TABLE EVENTS
        ////////////////////////////////////////////////////////////////

        $(document).on('click', function (e) {
            if (
                !$(e.target).closest('#tblUser').length &&
                !$(e.target).closest('.crud-buttons').length &&
                !$(e.target).closest('#viewProfileModal, #modifyUserModal').length &&
                !$(e.target).closest('td').length && !isIziToastActive
            ) {
                // Deselect all rows if the click is outside the table or on specified buttons
                deselectRowsAndDisableButtons();
            }

        });

        $(document).on('keydown', function (event) {

            if (event.key === 'Escape' && !isIziToastActive) {
                $('#viewProfileModal').modal('hide');
                $('#modifyUserModal').modal('hide');
                // deselectRowsAndDisableButtons();
            }
        });

        $('#tblUser tbody').on('dblclick', 'tr', function (e) {
            _U.$tblUser.rows($(this)).select();
            $('#viewProfileModal').modal('show');
            profileAction();
        });

        $('#btnView').on('click', profileAction);

        $('#btnModifyUser').on('click', function () {
            _U.populateUserModal();
        });

        $('#btnSaveUser').click(function (e) {
            e.preventDefault();
            _U.modifyUserStatusOrPassword();
        });

        $('#btnDeleteUser').click(function (e) {
            e.preventDefault();
            _U.deleteUser();
        });

        ////////////////////////////////////////////////////////////////
        ///// MODAL/FORM FUNCTIONS
        ////////////////////////////////////////////////////////////////

        $('#pwCopy').click(_U.copyPassword);

        $('#shuffle-icon').click(function () {
            $('#modal-password').val(_U.generatePassword);
        });

        ////////////////////////////////////////////////////////////////
        ///// FUNCTIONS
        ////////////////////////////////////////////////////////////////

        function deselectRowsAndDisableButtons() {
            _U.$tblUser.rows().deselect();
            $('.crud-buttons').prop('disabled', true);
        }

        function profileAction() {
            const rowID = _U.selectedRowID ?? 0;
            // $('#viewProfileModal').modal('show');
            getProfileData(rowID);
        }
    });

})();
