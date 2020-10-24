(function(){


    $(document).ready(function () {

        setUpAjax();
        $(document).on('click', 'nav[role="navigation"] a', navigate);
        $(document).on('hide.bs.modal', '#editEmployeeModal', removeErrorMessagesOnEdit);
        $(document).on('hide.bs.modal', '#createEmployeeModal', removeErrorMessagesOnCreate);
        $(document).on('click', '.show-employee', showEmployeeData);
        $(document).on('click', '.store-employee', storeEmployeeData);
        $(document).on('change', '.create-avatar-file', onCreateImagePreview);
        $(document).on('change', '.edit-avatar-file', onEditImagePreview);
        $(document).on('click', '.edit-employee', editEmployeeData); 
        $(document).on('click', '.update-employee', updateEmployeeData);
        $(document).on('click', '.destroy-employee', destroyEmployeeData);
        $(document).on('keyup', '.search-employee', searchEmployee);

    });


// AJAX SETUP

function setUpAjax () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

// CRUD Functions 

function showEmployeeData(e) {

    e.preventDefault();

    const EMPLOYEE_ID = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: "/admin/employees/" + EMPLOYEE_ID,
        success: function (data) {
            setModalData(data.employee[0], EMPLOYEE_ID);
        }
    });
    
}

function storeEmployeeData(e) {
    e.preventDefault();

    const EMPLOYEE_FORM = $('#createEmployeeForm')[0];
    const FORM_DATA = new FormData(EMPLOYEE_FORM);
    $.ajax({
        type: "POST",
        url: "/admin/employees",
        data: FORM_DATA,
        contentType: false,
        processData: false,
        success: function (response) {

            $('#createEmployeeModal').modal('hide');
            EMPLOYEE_FORM.reset();
            let page = $("[aria-current='page']").text();
            getMoreEmployees(page);
             
        }, 
        error: function(response) {

            const ERR_RESPONSE = JSON.parse(response.responseText);

            if (response.status == 422) {
            
            // Update Error Messages
                if (errorExists()) {
                    removeInvalidFeedbackClass();
                    removeErrorMessage();
                }

                for (const ERR_KEY in ERR_RESPONSE) {

                    if (ERR_RESPONSE.hasOwnProperty(ERR_KEY)) {

                            addInvalidFeedbackClass(ERR_KEY);
                            addErrorMessage(ERR_KEY, ERR_RESPONSE[ERR_KEY][0]);
                    }
                }
            }

        }
        
    });
}

function editEmployeeData(e) {

    e.preventDefault();
    const EMPLOYEE_ID = $(this).attr('id');

    $.ajax({
        type: 'GET',
        url: "/admin/employees/" + EMPLOYEE_ID,
        success: function (data) {
            setModalDataOnEdit(data.employee[0], EMPLOYEE_ID);
        }
    });
}

function updateEmployeeData(e) {
    e.preventDefault();

    const EMPLOYEE_ID = $('.employee_id').val();
    const EMPLOYEE_FORM = $('#editEmployeeForm')[0];
    const FORM_DATA = new FormData(EMPLOYEE_FORM);

    $.ajax({
        type: "POST",
        url: "/admin/employees/" + EMPLOYEE_ID,
        data: FORM_DATA,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#editEmployeeModal').modal('hide');
            EMPLOYEE_FORM.reset();
            let page = $("[aria-current='page']").text();
            getMoreEmployees(page);
        },
        error: function(response) {

            const ERR_RESPONSE = JSON.parse(response.responseText);

            if (response.status == 422) {
            
            // Update Error Messages
                if (errorExists()) {
                    removeInvalidFeedbackClass();
                    removeErrorMessage();
                }

                for (const ERR_KEY in ERR_RESPONSE) {

                    if (ERR_RESPONSE.hasOwnProperty(ERR_KEY)) {

                            addInvalidFeedbackClass(ERR_KEY);
                            addErrorMessage(ERR_KEY, ERR_RESPONSE[ERR_KEY][0]);
                    }
                }
            }

        }
    });
}

function destroyEmployeeData(e) {
        
    e.preventDefault();
    const EMPLOYEE_ID = $(this).attr('id');

    $.ajax({
        type: "DELETE",
        url: "/admin/employees/" + EMPLOYEE_ID,
        success: function (response) {
            let page = $("[aria-current='page']").text();
            getMoreEmployees(page);
        }
    });
}

function searchEmployee(e) {
    e.preventDefault();

    let page = getCurrentPageNumber();

    if ( getSearchValue() == '') {

        getMoreEmployees(
            getPageNumberOnSearch(page));

    } else {
        $.ajax({
            type: "GET",
            url: "/employees/search-employees/" + getSearchValue(),
            success: function (data) {
                $('.employee-data').html(data);
            }
        });
    }
}

// Modal
function setModalData (data) {

    $('.employee-modal-title').text(upperFirst(data.first_name) + ' ' + upperFirst(data.last_name));
    $('.employee-avatar').attr('src', '../../../storage/employees/avatars/' + data.avatar);
    $('.employee-first_name').text(data.first_name);
    $('.employee-last_name').text(data.last_name);
    $('.employee-email').text(data.email);
    $('.employee-phone').text(data.phone);
    $('.employee-salary').text(data.salary);
    $('.employee-commission').text(data.commission);
}   

function setModalDataOnEdit (data) {

    $('.avatar-preview').attr('src', '../../../storage/employees/avatars/' + data.avatar);
    $('.employee_id').val(data.id);
    $('.first_name').val(data.first_name);
    $('.last_name').val(data.last_name);
    $('.email').val(data.email);
    $('.phone').val(data.phone);
    $('.salary').val(data.salary);
    $('.commission').val(data.commission);
}   

function removeErrorMessagesOnEdit () {
    resetForm();
}

function removeErrorMessagesOnCreate () {
    resetForm();
}

function resetForm(){

    removeErrorMessage();
    removeInvalidFeedbackClass();
    $("form").trigger("reset");
    $('.avatar-preview').attr('src', '../../../storage/employees/avatars/no_image.png');
}

// Navigation

function navigate(e) {
            
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    getMoreEmployees(page);
}

// Error Components

function addInvalidFeedbackClass (className) {

    $('.' + className).addClass('is-invalid');
}

function removeInvalidFeedbackClass () {

    $('.avatar').removeClass('is-invalid');
    $('.first_name').removeClass('is-invalid');
    $('.last_name').removeClass('is-invalid');
    $('.email').removeClass('is-invalid');
    $('.phone').removeClass('is-invalid');
    $('.salary').removeClass('is-invalid');
    $('.commission').removeClass('is-invalid');
}

function addErrorMessage (className, errMessage) {
    $('.' + className + '-error').text(errMessage);
}

function removeErrorMessage () {

    $('.avatar-error').text('');
    $('.first_name-error').text('');
    $('.last_name-error').text('');
    $('.email-error').text('');
    $('.phone-error').text('');
    $('.salary-error').text('');
    $('.commission-error').text('');
}

function errorExists () {

    return $('.is-invalid');
}

// Image Preview
function onCreateImagePreview() {

    var AVATAR = $('.create-avatar-file').prop('files')[0];
    var READER = new FileReader();

    READER.onloadend = function () {
        $('.create-avatar-preview').attr('src', READER.result);
    }
    
    if (AVATAR) {
        READER.readAsDataURL(AVATAR);
    }
}

function onEditImagePreview() {

    var AVATAR = $('.edit-avatar-file').prop('files')[0];
    var READER = new FileReader();

    READER.onloadend = function () {
        $('.edit-avatar-preview').attr('src', READER.result);
    }
    
    if (AVATAR) {
        READER.readAsDataURL(AVATAR);
    }
}

function getMoreEmployees (page) {

    const TYPE = 'GET';
    let URL = `/employees/fetch-more-employees/${getSearchValue()}?page=${page}`;

    $.ajax({
        type: TYPE,
        url: URL,
        success: function (data) {
            $('.employee-data').html(data);
        }
    });
}

// Helper Functions

const upperFirst = (name) => name.charAt(0).toUpperCase() + name.slice(1);
const getPageNumberOnSearch = (page) => getSearchValue().length ? page : 1;
const getSearchValue = () => $('.search-employee').val().trim();
const getCurrentPageNumber = () => $("[aria-current='page']").text();
}())


/**
 * different FORMS must be handled with different fileReader
 * if different Forms have the same img and input className only one Form will be able to show image Asynchronously
 * So when updating or creating new Data, each form of the Operations input/img must be handled differently when FileReading
 */