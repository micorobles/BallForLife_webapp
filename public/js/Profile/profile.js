$(function () {

    $('#skills-select-display').select2({
        placeholder: 'Add your skills',
        tokenSeperators: [',', ' '],

    });

    $('#skills-select').select2({
        placeholder: "Select skills",
        tags: true,
        tokenSeperators: [',', ' '],
        maximumSelectionLength: 5,
        allowClear: true,
        dropdownParent: $('#staticBackdrop'),
    });

    $('#btnFrmProfile').on('click', function() {

        // console.log('submitted');
        let formData = $('#frmProfile').serializeArray();
        console.log($('#weight').val());
    });

});

