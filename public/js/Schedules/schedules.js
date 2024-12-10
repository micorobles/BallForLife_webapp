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
        };
        this.modal = '';
        this.dropZone = '';
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
            
            console.log(schedules);
            
            self.schedule = schedules;
            
            $('.schedules-body > .row').empty();
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

                let bookingStatus = schedule.bookingStatus ?? '';

                let statusClass = '';
                let statusIconClass = '';

                switch (bookingStatus) {
                    case 'Pending':
                        statusClass = 'text-black border-dark';
                        statusIconClass = 'fa-hourglass-half';
                        break;
                    case 'Joined':
                        statusClass = 'text-success border-success';
                        statusIconClass = 'fa-person-circle-check';
                        break;
                    case 'Rejected':
                        statusClass = 'text-danger border-danger';
                        statusIconClass = 'fa-xmark-circle';
                        break;
                }
                // let displayStatus = `${schedule.bookingStatus}` 

                html = `
                        <div class="col-12 mt-4 col-lg-6 col-xxl-4">
                            <div id="scheduleCard" class="card" style="border-top: 3px solid ${schedule.color}">
                                <div class="card-body">
                                    <div class="card-heading border-bottom pb-2">
                                        <div class="row">
                                            <div class="col-10">
                                                <h3 id='schedTitle' class="card-title mb-0 text-nowrap custom-text-truncate">${schedule.title}</h3>
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
                                                <span id="schedDescription" class="card-description regular-text text-muted font-sm custom-text-truncate">${schedule.description}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col d-flex">
                                                <i class="fa-solid fa-comment-dots fa-1x text-muted me-2" style="margin-top: 5px;"></i>
                                                <p id="schedNotes" class="card-note medium-text text-muted custom-text-truncate">${schedule.notes}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footerr border-top d-flex justify-content-center gap-2">
                                    <span class='card-timer semi-bold-text font-xs'>${daysToStart} day/s and ${hoursToStart} hr/s and ${minutesToStart} min/s remaining</span>
                                        <div id="bookingStatus" class="w-100 font-sm regular-text ${statusClass}"> ${bookingStatus} <i id="bookingStatusIcon" class="fa-solid ${statusIconClass} ms-1 fa-1x"></i></div>
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

            let bookingReceipt = schedule.bookingReceipt ?? '';
            let receiptName = bookingReceipt.substring(bookingReceipt.lastIndexOf('/') + 1);

            html = `
                    <div class="card-heading border-bottom pb-2">
                        <div class="row">
                            <div class="col-10">
                                <span id="schedID" class="d-none">${schedule.ID}</span>
                                <h3 id='schedTitle' class="card-title mb-0 text-nowrap custom-text-truncate">
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
                        </div>`;

            if (schedule.bookingID > 0) {
                $('#btnJoinSchedule').hide();
                html += `
                        <div class="mt-3 d-flex flex-column">    
                            <label class="font-md text-muted " >Payment Receipt</label>
                            <div class="imageReceipt mt-3 d-flex flex-column align-items-center">
                                <img id="imgReceipt" src="${baseURL + schedule.bookingReceipt}" alt="" style="width: 100px; height: 100px;">
                                <span id="" class="ms-2 mt-2 font-sm">${receiptName}</span>
                            </div>
                        </div>
                        `;
            }

            html += `
                    </div>
                    `;

            $('#previewScheduleModal .modal-body').append(html);

            return self.modal.modal('show');
        },
        joinSchedule: function () {
            var self = this;

            var html = '';

            html = `
                <label class="font-md text-muted mt-3" >Payment Receipt</label>
                <div class="container gcash-container d-flex justify-content-center align-items-center mt-2">
                    <h3>Gcash:</h3>
                    <div class="d-block ms-3 text-center">
                        <span class="gcashName font-md regular-text">LY.A EU...E J.</span><br>
                        <span class="gcashNum font-md">09230853051</span>
                    </div>
                </div>
                <form id='frmBookSchedule' class="mt-3 dropzone" action="<?= base_url('') ?> ">
                    <i id="uploadIcon" class="fa-solid fa-circle-plus fa-3x"></i>
                    <input type="text" id="booking-schedID" name="booking-schedID" value="${$('#schedID').text()}" hidden>
                    <div id="preview-container"></div>
                </form> 
                `;

            $('#previewScheduleModal .modal-body').append(html);
            self.renderDropZone();

            // $('#previewScheduleModal .modal-body #frmSchedule').addClass('show');
            setTimeout(function () {
                // Trigger the fade-in by adding the 'show' class
                $('#previewScheduleModal .modal-body #frmSchedule').addClass('show');
            }, 10);

            return this;
        },
        renderDropZone: function () {
            var self = this;

            Dropzone.autoDiscover = false;
            self.dropZone = new Dropzone("#frmBookSchedule", {
                url: "/upload", // Backend URL for file upload
                maxFiles: 1, // Maximum number of files
                maxFilesize: 2, // Maximum file size in MB
                acceptedFiles: ".jpg,.jpeg,.png,.gif", // Accepted file types
                uploadMultiple: false,
                autoProcessQueue: false,
                addRemoveLinks: true, // Add links to remove uploaded files
                dictRemoveFile: '<i class="fa-solid fa-circle-minus fa-2x mt-2"></i>',
                dictDefaultMessage: "Drag and drop receipt here or click to upload", // Custom message
                previewsContainer: "#preview-container",
            });

            self.dropZone.on('addedfile', function (file) {
                console.log('FILE: ', file);
                $('#uploadIcon').hide();
                setTimeout(function () {
                    // Simulate file upload completion (this won't actually upload)
                    file.status = Dropzone.SUCCESS;
                    self.dropZone.emit("complete", file); // Manually trigger the complete event
                }, 1000);
            });

            self.dropZone.on('removedfile', function (file) {
                if (self.dropZone.files.length === 0) {
                    // Show the icon when no files are present
                    $("#uploadIcon").show();
                }
            });

            // self.dropZone.on("queuecomplete", function() {
            //     console.log("All files have been uploaded.");
            // });

            self.dropZone.on("maxfilesexceeded", function (file) {
                // alert("You can only upload one file!");
                showToast('warning', 'Warning: ', 'You can only upload one file!');
                self.dropZone.removeFile(file); // Automatically remove the new file
            });

            console.log(self.dropZone);

            return this;
        },
        bookSchedule: async function () {
            var self = this;

            let dropZone = self.dropZone;
            let schedID = $('#schedID').text().trim() ?? 0;

            if (dropZone.files.length === 0) {
                showToast('error', 'Error: ', 'Please upload your receipt before submitting');
                return;
            }

            dropZone = dropZone.files[0];

            if (dropZone.status !== Dropzone.SUCCESS) {
                showToast('warning', 'Warning: ', 'Please wait for the receipt to complete uploading');
                return;
            }


            var formData = new FormData($('#frmBookSchedule')[0]);
            formData.append('booking-receipt', dropZone);

            // for (let [key, value] of formData.entries()) {
            //     console.log(key + ': ' + value);
            // }

            const bookSchedule = await ajaxRequest('POST', baseURL + '/bookSchedule', formData, {
                contentType: false,
                processData: false,
            }).catch(function (error) {
                console.error("AJAX error response:", error.responseText);
                throw error;
            });

            if (!bookSchedule.success) {
                showToast('error', 'Error: ', bookSchedule.message);
            }

            showToast('success', 'Success: ', bookSchedule.message);
            self.renderSchedules();
            self.modal.modal('hide');

            return this;
        }
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

        $('#btnSendRequest').on('click', function (e) {
            e.preventDefault();
            _Schedules.bookSchedule();
        });

       $(document).on('click', '#imgReceipt', function () {
            console.log('clicked');
            $(this).css('transform', 'scale(4)');
       });

       $(document).on('click', function (e) {
        if (
            !$(e.target).closest('#imgReceipt').length
           
        ) {
            $('#imgReceipt').css('transform', 'scale(1)');
        }
    });

    });

})();