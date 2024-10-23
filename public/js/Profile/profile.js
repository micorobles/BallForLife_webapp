import { ajaxRequest, showToast, ucfirst } from "../global/global-functions.js";

$(function () {

    getProfileData();
    initializeSelect2();

    // Bind event handlers
    $('#btnFrmProfile').on('click', handleEditProfile)
    handleFilePreview('#pictureFile', '#profilePreview');
    handleFilePreview('#coverPhotoFile', '#coverPhotoPreview');

});

function initializeSelect2() {
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
        dropdownParent: $('.modal-skills-input-container'),
        dropdownPosition: 'below' // This can help position it correctly
    });
}

function handleFilePreview(inputSelector, previewSelector) {
    $(inputSelector).change(function (event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $(previewSelector).attr('src', e.target.result); // Set the src for the preview
            }
            reader.readAsDataURL(file); // Read the file as DataURL
        }
    });
}

async function handleEditProfile(e) {
    e.preventDefault();

    // let formData = $('#frmProfile').serializeArray();
    let formData = new FormData($('#frmProfile')[0]); // Use the first element of the jQuery object
    // console.log(formData);

    // Log the form data for debugging
    // for (let [key, value] of formData.entries()) {
    //     console.log(key, value);
    // }

    const url = $('#frmProfile').attr('action');
    const editUser = await ajaxRequest('POST', url, formData, {
        contentType: false,
        processData: false,
    });


    try {

        if (!editUser.success) {
            showToast('error', 'Error: ', editUser.message);
            return;
        }

        // location.reload();
        getProfileData();
        showToast('success', '', editUser.message);
        // console.log(editUser);

        $('#staticBackdrop').modal('hide');

    } catch (error) {
        // Handle any errors that occurred during the AJAX request
        showToast('error', 'Error: ', 'An error occurred while processing your request.');
        console.error('Errors: ', error);
        $('#staticBackdrop').modal('hide');
    }
}

async function getProfileData() {

    const getUserData = await ajaxRequest('GET', getUserURL, '');
    const user = getUserData.data;
    
    if (!getUserData.success) {
        console.error('Error: ', getUserData.message);
        return;
    }

    populateData(user);
    
    
}

function populateData(user) {
    const skillsArray = JSON.parse(user.skills) ?? '';
    
    // console.log(user.profilePic);
    // Clear existing options
    $('#skills-select').empty();
    $('#modal-skills-select').empty();

    const allSkills = [
        'Dribbling', 'Shooting', 'Passing', 'Defense', 'Rebounding', 'Footwork',
        'Ball-Handling', 'Jumping', 'Teamwork', 'Perimeter', 'Low Post', 'Pullups',
        'Coast2Coast'
    ];

    allSkills.forEach(function (skill) {
        const selected = skillsArray.includes(skill) ? 'selected' : '';
        $('#skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
        $('#modal-skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
    });

    $('#coverPhoto').attr('src', baseURL + user.coverPhoto);
    $('#coverPhotoPreview').attr('src', baseURL + user.coverPhoto);
    $('#profilePic').attr('src', baseURL + user.profilePic);
    $('#profilePreview').attr('src', baseURL + user.profilePic);
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

    // Populate header changes
    $('#header-profilePic').attr('src', baseURL + user.profilePic);
    $('#header-fullName').text(ucfirst(user.firstname) + ' ' + ucfirst(user.lastname));

    // Populate sidebar changes
    $('#sidebar-profilePic').attr('src', baseURL + user.profilePic);
    $('#username').text(ucfirst(user.firstname) + ' ' + ucfirst(user.lastname));
    $('#position').text(ucfirst(user.position));

}
