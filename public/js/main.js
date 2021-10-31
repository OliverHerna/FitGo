// App Layout
// Events

$(document).ready(function() {
    $("body").tooltip({ selector: "[data-toggle=tooltip]" });
});

$('#logout-button').click(function (e) {
    e.preventDefault();
    $('#logout-form').submit();
});

$('form .btn').click(function(e){
    e.preventDefault();
    $(this).attr('disabled', true);
    if ($(this).attr('id') != 'add-clasification' && $(this).attr('id') != 'open-clasification' && $(this).attr('id') != 'add-email') {
        $(this).parents('form:first').submit();
    }
});

// Functions
function clearErrors() {
    // remove all error messages
    $( "div .text-danger" ).each(function() {
        $(this).remove(); 
    });
    // remove all form controls with highlighted error text box
    $( ".form-control" ).each(function() {
        $(this).removeClass('border-danger');
    });
}

function clearSession() {
    // remove all session messages
    $( ".alert-success" ).each(function() {
        $(this).remove(); 
    });
}