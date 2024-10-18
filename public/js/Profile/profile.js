$(function () { 

    $('#skills-select-display').select2({
        placeholder: 'Add your skills',
        allowClear: true,
        tags: true,
        maximumSelectionLength: 5,
        tokenSeperators: [',' , ' '],
     
    });

    $('#staticBackdrop').on('shown.bs.modal', function() {
        $('#skills-select').select2({
            placeholder: "Select skills",
            allowClear: true
        });
    });
});

