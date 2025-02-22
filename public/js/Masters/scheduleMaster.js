import { ajaxRequest, showToast, showQuestionToast, isIziToastActive, ucfirst } from "../global/global-functions.js";
// import { DateTime } from '../global/tempus-dominus.min.js';
// import * as TempusDominus from '../global/tempus-dominus.js';
// console.log(Object.keys(TempusDominus)); 
// 
// import moment from 'moment';
// import '@eonasdan/tempus-dominus/build/css/tempusdominus-bootstrap-4.min.css';

// import { DateTimePicker } from '@eonasdan/tempus-dominus';

"use strict";
(function () {

    const ScheduleMaster = function () {
        return new ScheduleMaster.init();
    }
    ScheduleMaster.init = function () {
        // Mali pala to dapat walang assigned lahat
        this.calendar = document.getElementById('calendar');
        this.datetimePickers = ['#modal-schedStartDate', '#modal-schedEndDate'];
        this.scheduleModal = $('#scheduleModal');
        this.scheduleForm = $('#frmSchedule');
        this.eventID = '';
        this.eventTitle = '';
        this.$tblAppointments = '';
        this.appointments = [];
    }
    ScheduleMaster.prototype = {
        drawCalendar: function () {
            var self = this;

            const calendar = new FullCalendar.Calendar(self.calendar, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                editable: true,
                selectable: true,
                droppable: true,
                // validRange: {
                //     start: moment().format('YYYY-MM-DD') // Disable all past dates
                // },
                headerToolbar: {
                    right: 'prev,today,next',
                    center: 'title',
                    left: 'dayGridMonth,timeGridWeek,timeGridDay,list'
                },
                viewDidMount: function (info) {
                    // Add classes to specific toolbar chunks
                    const toolbar = document.querySelector('.fc-header-toolbar');
                    if (toolbar) {
                        const chunks = toolbar.querySelectorAll('.fc-toolbar-chunk');
                        if (chunks[0]) chunks[0].classList.add('fc-left');
                        if (chunks[1]) chunks[1].classList.add('fc-center');
                        if (chunks[2]) chunks[2].classList.add('fc-right');
                    }
                },
                dayCellDidMount: function (arg) {
                    arg.isPast ? $(arg.el).css('background-color', '#f2f4f5') : '';
                },
                select: function (start, end) {
                    // console.log(start);
                    // self.resetModal();
                    // self.scheduleModal.modal('show');
                    // // $('#btnEditSchedule, #btnSaveSchedule').hide();
                    // $('#btnCreateSchedule').show();
                    // $('#scheduleModalLabel').text('Create Schedule');
                },
                dateClick: function (info) {

                    if (moment(info.dateStr).isBefore(moment(), 'day')) {
                        // Prevent any action on past dates, but still allow event display
                        return false;
                    }

                    self.resetModal();
                    self.scheduleModal.modal('show');
                    $('#btnCreateSchedule').show();
                    $('#scheduleModalLabel').text('Create Schedule');

                    var datetimeClicked = moment(info.dateStr).format('MMMM D, YYYY - h:mm A');

                    var startDateID = '#modal-schedStartDate';
                    var endDateID = '#modal-schedEndDate';

                    $(startDateID).val(datetimeClicked);
                    $(endDateID).val(datetimeClicked);

                    self.renderDateTimePicker(datetimeClicked, [startDateID, endDateID]);
                    self.renderColorPicker('#colorPicker', '#modal-schedColor', '#modal-schedTextColor');
                },
                events: async function (fetchInfo, successCallback, failureCallback) {
                    const getAllEvents = await ajaxRequest('GET', baseURL + '/getAllSchedule', '');

                    if (!getAllEvents) {
                        showToast('error', 'Error: ', getAllEvents.message);
                        failureCallback(getAllEvents.message);
                    }

                    successCallback(getAllEvents.data);

                    // console.log('FETCH INFO: ', fetchInfo);
                    console.log('GET ALL EVENTS: ', getAllEvents);
                },
                eventClick: self.handleEventClick.bind(this),
                eventDrop: async function (event) {

                    var dateChanges = {
                        startDate: moment(event.event.startStr).format('YYYY-MM-DD HH:mm:ss'),
                        endDate: moment(event.event.endStr).format('YYYY-MM-DD HH:mm:ss'),
                    };

                    const dragEventUpdate = await ajaxRequest('POST', baseURL + `editSchedule/${event.event.id}`, dateChanges).catch(
                        function (error) {
                            console.error("AJAX error response:", error.responseText);
                            showToast('error', 'Error', 'An error occurred while updating the event.');
                            throw error;
                        }
                    );

                    if (!dragEventUpdate) {
                        showToast('error', 'Error', dragEventUpdate.message);
                    }

                    showToast('success', '', 'Schedule moved!');
                },
                eventDidMount: function (info) {
                    console.log('INFO: ', info);

                    // let hasAppointment = info.event.extendedProps.appointmentCount > 0 ? true : false;
                    // hasAppointment ? info.event.setProp('editable', false) : '';

                    // info.isEnd ? info.el.classList.add('event-ended') : '';
                    // info.isPast ? info.el.classList.add('event-past') : '';


                    setTimeout(() => {
                        let hasAppointment = info.event.extendedProps.appointmentCount > 0;

                        hasAppointment ? info.event.setProp('editable', false) : '';

                        info.isEnd ? info.el.classList.add('event-ended') : '';
                        info.isPast ? info.el.classList.add('event-past') : '';
                    }, 0);

                    // hasAppointment ? info.el.draggable = false : '';
                    // hasAppointment ? info.isDraggable = false : '';

                    // if (hasAppointment) {
                    //     $(info.el).off('mousedown');  // Disable dragging by removing the mouse events
                    //     $(info.el).off('touchstart'); // Disable touch dragging
                    //     // $(info.el).css('cursor', 'not-allowed');
                    // }

                },
                eventContent: function (arg) {
                    // console.log('ARG: ', arg);

                    const today = moment();
                    const startDate = moment(arg.event.startStr);
                    const endDate = moment(arg.event.endStr);

                    // console.log(today);

                    // Check if the event's start and end dates are valid
                    if (!startDate.isValid() || !endDate.isValid()) {
                        console.error("Invalid dates");
                        return;
                    }
                    // Initialize event status properties
                    arg.isFuture = startDate.isAfter(today, 'day');
                    // arg.isToday = startDate.isSame(today, 'day') || endDate.isSame(today, 'day');
                    arg.isToday = today.isBetween(startDate, endDate, 'day', '[]');
                    // arg.isStart = arg.isToday && startDate.isSameOrBefore(today, 'minute');
                    arg.isStart = arg.isToday && today.isBetween(startDate, endDate, 'minute', '[]');
                    arg.isEnd = arg.isToday && endDate.isSameOrBefore(today, 'minute');
                    arg.isPast = !arg.isToday && !arg.isFuture && endDate.isBefore(today);

                    var startTime = moment(arg.event.start).format('ha'); // Format the time to '2pm' format

                    var eventTitle = `<span><i><strong>${startTime}</strong></i><span class="text-truncate"> ${arg.event.title}</span></span>`;

                    return {
                        html: eventTitle
                    };
                },

            });

            calendar.render();
            return calendar;
        },
        handleEventClick: async function (event) {
            var self = this;

            self.eventID = event.event.id;
            self.eventTitle = event.event.title;

            const getSingleEvent = await ajaxRequest('GET', baseURL + `/getSingleSchedule/${self.eventID}`);

            if (!getSingleEvent) {
                showToast('error', 'Error: ', getSingleEvent.message);
            }

            console.log(getSingleEvent);

            self.resetModal();
            self.scheduleModal.modal('show');
            $('#btnEditSchedule').show();
            $('#btnDeleteSchedule').show();
            $('#btnAppointments').show();
            $('#scheduleModalLabel').text('View Schedule');
            // $('#btnSaveSchedule').attr('data-id', event.event.id);

            $.each(getSingleEvent.data, function (key, value) {

                let id = `#modal-sched${ucfirst(key)}`;

                if (key === 'startDate' || key === 'endDate') {

                    let momentValue = moment(value);

                    if (key === 'startDate') {
                        let isStarted = momentValue.isBefore(moment(), 'minute');

                        // isStarted ? self.scheduleModal.attr('data-schedExecuted', true) : self.scheduleModal.attr('data-schedExecuted', false);
                        isStarted ? self.scheduleModal.addClass('schedExecuted') : '';
                        momentValue.isBefore(moment(), 'minute') ? console.log('true') : console.log('false');
                    }


                    value = momentValue.format('MMMM D, YYYY - h:mm A');
                    self.renderDateTimePicker(value, id);
                }

                if (key === 'color') {
                    $('#colorPicker').css('background-color', value);
                }

                $(id).val(value);
                $(id).prop('disabled', true);

                // console.log(key, ' : ', value); 
                // console.log(id, ' : ', value); 
            });

            return this;
        },
        renderWidgets: async function () {
            var self = this;

            const widgetsData = await ajaxRequest('GET', baseURL + '/getWidgetsData', '');

            if (!widgetsData.success) {
                showToast('error', 'Error: ', widgetsData.message);
                // console.info(widgetsData.message);
                return;
            }

            // console.log(widgetsData.data);
            const apptPending = widgetsData.data.appointmentsPending || [];
            const apptJoined = widgetsData.data.appointmentsJoined || [];

            // APPOINTMENT REQUESTS WIDGET
            $('.float-widget .widget-body ul.list-group').empty();
            var appointmentHTML = '';

            if (apptPending.length === 0) {
                appointmentHTML += `
                                    <li class="list-group-item d-flex justify-content-between" style="pointer-events: none;">
                                        <span class="regular-text text-white font-xs" style="flex-grow: 1; max-width: calc(100% - 30px);">
                                            No appointments yet.
                                            </span>
                                    </li>
                                    
                                    `;
            }

            $.each(apptPending, function (i, appt) {

                appointmentHTML += `
                                    <li id="appointmentItem" class="list-group-item d-flex justify-content-between" data-id="${appt.schedID}">
                                        <span id="scheduleName" class="scheduleName text-truncate" style="flex-grow: 1; max-width: calc(100% - 30px);">
                                            ${appt.title}
                                            </span>
                                            <span id="appointmentCount" class="badge bg-danger">${appt.count}</span>
                                    </li>
                                    
                                    `;
            });

            $('#appointments-widget .widget-body ul.list-group').append(appointmentHTML);

            // PLAYERS JOINED WIDGET
            var playersHTML = '';

            if (apptJoined.length === 0) {
                playersHTML += `
                                    <li class="list-group-item d-flex justify-content-between" style="pointer-events: none;">
                                        <span class="regular-text text-white font-xs" style="flex-grow: 1; max-width: calc(100% - 30px);">
                                            No players yet.
                                            </span>
                                    </li>
                                    
                                    `;
            }

            $.each(apptJoined, function (i, appt) {

                playersHTML += `
                                    <li id="playersItem" class="list-group-item d-flex justify-content-between" data-id="${appt.schedID}">
                                        <span id="scheduleName" class="scheduleName text-truncate" style="flex-grow: 1; max-width: calc(100% - 30px);">
                                            ${appt.title}
                                        </span>
                                        <span id="playersCount" class="badge bg-secondary">${appt.count}/${appt.maxPlayer}</span>
                                    </li>
                            
                                `;
            });

            $('#players-widget .widget-body ul.list-group').append(playersHTML);

            return this;
        },
        createSchedule: function () {
            var self = this;

            const formData = new FormData(self.scheduleForm[0]);

            $.each(self.datetimePickers, function (i, selector) {
                var key = selector.replace('#', '');
                var value = moment($(selector).val(), 'MMMM D, YYYY - h:mm A').format('YYYY-MM-DD HH:mm:ss');

                formData.set(key, value);
            });

            showQuestionToast({
                message: `Are you sure you want to create schedule for ${formData.get('modal-schedTitle')}?`,
                onYes: async function (instance, toast) {
                    const createSchedule = await ajaxRequest('POST', baseURL + '/createSchedule', formData, {
                        contentType: false,
                        processData: false,
                    }).catch(function (error) {
                        console.error("AJAX error response:", error.responseText);
                        throw error;
                    });

                    if (!createSchedule) {
                        showToast('error', 'Error: ', createSchedule.message);
                    }

                    // console.log(createSchedule);
                    showToast('success', '', createSchedule.message);
                    self.scheduleModal.modal('hide');
                    self.drawCalendar().getEvents();
                },
            });

            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            return this;
        },
        deleteSchedule: function () {
            var self = this;

            showQuestionToast({
                message: `Are you sure you want to delete ${self.eventTitle}?`,
                onYes: async function (instance, toast) {
                    const deleteSchedule = await ajaxRequest('POST', baseURL + `/deleteSchedule/${self.eventID}`, {
                        contentType: false,
                        processData: false,
                    }).catch(function (error) {
                        console.error("AJAX error response:", error.responseText);
                        throw error;
                    });

                    if (!deleteSchedule) {
                        showToast('error', 'Error: ', deleteSchedule.message);
                    }

                    // console.log(deleteSchedule);
                    showToast('success', '', deleteSchedule.message);
                    self.scheduleModal.modal('hide');
                    // self.resetModal();
                    self.drawCalendar().getEvents();
                },
            });

            return this;
        },
        saveScheduleChanges: function () {
            var self = this;

            const formData = new FormData(self.scheduleForm[0]);

            $.each(self.datetimePickers, function (i, selector) {
                var key = selector.replace('#', '');
                var value = moment($(selector).val(), 'MMMM D, YYYY - h:mm A').format('YYYY-MM-DD HH:mm:ss');

                formData.set(key, value);
            });

            // console.log('SELF EVENT ID: ', self.eventID);

            showQuestionToast({
                message: `Are you sure you want to update ${formData.get('modal-schedTitle')}?`,
                onYes: async function (instance, toast) {
                    const saveSchedule = await ajaxRequest('POST', baseURL + `/editSchedule/${self.eventID}`, formData, {
                        contentType: false,
                        processData: false,
                    }).catch(function (error) {
                        console.error("AJAX error response:", error.responseText);
                        throw error;
                    });

                    if (!saveSchedule) {
                        showToast('error', 'Error: ', saveSchedule.message);
                    }

                    // console.log(saveSchedule);
                    showToast('success', '', saveSchedule.message);
                    self.scheduleModal.modal('hide');
                    // self.resetModal();
                    self.drawCalendar().getEvents();
                },
            });

            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            return this;
        },
        viewAppointments: function () {
            var self = this;

            // console.log(self.eventID);
            var html = '';

            if (self.$tblAppointments) {
                self.$tblAppointments.clear().destroy();
                console.log('DataTable detroyed');
            }

            /////////////////////////////// DESIGN TABLE DATA TABLE ////////////////////////////////////////
            html = `
                    <div class="appointments-container mt-4">
                        <label class="font-md text-muted mb-2">Appointments</label>
                        <div class="appointments rounded border p-2">
                            <table id="tblAppointments" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Receipt</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>`;

            $('#scheduleModal .modal-body').append(html);

            setTimeout(function () {
                $('#scheduleModal .modal-body .appointments-container').addClass('show');

                self.drawDataTable('#tblAppointments');

            }, 10);


            return this;
        },
        drawDataTable: function (tableID) {
            var self = this;

            if ($.fn.DataTable.isDataTable(tableID)) {
                $(tableID).DataTable().destroy();
                // console.log('DataTable destroyed');
            }

            self.$tblAppointments = $(tableID).DataTable({
                orderCellsTop: true, // Keeps the sorting on the first row, not the second
                responsive: true,
                // autoWidth: true,
                // select: true,
                language: {
                    lengthMenu: "_MENU_ Entries",
                    emptyTable: "No players yet"
                },
                processing: true,
                serverSide: true,
                // order: [[4, "desc"]],
                dataSrc: "data",
                ajax: {
                    url: baseURL + "getScheduleAppointments/" + self.eventID,
                    type: "POST",
                    datatype: "json",
                    data: function (d) {
                        // console.log('Data: ', d);

                    },
                    error: function (error) {
                        console.error(error);
                    },
                },
                columns: [

                    // { data: 'count', title: '#', orderable: true, className: 'text-start' },
                    { data: 'id', visible: false },
                    {
                        data: 'fullname',
                        title: 'Player',
                        render: function (data, type, row) {
                            return `
                                    <div class="">
                                        ${data}
                                    </div>
                            `;
                        }
                    },
                    { data: 'position' },
                    {
                        data: 'receipt',
                        render: function (data, type, row) {
                            return `
                                    <div class="">
                                        <button id="btnViewReceipt" class="btn btn-sm btn-primary" data-src="${data}">View</button>
                                    </div>
                            `;
                        }
                    },
                    { data: 'timestamp' },
                    {
                        data: null,
                        title: 'Action',
                        className: 'text-center',
                        render: function (data, type, row) {
                            return `
                                    <button class="btn btn-sm btn-success btnAppointmentAction" data-id="${row.id}" data-accept="true" >Accept</button>
                                    <button class="btn btn-sm btn-danger btnAppointmentAction" data-id="${row.id}" data-accept="false" >Reject</button>
                                `;
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 5], // Disable sorting for columns with index 0, 1, and 2
                        orderable: false, // Disable ordering for these columns
                    },
                ],
                rowCallback: function (row, data) {
                    let status = data.status;
                    const $row = $(row);
                    const $btns = $row.find('.btnAppointmentAction');

                    // console.log('ROW: ', $row);

                    $row.removeClass('joined rejected');
                    $btns.show();

                    switch (status) {
                        case 'Joined':
                            $row.addClass('joined');
                            break;
                        case 'Rejected':
                            $row.addClass('rejected');
                            break;
                        default:
                            $btns.show();
                            break;
                    }

                    $('#tblAppointments tbody').on('click', row, function () {
                        var parentRow = $(row);
                        var childRow = parentRow.next('.child');

                        if ($('#tblAppointments').hasClass('dtr-inline')) {

                            if (parentRow.hasClass('joined dt-hasChild dtr-expanded') || parentRow.hasClass('rejected dt-hasChild dtr-expanded')) {
                                childRow.find('.btnAppointmentAction').hide();  // Hides buttons in the child row
                            }
                        }
                    });
                },
            });

            return this;
        },
        acceptOrDeclineAppointment: async function (appointmentID, isAccept) {
            var self = this;

            console.log('Appointment Action: ', appointmentID, isAccept);

            const appointmentAction = await ajaxRequest('POST', baseURL + `/appointmentApproval/${appointmentID}/${isAccept}`);

            if (!appointmentAction.success) {
                showToast('error', 'Error: ', appointmentAction.message);
                return;
            }

            // console.log(saveSchedule);
            showToast('success', '', appointmentAction.message);
            self.$tblAppointments.ajax.reload();
            self.renderWidgets();

            return this;
        },
        viewReceipt: function (receiptSrc) {
            var self = this;

            $('.receipt-container').removeClass('d-none');
            $('#imgReceipt').attr('src', receiptSrc);

            return this;
        },
        renderDateTimePicker: function (dateTime, selector) {
            var self = this;

            var selector = Array.isArray(selector) ? selector : [selector];

            selector.forEach(function (sel) {

                $(sel).val('');

                new tempusDominus.TempusDominus(document.querySelector(sel), {
                    defaultDate: moment(dateTime, 'MMMM D, YYYY - h:mm A').toDate(),
                    display: {
                        icons: {
                            time: 'far fa-clock',
                            date: 'far fa-calendar',
                            up: 'fa fa-chevron-up',
                            down: 'fa fa-chevron-down',
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-calendar-check-o',
                            clear: 'fa fa-trash'
                        }
                    },
                    localization: {
                        dayViewHeaderFormat: { month: 'long', year: 'numeric' },
                        format: 'MMMM d, yyyy - h:mm T'
                    }

                });

            });

            return this;
        },
        renderColorPicker: function (selector, frmInput, frmInputText) {

            let currValue = $(frmInput).val();
            let defaultColor = '#800000';
            let defaultTxtColor = '#ffffff';

            // Destroy the spectrum instance if already initialized
            if ($(selector).data('spectrum')) {
                $(selector).spectrum('destroy');
            }

            if ($(selector).length && currValue === '') {
                // console.log(true);
                $(selector).css('background-color', defaultColor);
                $(frmInput).val(defaultColor);
                $(frmInputText).val(defaultTxtColor);
            }

            // console.log('CURRENT VALUE: ', currValue);

            $(selector).spectrum({
                color: currValue, // Default color
                showPaletteOnly: true, // Only show the palette
                togglePaletteOnly: true, // Show/hide the palette on click
                togglePaletteMoreText: "More Colors", // Optional text
                togglePaletteLessText: "Less Colors", // Optional text
                showInput: true,  // Allow users to type a hex color
                showAlpha: false,  // Allow transparency
                palette: [
                    ['#800000', '#ff0000', '#00ff00', '#0000ff', '#ff00ff', '#00ffff', '#ffff00', '#000000', '#ffffff'],
                ],
                move: function (color) {
                    if (!color || typeof color.toHexString !== 'function') {
                        console.warn('Invalid color detected in move event:', color);
                        return;
                    }


                    // console.log('COLOR CLICKED: ', color.toHexString());
                    var hex = color.toHexString();
                    var r = parseInt(hex.slice(1, 3), 16);
                    var g = parseInt(hex.slice(3, 5), 16);
                    var b = parseInt(hex.slice(5, 7), 16);

                    // var rgb = color.toRgbString();

                    // Calculate brightness (perceived brightness formula)
                    var brightness = (0.2126 * r + 0.7152 * g + 0.0722 * b);
                    var textColor = brightness < 128 ? '#ffffff' : '#000000';

                    // console.log(rgb);
                    // console.log('TEXT COLOR: ', textColor);

                    $(selector).css('background-color', hex);
                    $(selector).val('');
                    $(frmInput).val(hex);
                    $(frmInputText).val(textColor);

                }
            });

            return this;
        },
        resetModal: function () {
            $('[id*="btn"]').hide();
            $('[id*="modal-sched"]').prop('disabled', false);
            $('[id*="modal-sched"]').val('');
            $('#colorPicker').spectrum('destroy');
            $('#scheduleModalLabel').text('');
            $('#btnSaveSchedule').attr('data-id');
            $('#scheduleModal .modal-body .appointments-container').empty();
            $('#scheduleModal').removeClass('schedExecuted');

            return this;
        }
    }

    ScheduleMaster.init.prototype = ScheduleMaster.prototype;

    $(document).ready(function () {
        var _S = ScheduleMaster();

        const prslyFrmSchedule = $('#frmSchedule').parsley();
        _S.drawCalendar();
        _S.renderWidgets();

        const urlParams = new URLSearchParams(window.location.search);
        const focusEl = urlParams.get('focus') ?? '';

        if (focusEl !== '') {
            const $element = $('#' + focusEl);

            $element.addClass('focus-highlight');

            setTimeout(function () {
                $element.removeClass('focus-highlight');
            }, 2000);
        }

        $('.toggle-widget').on('click', function () {
            const $widget = $(this).closest('.float-widget');
            $widget.toggleClass('minimized');

            if ($widget.hasClass('minimized')) {
                $(this).removeClass('fa-square-caret-up').addClass('fa-square-caret-down');
            } else {
                $(this).removeClass('fa-square-caret-down').addClass('fa-square-caret-up');
            }
        });

        $(document).on('click', '.list-group-item', function (e) {
            e.preventDefault();
            let schedID = $(this).attr('data-id');
            let schedTitle = $(this).find('#scheduleName').text().trim();

            const event = {
                event: {
                    id: schedID,
                    title: schedTitle,
                },
            };

            _S.handleEventClick(event);
            setTimeout(function () {
                $('#btnAppointments').trigger('click');

                const $schedModal = $('#scheduleModal');
                const $focusDiv = $('.appointments');

                $schedModal.animate({
                    scrollTop: $schedModal.prop('scrollHeight'),
                }, 1000);

                $focusDiv.addClass('focus-highlight');

                setTimeout(function () {
                    $focusDiv.removeClass('focus-highlight');
                }, 2000);

            }, 1000);
        });

        $('#btnCreateSchedule').click(function (e) {
            e.preventDefault();
            // console.log(frmSchedule.isValid());
            prslyFrmSchedule.isValid() ? _S.createSchedule() : prslyFrmSchedule.validate({ focus: 'first' });
        });

        $('#btnDeleteSchedule').click(function (e) {
            e.preventDefault();
            _S.deleteSchedule();
        });

        $('#btnEditSchedule').click(function (e) {
            e.preventDefault();
            $('#btnEditSchedule').hide();
            $('#btnDeleteSchedule').hide();
            $('#btnAppointments').hide();
            $('#btnSaveSchedule').show();
            $('[id*="modal-sched"]').prop('disabled', false);
            _S.renderColorPicker('#colorPicker', '#modal-schedColor', '#modal-schedTextColor');
            $('#scheduleModalLabel').text('Edit Schedule');
        });

        $(document).on('keydown', function (event) {
            if (event.key === 'Escape' && !isIziToastActive) {
                $('#scheduleModal').modal('hide');
                // deselectRowsAndDisableButtons();
            }
        });

        $('#btnSaveSchedule').click(function (e) {
            e.preventDefault();
            _S.saveScheduleChanges();
        });

        $('#btnAppointments').on('click', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const $icon = $btn.find('i');
            const isAppointmentShow = $('#scheduleModal .modal-body .appointments-container').hasClass('show');

            if (isAppointmentShow) {
                $('#scheduleModal .modal-body .appointments-container').removeClass('show').fadeOut(300, function () {
                    $(this).remove();
                });
                $icon.removeClass('fa-angles-up').addClass('fa-angles-down');
                $('#btnEditSchedule').fadeIn(300);
                $('#btnDeleteSchedule').fadeIn(300);
            } else {
                _S.viewAppointments();
                $icon.removeClass('fa-angles-down').addClass('fa-angles-up');
                $('#btnEditSchedule').fadeOut(300);
                $('#btnDeleteSchedule').fadeOut(300);
            }

        });

        $(document).on('click', '.btnAppointmentAction', function (e) {
            e.preventDefault();
            let appointmentID = $(this).attr('data-id');
            let isAccept = $(this).attr('data-accept') === 'true' ? true : false;

            if (!isAccept) {
                showQuestionToast({
                    message: `Are you sure you want to reject this player?`,
                    onYes: async function (instance, toast) {
                        _S.acceptOrDeclineAppointment(appointmentID, isAccept);
                        return;
                    },
                });
            } else {
                _S.acceptOrDeclineAppointment(appointmentID, isAccept);
            }

        });

        $(document).on('click', '#btnViewReceipt', function (e) {
            e.preventDefault();
            let receiptSrc = $(this).attr('data-src');

            _S.viewReceipt(receiptSrc);
        });

        $(document).on('click', '.close', function (e) {
            e.preventDefault();

            $('.receipt-container').addClass('d-none');
        });

        $('#scheduleModal').on('shown.bs.modal', function () {
            $(this).removeAttr('aria-hidden'); // Remove aria-hidden when the modal is visible
        });
        $('#scheduleModal').on('hidden.bs.modal', function () {
            const $icon = $('#btnAppointments').find('i');
            $('#scheduleModal .modal-body .appointments-container').remove();
            $icon.removeClass('fa-angles-up').addClass('fa-angles-down');
            prslyFrmSchedule.destroy();
            $('.receipt-container').addClass('d-none');
        });

        // Special functions

        $('#modal-schedStartDate').on('change', function () {
            $(this).parsley().validate();  // Force validation
        });

        $('#modal-schedEndDate').on('change', function () {
            $('#modal-schedStartDate').parsley().validate();  // Force validation
        });

        window.Parsley.addValidator('dateorder', {
            validateString: function (value, otherFieldSelector) {
                let startDate = moment(value, 'MMMM D, YYYY - h:mm A');
                let endDate = moment($(otherFieldSelector).val(), 'MMMM D, YYYY - h:mm A');
                console.log(value, otherFieldSelector);
                // console.log(startDate, endDate);
                // console.log('START DATE: ', startDate);
                // console.log('END DATE: ', endDate);
                return startDate.isBefore(endDate, 'minute');
            },
            messages: {
                en: 'Start Date must be before End Date.'
            }
        });

        window.Parsley.addValidator('notsamedate', {
            validateString: function (value, otherFieldSelector) {
                let startDate = moment($(otherFieldSelector).val(), 'MMMM D, YYYY - h:mm A');
                let endDate = moment(value, 'MMMM D, YYYY - h:mm A');
                return !startDate.isSame(endDate, 'minute'); // Dates must not be the same
            },
            messages: {
                en: 'Start Date and End Date cannot be the same.'
            }
        });
    });

})();


