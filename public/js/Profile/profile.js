$(function () { 

    $('#skills-select').select2({
        placeholder: 'Add your skills',
        allowClear: true,
        tags: true,
        maximumSelectionLength: 5,
        tokenSeperators: [',' , ' '],
     
    });
});

