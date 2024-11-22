import { ajaxRequest, showToast, showQuestionToast, isIziToastActive, ucfirst } from "../global/global-functions.js";

"use strict";
(function () {
    const Schedules = function () {
        return new Schedules.init();
    }
    Schedules.init = function () {
        this.schedule = {
            id: '', title: '', venue: '', maxPlayer: '', date: '', time: '',
            description: '', notes: '', btnJoin: '', btnPreview: '', color: '',
        }
    }
    Schedules.prototype = {
        renderSchedules: async function () {
            var self = this;

            const getAllSchedule = await ajaxRequest('GET', baseURL + 'getAllScheduleToUsers');

            if (!getAllSchedule.success) {
                showToast('error', 'Error: ', getAllSchedule.message);
                return console.error(getAllSchedule.message);
            }

            self.renderScheduleCard(getAllSchedule.data);

            return this;
        },
        renderScheduleCard: function (schedules) {
            var self = this;

            var html = '';

            $.each(schedules, function (i, schedule) {

                const today = moment();
                let startDate = moment(schedule.startDate);
                let endDate = moment(schedule.endDate);

                // Schedule duration
                let eventDuration = moment.duration(endDate.diff(startDate));
                let hourDuration = Math.floor(eventDuration.asHours());
                let minuteDuration = eventDuration.minutes();

                // Time left from today 
                let durationToStart = moment.duration(startDate.diff(today));
                let daysToStart = Math.floor(durationToStart.asDays());
                let hoursToStart = durationToStart.hours();
                let minutesToStart = durationToStart.minutes();

                if (today.isBetween(startDate, endDate, 'hour', []) || startDate.isBefore(today, 'day')) {
                    return;
                }

                let displayDate = startDate.isSame(endDate, 'day') ? startDate.format('MMMM D, YYYY')
                    : `${startDate.format('MMMM D, YYYY')} - ${endDate.format('MMMM D, YYYY')}`;

                let displayTime = `${startDate.format('h:mm A')} - ${endDate.format('h:mm A')}`;

                html = `
                        <div class="col-12 mt-4 col-lg-6 col-xxl-4">
                            <div id="scheduleCard" class="card" style="border-top: 3px solid ${schedule.color}">
                                <div class="card-body">
                                    <div class="card-heading border-bottom pb-2">
                                        <div class="row">
                                            <div class="col-10">
                                                <h3 id='schedTitle' class="card-title mb-0 text-nowrap text-truncate">${schedule.title}</h3>
                                            </div>
                                            <div class="col-2 p-0 d-flex justify-content-end">
                                                <span id='schedMaxPlayer' class="max-players font-xs text-muted regular-text me-2">${schedule.maxPlayer} <i class="fa-solid fa-people-group fa-1x text-muted"></i></span>
                                            </div>
                                            <div class="col-12 d-flex align-items-center mt-1">
                                                <i class="fa-solid fa-location-dot fa-1x text-muted font-xs me-2"></i>
                                                <span id='schedVenue' class="card-venue semi-bold-text text-muted font-xs">${schedule.venue}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="row ">
                                            <div class="col-12 mt-2 d-flex align-items-center">
                                                <i class="fa-solid fa-calendar-day text-muted me-2"></i>
                                                <span id='schedDate' class="card-venue regular-text text-muted">${displayDate}</span>
                                            </div>
                                            <div class="col-12 mt-2 d-flex align-items-center">
                                                <i class="fa-solid fa-clock text-muted me-2"></i>
                                                <span id="schedTime" class="card-venue regular-text text-muted">${displayTime} <span class='semi-bold-text font-xs'>(${hourDuration} hr/s and ${minuteDuration} min/s)</span></span>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col d-flex">
                                                <i class="fa-solid fa-align-left fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                                <span id="schedDescription" class="card-description regular-text text-muted font-sm text-truncate">${schedule.description}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col d-flex">
                                                <i class="fa-solid fa-comment-dots fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                                <p id="schedNotes" class="card-note medium-text text-muted text-truncate">${schedule.notes}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footerr border-top d-flex justify-content-center gap-2">
                                    <span class='card-timer semi-bold-text font-xs'>${daysToStart} day/s and ${hoursToStart} hr/s and ${minutesToStart} min/s remaining</span>
                                        <button id="btnPreviewSchedule" class="btn btn-md btn-custom-color w-100 text-white font-sm light-text" data-id="${schedule.ID}"> Preview <i class="fa-solid fa-arrow-right-to-bracket ms-1 fa-1x"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        `;

                $('.schedules-body > .row').append(html);
            });

            return this;
        },
        
    }

    Schedules.init.prototype = Schedules.prototype;

    $(document).ready(function () {
        var _Schedules = Schedules();

        _Schedules.renderSchedules();

        $('.schedules-body').on('click', '#btnPreviewSchedule', function (e) {
            e.preventDefault();
            // Log the schedule ID for debugging
            console.log('Button clicked:', $(this).data('id'));
            // Show the modal
            $('#previewScheduleModal').modal('show');
        });
    });

})();