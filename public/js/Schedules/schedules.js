import { ajaxRequest, showToast, showQuestionToast, isIziToastActive, ucfirst } from "../global/global-functions.js";

"use strict";
(function () {
    const Schedules = function () {
        return new Schedules.init();
    }
    Schedules.init = function () {
        this.schedule = {
            // id: '', title: '', venue: '', maxPlayer: '', date: '', time: '',
            // description: '', notes: '', btnJoin: '', btnPreview: '', color: '',
        }
        this.modal = '';
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

            self.schedule = schedules;

            var html = '';

            $.each(schedules, function (i, schedule) {

                const today = moment();
                let startDate = moment(schedule.startDate);
                let endDate = moment(schedule.endDate);

                // Schedule duration
                let eventDuration = moment.duration(endDate.diff(startDate));
                let hourDuration = Math.floor(eventDuration.asHours());
                let minuteDuration = eventDuration.minutes();

                schedule.eventDuration = {
                    hours: hourDuration,
                    minutes: minuteDuration
                };

                // Time left from today 
                let durationToStart = moment.duration(startDate.diff(today));
                let daysToStart = Math.floor(durationToStart.asDays());
                let hoursToStart = durationToStart.hours();
                let minutesToStart = durationToStart.minutes();

                schedule.timeLeftToStart = {
                    days: daysToStart,
                    hours: hoursToStart,
                    minutes: minutesToStart
                };

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
                                                <i class="fa-solid fa-peso-sign text-muted me-2"></i>
                                                <span id='schedDate' class="card-venue regular-text text-muted">${schedule.gameFee}</span>
                                            </div>
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
        renderModal: function (scheduleID) {
            var self = this;

            // AYUSIN DAPAT ANG IAASSIGN SA SELF.SCHEDULE AY YUNG SPECIFIC SCHEDULE NALANG

            self.modal = $('#previewScheduleModal');
            $('#previewScheduleModal .modal-body').empty();

            var html = '';

            console.log(self.schedule);

            var schedule = self.schedule.find(function (schedule) {
                return String(schedule.ID) === String(scheduleID); // Convert both to strings
            });

            let startDate = moment(schedule.startDate);
            let endDate = moment(schedule.endDate);

            let displayDate = startDate.isSame(endDate, 'day') ? startDate.format('MMMM D, YYYY')
                : `${startDate.format('MMMM D, YYYY')} - ${endDate.format('MMMM D, YYYY')}`;

            let displayTime = `${startDate.format('h:mm A')} - ${endDate.format('h:mm A')}`;

            html = `
                    <div class="card-heading border-bottom pb-2">
                        <div class="row">
                            <div class="col-10">
                                <span id="schedID" class="d-none">${schedule.ID}</span>
                                <h3 id='schedTitle' class="card-title mb-0 text-nowrap text-truncate">
                                    ${schedule.title}</h3>
                            </div>
                            <div class="col-2 p-0 d-flex justify-content-end">
                                <span id='schedMaxPlayer'
                                    class="max-players font-xs text-muted regular-text me-2"><span class="semi-bold-text">Max Player: </span> ${schedule.maxPlayer}
                                    <i class="fa-solid fa-people-group fa-1x text-muted"></i></span>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="row ">
                            <div class="col-12 d-flex align-items-center mt-1">
                                <i class="fa-solid fa-peso-sign fa-1x text-muted font-xs me-2"></i>
                                <span id='schedGameFee'class="card-venue regular-text text-muted font-sm"><span class="semi-bold-text">Game Fee: </span>${schedule.gameFee}</span>
                            </div>
                            <div class="col-12 d-flex align-items-center mt-3">
                                <i class="fa-solid fa-location-dot fa-1x text-muted font-xs me-2"></i>
                                <span id='schedVenue'class="card-venue regular-text text-muted font-sm"><span class="semi-bold-text">Venue: </span>${schedule.venue}</span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <i class="fa-solid fa-calendar-day text-muted me-2"></i>
                                <span id='schedDate' class="card-venue regular-text text-muted"><span class="semi-bold-text">Date: </span>${displayDate}</span>
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <i class="fa-solid fa-clock text-muted me-2"></i>   
                                <span id="schedTime" class="card-venue regular-text text-muted"><span class="semi-bold-text">Time: </span>${displayTime}
                                    <span class='semi-bold-text font-xs'>(${schedule.eventDuration.hours} hr/s and
                                        ${schedule.eventDuration.minutes} min/s)</span></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col d-flex">
                                <i class="fa-solid fa-align-left fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                
                                <span id="schedDescription"
                                    class="card-description regular-text text-muted font-sm"><span class="semi-bold-text">Description: </span> ${schedule.description}</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col d-flex">
                                <i class="fa-solid fa-comment-dots fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                <p id="schedNotes" class="card-note regular-text text-muted"><span class="semi-bold-text">Notes: </span>
                                    ${schedule.notes}</p>
                            </div>
                        </div>
                    </div>
                    `;

            $('#previewScheduleModal .modal-body').append(html);

            return self.modal.modal('show');
        },
        joinSchedule: function () {
            var self = this;

            var html = '';

            html = `
                <form id='frmSchedule' class="mt-3" action="<?= base_url('createSchedule') ?>">
                    <input type="text" id="modal-schedID" name="modal-schedID" value="${$('#schedID').text()}" hidden>
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 d-flex flex-column">
                            <label>Schedule Title</label>
                            <input type="text" id="modal-schedTitle" class="form-control" name="modal-schedTitle" required>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 mt-md-0 d-flex flex-column">
                            <label>Venue</label>
                            <input type="text" id="modal-schedVenue" class="form-control" name="modal-schedVenue" required>
                        </div>
                        <div class="col-12 col-md-12 col-xl-12 mt-3 d-flex flex-column">
                            <label>Description</label>
                            <input type="text" id="modal-schedDescription" class="form-control" name="modal-schedDescription">
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>Start Date</label>
                            <div class="input-group">
                                <input type="text" id="modal-schedStartDate" class="form-control datetimepicker" name="modal-schedStartDate" required>
                                <span class="input-group-text" id="calendar-icon"><i class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>End Date</label>
                            <div class="input-group">
                                <input type="text" id="modal-schedEndDate" class="form-control datetimepicker" name="modal-schedEndDate" required>
                                <span class="input-group-text" id="calendar-icon"><i class="fa-solid fa-calendar fa-1x"></i></span>
                            </div>
                        </div>
                        <div class="col-6 d-flex flex-column mt-3">
                            <label>Event Color</label>
                            <div id="colorPicker" class="colorPreview border form-control"></div>
                            <input type="text" class="form-control" id="modal-schedColor" name="modal-schedColor" hidden>
                            <input type="text" class="form-control" id="modal-schedTextColor" name="modal-schedTextColor" hidden>
                        </div>
                        <div class="col-6 col-md-6 col-xl-6 mt-3 d-flex flex-column">
                            <label>Max Players</label>
                            <input type="number" id="modal-schedMaxPlayer" class="form-control" name="modal-schedMaxPlayer" required>
                        </div>
                        <div class="col-12 d-flex flex-column mt-4">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="modal-schedNotes" name="modal-schedNotes" style="height: 100px"></textarea>
                                <label for="modal-schedNotes">Notes</label>
                            </div>
                        </div>
                    </div>
                </form> 
            `;

            $('#previewScheduleModal .modal-body').append(html);

            // $('#previewScheduleModal .modal-body #frmSchedule').addClass('show');
            setTimeout(function () {
                // Trigger the fade-in by adding the 'show' class
                $('#previewScheduleModal .modal-body #frmSchedule').addClass('show');
            }, 10); 

            return this;
        },
    }

    Schedules.init.prototype = Schedules.prototype;

    $(document).ready(function () {
        var _Schedules = Schedules();

        _Schedules.renderSchedules();

        $('.schedules-body').on('click', '#btnPreviewSchedule', function (e) {
            e.preventDefault();
            $('#btnJoinSchedule').show();
            $('#btnSendRequest').hide();
            _Schedules.renderModal($(this).data('id'));
        });
        
        $('#btnJoinSchedule').on('click', function (e) {
            e.preventDefault();
            $('#btnSendRequest').show();
            $(this).hide();
            _Schedules.joinSchedule();
        });

    });

})();