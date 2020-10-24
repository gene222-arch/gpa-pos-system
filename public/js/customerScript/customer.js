(function(){
    
    getMoreCustomers($("[aria-current='page']").text())
    $(document).ready(function () {
    
        setUpAjax();
        $(document).on('click', 'nav[role="navigation"] a', paginate);
        $(document).on('click', '.show-customer', showCustomer);
        $(document).on('click', '.edit-customer', editCustomer);
        $(document).on('click', '.btn-cancel', cancelButton);
        $(document).on('click', '.delete-customer', deleteCustomer);
        $(document).on('click', '.update-customer', updateCustomer); 
    });


    
// AJAX SETUP

    function setUpAjax() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
    }

// CRUD Functions

    function showCustomer(e) {

        e.preventDefault();
        let token = document.querySelector('meta[name="csrf-token"]').content;

        $.ajax({
            type: "GET",
            url: "/admin/customers/" + $(this).attr('id'),
            success: function (data) {
                setModalData(data);
            }
        });
    }

    function editCustomer(e) {
                
        e.preventDefault();
        const CUSTOMER_ID = $(this).attr('id');

        showInputElements(CUSTOMER_ID);
        hideTextElements (CUSTOMER_ID);
        showOnEditButtons(CUSTOMER_ID);
        hideCRUDButtons(CUSTOMER_ID);
    }

    function updateCustomer(e) {

        e.preventDefault();
        const CUSTOMER_ID = $(this).attr('id');
        const FORM_DATA = new FormData();
        appendToFormData(FORM_DATA, CUSTOMER_ID);
        for (const DATA of FORM_DATA) {
            console.log(DATA[0] + ' = ' + DATA[1]);
        }
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
            
                $.ajax({
                    type: "POST",
                    url: "/admin/customers/" + CUSTOMER_ID,
                    data: FORM_DATA,
                    contentType: false, // JSON
                    processData: false, // Dont convert to urlencoded
                    success: function (response) {
                        
                        hideInputElements(CUSTOMER_ID);
                        showTextElements (CUSTOMER_ID);
                        hideOnEditButtons(CUSTOMER_ID);
                        showCRUDButtons(CUSTOMER_ID);
                        console.log(response.data)
                        // setInputElementsValue(CUSTOMER_ID, response.data);
                        if (response.action.length != '') {
                            Swal.fire(
                                response.action,
                                response.messageOnUpdate,
                                response.status
                            )  
                        }
                        
                    // Reload current table page
                        let page = $("[aria-current='page']").text();
                        getMoreCustomers(page);

                    },
                    error: function (request) {

                        if (request.status === 422) {

                            const ERROR = JSON.parse(request.responseText);
                            
                        // Remove pre - error then add again
                            if ( errorExist() ) {

                                removeClassInvalid(CUSTOMER_ID);
                                removeErrorMessage(CUSTOMER_ID);
                            }

                            for (const KEY in ERROR) {

                                if (ERROR.hasOwnProperty(KEY)) {

                                    addClassInvalid(KEY, CUSTOMER_ID);
                                    addErrorMessage(KEY, CUSTOMER_ID, ERROR[KEY][0]);
                                }
                            }              
                        }
                    }

                }); // Ajax
            }
        });

    }

    function deleteCustomer(e) {

        e.preventDefault();
        const CUSTOMER_ID = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
           
                $.ajax({
                    type: "DELETE",
                    url: "/admin/customers/" + CUSTOMER_ID,
                    success: function (response) {
                        Swal.fire(
                            response.action,
                            response.messageOnDelete,
                            response.status
                          )
                        
                        let page = $("[aria-current='page']").text();
                        getMoreCustomers(page);

                    }
                });
            }
          });

    }


// Typography 
    function showTextElements (customerId) {

        $('.customer-avatar-text' + customerId).show();   
        $('.customer-first_name-text' + customerId).show();
        $('.customer-last_name-text' + customerId).show();
        $('.customer-email-text' + customerId).show();
        $('.customer-address-text' + customerId).show();
    }

    function hideTextElements (customerId) {

        $('.customer-avatar-text' + customerId).hide();   
        $('.customer-first_name-text' + customerId).hide();
        $('.customer-last_name-text' + customerId).hide();
        $('.customer-email-text' + customerId).hide();
        $('.customer-address-text' + customerId).hide();
    }

    function setModalData (data) {

        $('.customer-avatar').attr('src', '../../../storage/customers/avatars/' + data.customer.avatar);
        $('.customer-first_name').text(data.customer.first_name);
        $('.customer-last_name').text(data.customer.last_name);
        $('.customer-email').text(data.customer.email);
        $('.customer-address').text(data.customer.address);
    }

// Input Components
    function showInputElements (customerId) {
        $('.avatar' + customerId).show();
        $('.first_name' + customerId).show();
        $('.last_name' + customerId).show();
        $('.email' + customerId).show();
        $('.address' + customerId).show();
    }

    function hideInputElements (customerId) {

        $('.avatar' + customerId).hide();
        $('.first_name' + customerId).hide();
        $('.last_name' + customerId).hide();
        $('.email' + customerId).hide();
        $('.address' + customerId).hide();
    }

    function hideAllInputElements () {

        $('.avatar').hide();
        $('.first_name').hide();
        $('.last_name').hide();
        $('.email').hide();
        $('.address').hide();
    }

// Button Components
    function hideAllOnEditButtons () {

        $('.btn-cancel').hide();
        $('.update-customer').hide();
    }

    function hideOnEditButtons (customerId) {

        $('.btn-cancel' + customerId).hide();
        $('.update-customer' + customerId).hide();
    }

    function showOnEditButtons (customerId) {

        $('.btn-cancel' + customerId).css('display', 'inline-block');
        $('.update-customer' + customerId).css('display', 'inline-block');
    }

    function showCRUDButtons (customerId) {

        $('.show-customer' + customerId).show();
        $('.edit-customer' + customerId).show();
        $('.delete-customer' + customerId).show();
    }

    function hideCRUDButtons (customerId) {

        $('.show-customer' + customerId).hide();
        $('.edit-customer' + customerId).hide();
        $('.delete-customer' + customerId).hide();
    }

    function cancelButton(e) {
            
        e.preventDefault();
        const CUSTOMER_ID = $(this).attr('id');

        hideInputElements(CUSTOMER_ID);
        showTextElements (CUSTOMER_ID);
        hideOnEditButtons(CUSTOMER_ID);
        showCRUDButtons(CUSTOMER_ID);
        removeClassInvalid(CUSTOMER_ID);
        removeErrorMessage(CUSTOMER_ID);
    }

// Error Components
    function addClassInvalid (className, customerId) {
        
        $('.' + className + customerId).addClass('is-invalid');
    }

    function removeClassInvalid (customerId) {
        
        $('.avatar' + customerId).removeClass('is-invalid');
        $('.first_name' + customerId).removeClass('is-invalid');
        $('.last_name' + customerId).removeClass('is-invalid');
        $('.email' + customerId).removeClass('is-invalid');
        $('.address' + customerId).removeClass('is-invalid');
    }

    function addErrorMessage (className, customerId, message) {

        $('.' + className + '-error-' + customerId).text(message);

    }

    function removeErrorMessage (customerId) {

        $('.avatar' + '-error-' + customerId).text('');
        $('.first_name' + '-error-' + customerId).text('');
        $('.last_name' + '-error-' + customerId).text('');
        $('.email' + '-error-' + customerId).text('');
        $('.address' + '-error-' + customerId).text('');
    }

    function errorExist () {

        return $('.invalid-feedback') ? 1 : 0;
    }

// FORMDATA INSERTION
    function appendToFormData (FORM_DATA, CUSTOMER_ID) {

        const AVATAR = $('.avatar' + CUSTOMER_ID).prop('files')[0];

        if ( AVATAR ) {
            FORM_DATA.append('avatar', AVATAR);
        }

        FORM_DATA.append('_method', 'PUT');
        
        FORM_DATA.append('first_name', $('.first_name' + CUSTOMER_ID).val());
        FORM_DATA.append('last_name', $('.last_name' + CUSTOMER_ID).val());
        FORM_DATA.append('email', $('.email' + CUSTOMER_ID).val());
        FORM_DATA.append('address', $('.address' + CUSTOMER_ID).val());
    }

// Data reload
    function getMoreCustomers (page) {

        $.ajax({
            type: "GET",
            url: "/customers/fetch-more-customers?page=" + page,
            success: function (data) {
                $('.customer-data').html(data);
                hideAllInputElements();
                hideAllOnEditButtons ();
            }
        });
    }

    function paginate(e) {

        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getMoreCustomers(page);
    }

}());