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

                    // console.log(fetchInfo);
                    // console.log(getAllEvents);
                },
                eventClick: async function (event) {
                    // console.log(event);

                    self.eventID = event.event.id;
                    self.eventTitle = event.event.title;

                    const getSingleEvent = await ajaxRequest('GET', baseURL + `/getSingleSchedule/${self.eventID}`);

                    if (!getSingleEvent) {
                        showToast('error', 'Error: ', getSingleEvent.message);
                    }

                    self.resetModal();
                    self.scheduleModal.modal('show');
                    $('#btnEditSchedule').show();
                    $('#btnDeleteSchedule').show();
                    $('#scheduleModalLabel').text('View Schedule');
                    // $('#btnSaveSchedule').attr('data-id', event.event.id);

                    $.each(getSingleEvent.data, function (key, value) {

                        let id = `#modal-sched${ucfirst(key)}`;

                        if (key === 'startDate' || key === 'endDate') {
                            value = moment(value).format('MMMM D, YYYY - h:mm A');
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

                },
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

                    info.isEnd ? info.el.classList.add('event-ended') : '';
                    info.isPast ? info.el.classList.add('event-past') : '';

                },
                eventContent: function (arg) {
                    // console.log('ARG: ', arg);

                    const today = moment();
                    const startDate = moment(arg.event.startStr);
                    const endDate = moment(arg.event.endStr);


                    // Check if the event's start and end dates are valid
                    if (!startDate.isValid() || !endDate.isValid()) {
                        console.error("Invalid dates");
                        return;
                    }
                    // Initialize event status properties
                    arg.isFuture = startDate.isAfter(today, 'day');
                    arg.isToday = startDate.isSame(today, 'day');
                    arg.isStart = arg.isToday && startDate.isSameOrBefore(today, 'minute');
                    arg.isEnd = arg.isToday && endDate.isSameOrBefore(today, 'minute');
                    arg.isPast = !arg.isToday && !arg.isFuture && endDate.isBefore(today);

                    var startTime = moment(arg.event.start).format('ha'); // Format the time to '2pm' format

                    var eventTitle = `<span><i><strong>${startTime}</strong></i> ${arg.event.title}</span>`;

                    return {
                        html: eventTitle
                    };
                },

            });

            calendar.render();
            return calendar;
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

            return this;
        }
    }

    ScheduleMaster.init.prototype = ScheduleMaster.prototype;

    $(document).ready(function () {
        var _Schedule = ScheduleMaster();

        _Schedule.drawCalendar();

        $('#btnCreateSchedule').click(function (e) {
            e.preventDefault();
            _Schedule.createSchedule();
        });

        $('#btnDeleteSchedule').click(function (e) {
            e.preventDefault();
            _Schedule.deleteSchedule();
        });

        $('#btnEditSchedule').click(function (e) {
            e.preventDefault();
            $('#btnEditSchedule').hide();
            $('#btnDeleteSchedule').hide();
            $('#btnSaveSchedule').show();
            $('[id*="modal-sched"]').prop('disabled', false);
            _Schedule.renderColorPicker('#colorPicker', '#modal-schedColor', '#modal-schedTextColor');
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
            _Schedule.saveScheduleChanges();
        });

        $('#scheduleModal').on('shown.bs.modal', function () {
            $(this).removeAttr('aria-hidden'); // Remove aria-hidden when the modal is visible
        });

    });

})();


