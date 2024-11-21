"use strict";

$(function () {
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
        renderSchedules: function () {
            var self = this;

            
            
            return this;
        },
    }

    $(document).ready(function () {
        var _Schedules = Schedules();

        _Schedules.renderSchedules();
    });

});