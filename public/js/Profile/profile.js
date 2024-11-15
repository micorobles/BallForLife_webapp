import {
    ajaxRequest, showToast, ucfirst, setTextIfExists, setValueIfExists, setSrcIfExists,
    clearSelectIfExists, addOptionsIfExists
} from "../global/global-functions.js";

const currentURL = window.location.pathname;
const userID = currentURL.split('/').pop();

$(function () {


    if (currentURL.includes('profile/')) {
        console.log(userID);
        getProfileData(userID);
    }
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
    }).catch(function (error) {
        console.error("AJAX error response:", error.responseText); // Log the response from the server
        throw error;  // Rethrow the error after logging
    });


    try {

        if (!editUser.success) {
            showToast('error', 'Error: ', editUser.message);
            return;
        }

        // location.reload();
        getProfileData(userID);
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

export async function getProfileData(userID) {

    const getUserData = await ajaxRequest('GET', getUserURL + userID, '');
    const user = getUserData.data;

    if (!getUserData.success) {
        console.error('Error: ', getUserData.message);
        return;
    }

    populateData(user);


}

function populateData(user) {
    console.log(user);
    // const skillsArray = JSON.parse(user.skills) ?? '';
    const skillsArray = Array.isArray(user.skills) ? user.skills : JSON.parse(user.skills || '[]');

    let profilePicUrl = user.profilePic;

    if (profilePicUrl && !/^https?:\/\//i.test(profilePicUrl)) {
        // If it's a relative URL, prepend the baseURL
        profilePicUrl = baseURL + profilePicUrl;
    }

    

    // Clear existing options
    // $('#skills-select').empty();
    // $('#modal-skills-select').empty();
    clearSelectIfExists('#skills-select');
    clearSelectIfExists('#modal-skills-select');

    const allSkills = [
        'Dribbling', 'Shooting', 'Passing', 'Defense', 'Rebounding', 'Footwork',
        'Ball-Handling', 'Jumping', 'Teamwork', 'Perimeter', 'Low Post', 'Pullups',
        'Coast2Coast'
    ];

    addOptionsIfExists('#skills-select', allSkills, skillsArray);
    addOptionsIfExists('#modal-skills-select', allSkills, skillsArray);
    // allSkills.forEach(function (skill) {
    //     const selected = skillsArray.includes(skill) ? 'selected' : '';
    //     $('#skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
    //     $('#modal-skills-select').append(`<option value="${skill}" ${selected}>${skill}</option>`);
    // });

    setSrcIfExists('#coverPhoto', baseURL + user.coverPhoto);
    setSrcIfExists('#coverPhotoPreview', baseURL + user.coverPhoto);
    setSrcIfExists('#profilePic', profilePicUrl);
    setSrcIfExists('#profilePreview', profilePicUrl);
    // $('#coverPhoto').attr('src', baseURL + user.coverPhoto);
    // $('#coverPhotoPreview').attr('src', baseURL + user.coverPhoto);
    // $('#profilePic').attr('src', baseURL + user.profilePic);
    // $('#profilePreview').attr('src', baseURL + user.profilePic);

    setTextIfExists('#txtStatus', ucfirst(user.status));
    // $('#txtStatus').text(ucfirst(user.status));

    let container = $('.status-text');

    if (container.length) {
        $(container).removeClass('bg-success bg-warning bg-danger bg-secondary');
        switch (user.status) {
            case 'Active':
                $(container).css('background-color', '#198754');
                break;
            case 'Inactive':
                $(container).css('background-color', '#ffc107');
                break;
            case 'Ban':
                $(container).css('background-color', '#dc3545');
                break;
            case 'Pending':
                $(container).css('background-color', '#0dcaf0');
                break;
            default:
                $(container).css('background-color', '');
        }
    }

    setTextIfExists('#firstname', ucfirst(user.firstname));
    setValueIfExists('#modal-firstname', ucfirst(user.firstname));
    // $('#firstname').text(ucfirst(user.firstname));
    // $('#modal-firstname').val(ucfirst(user.firstname));

    setTextIfExists('#lastname', ucfirst(user.lastname));
    setValueIfExists('#modal-lastname', ucfirst(user.lastname));
    // $('#lastname').text(ucfirst(user.lastname));
    // $('#modal-lastname').val(ucfirst(user.lastname));

    setTextIfExists('#contactNum', user.contactnum);
    setValueIfExists('#modal-contactNum', user.contactnum);
    // $('#contactNum').text(user.contactnum);
    // $('#modal-contactNum').val(user.contactnum);

    setTextIfExists('#email', user.email);
    setValueIfExists('#modal-email', user.email);
    // $('#email').text(user.email);
    // $('#modal-email').val(user.email);

    setTextIfExists('#_position', ucfirst(user.position));
    setValueIfExists('#modal-position', ucfirst(user.position));
    // $('#_position').text(ucfirst(user.position));
    // $('#modal-position').val(ucfirst(user.position));

    setTextIfExists('#height', `${user.heightFeet ?? 0}'${user.heightInch ?? 0}`);
    setValueIfExists('#modal-heightFeet', user.heightFeet);
    setValueIfExists('#modal-heightInch', user.heightInch);
    // $('#height').text(user.heightFeet + "'" + user.heightInch);
    // $('#modal-heightFeet').val(user.heightFeet);
    // $('#modal-heightInch').val(user.heightInch);

    setTextIfExists('#weight', `${user.weight ?? 0} lbs`);
    setValueIfExists('#modal-weight', user.weight);
    // $('#weight').text(user.weight + ' lbs');
    // $('#modal-weight').val(user.weight);

    if (currentURL.includes('profile/')) {
        // Populate header changes
        $('#header-profilePic').attr('src', profilePicUrl);
        $('#header-fullName').text(ucfirst(user.firstname) + ' ' + ucfirst(user.lastname));

        // Populate sidebar changes
        $('#sidebar-profilePic').attr('src', profilePicUrl);
        $('#username').text(ucfirst(user.firstname) + ' ' + ucfirst(user.lastname));
        $('#position').text(ucfirst(user.position));
    }

}
