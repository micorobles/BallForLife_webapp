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
        this.calendar = document.getElementById('calendar');
        this.datetimePickers = ['#modal-schedStartDate', '#modal-schedEndDate'];
        this.createScheduleModal = $('#createSchedModal');
        this.createScheduleForm = $('#frmCreateSchedule');
        this.createScheduleURL = baseURL + '/createSchedule'; 
        this.getAllScheduleURL = baseURL + '/getAllSchedule'; 
    }
    ScheduleMaster.prototype = {
        drawCalendar: function () {
            var self = this;

            const calendar = new FullCalendar.Calendar(self.calendar, {
                initialView: 'dayGridMonth',
                timeZone: 'local',
                editable: true,
                selectable: true,
                headerToolbar: {
                    right: 'prev,today,next',
                    center: 'title',
                    left: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                select: function (start, end) {
                    self.createScheduleModal.modal('show');
                },
                dateClick: function (info) {
                    var datetimeClicked = moment(info.dateStr).format('MMMM D, YYYY - h:mm A');

                    $('#modal-schedStart').val(datetimeClicked);
                    $('#modal-schedEnd').val(datetimeClicked);
                    self.renderDateTimePicker(datetimeClicked);

                },
                events: async function (fetchInfo, successCallback, failureCallback) {
                    const getAllSchedule = await ajaxRequest('GET', self.getAllScheduleURL, '');
                    
                    if (!getAllSchedule) {
                        showToast('error', 'Error: ', getAllSchedule.message);
                        failureCallback(getAllSchedule.message);
                    }
                    
                    successCallback(getAllSchedule.data);

                    console.log(fetchInfo);

                }
                
                // events: [
                //     {
                //         id: '',
                //         title: 'Event 1',
                //         start: '2024-11-20',
                //         description: 'Some event description here'
                //     },
                //     {
                //         title: 'Event 2',
                //         start: '2024-11-21',
                //         end: '2024-11-22',
                //         description: 'Another event'
                //     }
                // ]

            });

            return calendar.render();
        },
        renderDateTimePicker: function (datetimeClicked) {
            var self = this;

            self.datetimePickers.forEach(function (selector) {

                new tempusDominus.TempusDominus(document.querySelector(selector), {
                    defaultDate: moment(datetimeClicked, 'MMMM D, YYYY - h:mm A').toDate(),
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

            const formData = new FormData(self.createScheduleForm[0]);

            $.each(self.datetimePickers, function(i, selector) {
                var key = selector.replace('#', '');
                var value = moment($(selector).val(), 'MMMM D, YYYY - h:mm A').format('YYYY-MM-DD HH:mm:ss');
                
                formData.set(key, value);
            });

            showQuestionToast({
                message: `Are you sure you want to create schedule for ${formData.get('modal-schedTitle')}?`,
                onYes: async function (instance, toast) {
                    const createSchedule = await ajaxRequest('POST', self.createScheduleURL, formData, {
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
                    self.createScheduleModal.modal('hide');
                },
            });

            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }
            
            return this;
        },
    }

    ScheduleMaster.init.prototype = ScheduleMaster.prototype;

    $(document).ready(function () {
        var _Schedule = ScheduleMaster();

        _Schedule.drawCalendar();

        $('#btnCreateSchedule').click(function(e) {
            e.preventDefault();
            _Schedule.createSchedule();
        });
    });

})();


