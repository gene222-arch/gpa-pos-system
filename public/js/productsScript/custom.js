
(function(){
    
// Fetch data using pagination and load the table
    getMoreProducts($("[aria-current='page']").text());

    $(document).ready(function () {
        
        setUpAjax();
        $(document).on('click', 'nav[role="navigation"] a', paginate);
        $(document).on('click', '.show-product', showProduct);
        $(document).on('click', '.delete-product', destroyProduct);
        $(document).on('click', '.edit-product', editProduct);
        $(document).on('click', '.update-product', updateProduct);
        $(document).on('click', '.btn-cancel', cancelButton);
            
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

    function showProduct(e) {

        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/admin/products/" + $(this).attr('id'),
            success: function (data) {
                setModalData(data);
            }
        });
    }

    function editProduct(e) {

        e.preventDefault();
        let productId = $(this).attr('id');
        showInputElements(productId);
        hideTextElements(productId);
        showOnEditButtons(productId);
        hideCRUDButtons(productId);

    }

    function updateProduct(e) {

        e.preventDefault();
        const productId = $(this).attr('id');
        const PRODUCT_FORM = $('#productForm' + productId)[0];
        const FORM_DATA = new FormData(PRODUCT_FORM);
        appendToFormData(FORM_DATA, productId);

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
                    url: "/admin/products/" + productId,
                    data: FORM_DATA,
                    contentType: false, // JSON
                    processData: false, // Dont convert to urlencoded
                    success: function (response) {
                        
                        hideInputElements(productId);
                        showTextElements (productId);
                        hideOnEditButtons(productId);
                        showCRUDButtons(productId);
                        console.log(response)

                    // Reload current table page
                        let page = $("[aria-current='page']").text();
                        getMoreProducts(page);

                    },
                    error: function (request) {

                        if (request.status === 422) {

                            const ERROR = JSON.parse(request.responseText);

                            if (errorExist()) {

                                removeClassInvalid(productId);
                                removeErrorMessage(productId);
                            }

                            for (const KEY in ERROR) {

                                if (ERROR.hasOwnProperty(KEY)) {

                                    addClassInvalid(KEY, productId);
                                    addErrorMessage(KEY, productId, ERROR[KEY][0]);
                                }
                            }              
                        }
                    }
                }); // Ajax
            }
        });

    }

    function destroyProduct(e) {

        e.preventDefault();
        
        $.ajax({
            type: "DELETE",
            url: "/admin/products/" + $(this).attr('id'),
            success: function (response) {
                // Current page
                let page = $("[aria-current='page']").text();
                getMoreProducts(page);
            }
        });
    }

// Typography
    function showTextElements (productId) {

        $('.product-name-text' + productId).show();
        $('.product-image-text' + productId).show();
        $('.product-barcode-text' + productId).show();
        $('.product-price-text' + productId).show();
        $('.product-quantity-text' + productId).show();
        $('.product-status-text' + productId).show();
    }

    function hideTextElements (productId) {

        $('.product-name-text' + productId).hide();
        $('.product-image-text' + productId).hide();
        $('.product-barcode-text' + productId).hide();
        $('.product-price-text' + productId).hide();
        $('.product-quantity-text' + productId).hide();
        $('.product-status-text' + productId).hide();
    }

    function setModalData (data) {

        $('.product-image').attr('src', '../../../storage/products/images/' + data.product[0].image);
        $('.product-name').text(data.product[0].product_name);
        $('.product-barcode').text(data.product[0].barcode);
        $('.product-price').text(data.product[0].price);
        $('.product-quantity').text(data.product[0].quantity);
        $('.product-status').text(data.product[0].status);
        console.log(data);
    }

// Input Components

    function showInputElements (productId) {

        $('.product_name' + productId).show();
        $('.image' + productId).show();
        $('.barcode' + productId).show();
        $('.price' + productId).show();
        $('.quantity' + productId).show();
        $('.status' + productId).show();
    }

    function hideInputElements (productId) {

        $('.product_name' + productId).hide();
        $('.image' + productId).hide();
        $('.barcode' + productId).hide();
        $('.price' + productId).hide();
        $('.quantity' + productId).hide();
        $('.status' + productId).hide();
    }

    function removeInputElements (productId) {

        $('.product_name' + productId).hide();
        $('.image' + productId).hide();
        $('.barcode' + productId).hide();
        $('.price' + productId).hide();
        $('.quantity' + productId).hide();
        $('.status' + productId).hide();
    }

    function hideAllInputElements () {

        $('.product_name').hide();
        $('.image').hide();
        $('.barcode').hide();
        $('.price').hide();
        $('.quantity').hide();
        $('.status').hide();
    }


// Button Components

    function showOnEditButtons (productId) {

        $('.btn-cancel' + productId).css('display', 'inline-block');
        $('.update-product' + productId).css('display', 'inline-block');
    }

    function hideOnEditButtons (productId) {

        $('.btn-cancel' + productId).hide();
        $('.update-product' + productId).hide();
    }

    function hideAllOnEditButtons () {

        $('.btn-cancel').hide();
        $('.update-product').hide();
    }

    function showCRUDButtons (productId) {

        $('.show-product' + productId).show();
        $('.edit-product' + productId).show();
        $('.delete-product' + productId).show();
    }

    function hideCRUDButtons (productId) {

        $('.show-product' + productId).hide();
        $('.edit-product' + productId).hide();
        $('.delete-product' + productId).hide();
    }

    function cancelButton(e) {

        e.preventDefault();
        let productId = $(this).attr('id');

        hideInputElements(productId);
        showTextElements (productId);
        hideOnEditButtons(productId);
        showCRUDButtons(productId);
    }

// Error Components

    function addClassInvalid (className, productId) {
            
        $('.' + className + productId).addClass('is-invalid');
    }

    function removeClassInvalid (productId) {
        
        $('.image' + productId).removeClass('is-invalid');
        $('.product_name' + productId).removeClass('is-invalid');
        $('.barcode' + productId).removeClass('is-invalid');
        $('.price' + productId).removeClass('is-invalid');
        $('.quantity' + productId).removeClass('is-invalid');
        $('.status' + productId).removeClass('is-invalid');
    }

    function addErrorMessage (className, productId, message) {

        $('.' + className + '-error-' + productId).text(message);

    }

    function removeErrorMessage (productId) {

        $('.image' + '-error-' + productId).text('');
        $('.product_name' + '-error-' + productId).text('');
        $('.barcode' + '-error-' + productId).text('');
        $('.price' + '-error-' + productId).text('');
        $('.status' + '-error-' + productId).text('');
        $('.quantity' + '-error-' + productId).text('');
    }

    function errorExist () {

        return $('.invalid-feedback') ? 1 : 0;
    }

    function appendToFormData (FORM_DATA, productId) {

        const AVATAR = $('.image' + productId).prop('files')[0];

        if ( AVATAR ) {
            FORM_DATA.append('image', AVATAR);
        }

        FORM_DATA.append('_method', 'PUT');
        FORM_DATA.append('product_name', $('.product_name' + productId).val());
        FORM_DATA.append('barcode', $('.barcode' + productId).val());
        FORM_DATA.append('price', $('.price' + productId).val());
        FORM_DATA.append('quantity', $('.quantity' + productId).val());
        FORM_DATA.append('status', $('.status' + productId).val().toLowerCase() == 'active' ? 1 : 0);
    }
  
    function getMoreProducts (page) {

        $.ajax({
            type: "GET",
            url: "/products/fetch-more-products?page=" + page,
            success: function (data) {
                $('.product-data').html(data);
                hideAllInputElements();
                hideAllOnEditButtons ();
            }
        });
    }

    function paginate(e) {

        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getMoreProducts(page);
    }

// Helper Functions

}());