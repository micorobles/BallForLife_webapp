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
    }
    ScheduleMaster.prototype = {
        drawCalendar: function () {
            var self = this;

            const calendar = new FullCalendar.Calendar(self.calendar, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                editable: true,
                selectable: true,
                validRange: {
                    start: moment().format('YYYY-MM-DD') // Disable all past dates
                },
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
                select: function (start, end) {
                    self.resetModal();
                    self.scheduleModal.modal('show');
                    // $('#btnEditSchedule, #btnSaveSchedule').hide();
                    $('#btnCreateSchedule').show();
                    $('#scheduleModalLabel').text('Create Schedule');
                },
                dateClick: function (info) {
                    var datetimeClicked = moment(info.dateStr).format('MMMM D, YYYY - h:mm A');

                    var startDateID = '#modal-schedStartDate';
                    var endDateID = '#modal-schedEndDate';

                    $(startDateID).val(datetimeClicked);
                    $(endDateID).val(datetimeClicked);

                    self.renderDateTimePicker(datetimeClicked, [startDateID, endDateID]);
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
                    console.log(event);

                    const getSingleEvent = await ajaxRequest('GET', baseURL + `/getSingleSchedule/${event.event.id}`);

                    if (!getSingleEvent) {
                        showToast('error', 'Error: ', getSingleEvent.message);
                    }

                    self.resetModal();
                    self.scheduleModal.modal('show');
                    $('#btnEditSchedule').show();
                    $('#scheduleModalLabel').text('View Schedule');
                    $('#btnSaveSchedule').attr('data-id', event.event.id);

                    $.each(getSingleEvent.data, function (key, value) {
                        
                        let id = `#modal-sched${ucfirst(key)}`;

                        if (key === 'startDate' || key === 'endDate') {
                            value = moment(value).format('MMMM D, YYYY - h:mm A');
                            self.renderDateTimePicker(value, id);
                        }
                        
                        $(id).val(value);
                        $(id).prop('disabled', true);

                        // console.log(key, ' : ', value); 
                        // console.log(id, ' : ', value); 
                    });

                },
                eventDrop: function (event) {
                    // FUNCTION TO UPDATE WHEN EVENT IS MOVED
                    console.log(event);
                }

                // eventContent: function(arg) {
                //     // Get the start time
                //     var startTime = moment(arg.event.start).format('ha'); // Format the time to '2pm' format

                //     // Modify the event title
                //     var eventTitle = `${startTime} ${arg.event.title}`;

                //     console.log(arg);
                //     return {
                //         html: eventTitle
                //     };
                // },

            });

            calendar.render();
            return calendar;
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
        saveScheduleChanges: function (schedID) {
            var self = this;

            const formData = new FormData(self.scheduleForm[0]);
            console.log(schedID);

            $.each(self.datetimePickers, function (i, selector) {
                var key = selector.replace('#', '');
                var value = moment($(selector).val(), 'MMMM D, YYYY - h:mm A').format('YYYY-MM-DD HH:mm:ss');

                formData.set(key, value);
            });

            showQuestionToast({
                message: `Are you sure you want to update ${formData.get('modal-schedTitle')}?`,
                onYes: async function (instance, toast) {
                    const saveSchedule = await ajaxRequest('POST', baseURL + `/editSchedule/${schedID}`, formData, {
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
                    self.drawCalendar().getEvents();
                },
            });

            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            return this;
        },
        resetModal: function () {
            $('[id*="btn"]').hide();
            $('[id*="modal-sched"]').prop('disabled', false);
            $('[id*="modal-sched"]').val('');
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

        $('#btnEditSchedule').click(function (e) {
            e.preventDefault();
            $('#btnEditSchedule').hide();
            $('#btnSaveSchedule').show();
            $('[id*="modal-sched"]').prop('disabled', false);
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
            var schedID = $(this).attr('data-id');
            _Schedule.saveScheduleChanges(schedID);
        });

        // $(_Schedule.scheduleModal).on('hidden.bs.modal', function () {
        //     $('#modal-schedStart').val('').trigger('change');
        //     $('#modal-schedEnd').val('').trigger('change');
        // });
    });

})();


