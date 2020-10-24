

$(document).ready( function() {

    $(document).on('mouseover', '.brand-text', function (e) {
        e.preventDefault();
        this.innerText = '';
        this.innerHTML = `<input type="text" class="form-control">`;
    });

    $("a.brand-link").mouseleave(function(){
        
            $('.brand-link .brand-name-input').html('TEST');

      });


});