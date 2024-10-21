import { ajaxRequest, showToast, ucfirst } from "../global/global-functions.js";

$(function () {

    getProfileData();

    $('#skills-select').select2({
        placeholder: 'Add your skills',
        tokenSeperators: [',', ' '],

    });

    $('#modal-skills-select').select2({
        placeholder: "Select skills",
        tags: true,
        tokenSeperators: [',', ' '],
        maximumSelectionLength: 5,
        allowClear: true,
        dropdownParent: $('#staticBackdrop'),
    });

    $('#btnFrmProfile').on('click', handleEditProfile)
});

async function handleEditProfile(e) {
    e.preventDefault();

    let formData = $('#frmProfile').serialize();

    const url = $('#frmProfile').attr('action');
    const editUser = await ajaxRequest('POST', url, formData);

    try {

        if (!editUser.success) {
            showToast('error', 'Error: ', editUser.message);
            return;
        }

        // location.reload();
        getProfileData();
        showToast('success', '', editUser.message);
        console.log(editUser);

        $('#staticBackdrop').modal('hide');

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request.');
        console.error('Errors: ', error);
        $('#staticBackdrop').modal('hide');
    }
}

async function getProfileData() {

    // console.log('URL:', getUserURL);
    const getUserData = await ajaxRequest('GET', getUserURL, '');
    const user = getUserData.data;
    
    if (!getUserData.success) {
        console.error('Error: ', getUserData.message);
        return;
    }

    // console.log(user.position);
    
    var skillsArray = JSON.parse(user.skills);
    
    // console.log(skillsArray);

    // Clear existing options
    $('#skills-select').empty();
    $('#modal-skills-select').empty();

    const allSkills = [
        'Dribbling', 'Shooting', 'Passing', 'Defense', 'Rebounding', 'Footwork',
        'Ball-Handling', 'Jumping', 'Teamwork', 'Perimeter', 'Low Post', 'Pullups',
        'Coast2Coast'
    ];

    $('#firstname').text(ucfirst(user.firstname));
    $('#modal-firstname').val(ucfirst(user.firstname));
    $('#lastname').text(ucfirst(user.lastname));
    $('#modal-lastname').val(ucfirst(user.lastname));
    $('#contactNum').text(user.contactnum);
    $('#modal-contactNum').val(user.contactnum);
    $('#email').text(user.email);
    $('#modal-email').val(user.email);
    $('#_position').text(ucfirst(user.position));
    $('#modal-position').val(ucfirst(user.position));
    $('#height').text(user.heightFeet + "'" + user.heightInch);
    $('#weight').text(user.weight + ' lbs');
    $('#modal-heightFeet').val(user.heightFeet);
    $('#modal-heightInch').val(user.heightInch);
    $('#modal-weight').val(user.weight);

    allSkills.forEach(function (skill) {
        const selected = skillsArray.includes(skill) ? 'selected' : '';
        $('#skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
        $('#modal-skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
    });
}

