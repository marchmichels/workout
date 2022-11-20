//This function get called when the signup hash is clicked.
function signup() {
    $('.img-loading, main, .form-signin, #li-signin').hide();
    $('.form-signup, #li-signup').show();

    //window.location.hash = 'signup';
}

//submit the form to create a user account
$('form.form-signup').submit(function (e) {

    $('.img-loading').show();
    e.preventDefault();
    let username = $('#signup-username').val();
    let password = $('#signup-password').val();
    let firstName = $('#signup-first-name').val();
    let lastName = $('#signup-last-name').val();
    let streetAddress = $('#signup-street-address').val();
    let city = $('#signup-city').val();
    let state = $('#signup-state').val();
    let zipcode = $('#signup-zipcode').val();


    const url = baseUrl_API + '/users';
    $.ajax({
        url: url,
        method: 'post',
        dataType: 'json',
        data: {
            username: username,
            password: password,
            first_name: firstName,
            last_name: lastName,
            street_address: streetAddress,
            city: city,
            state: state,
            zipcode: zipcode
        }
    }).done(function () {
        $('.img-loading').hide();
//show a message after a sussessful login
        showMessage('Signup Message',
            'Thanks for signing up. Your account has been created.');
        $('li#li-signin').show();
        $('li#li-signout').hide();
    }).fail(function (jqXHR, textStatus) {
        showMessage('Signup Error', JSON.stringify(jqXHR.responseJSON, null,
            4));
    }).always(function () {
        console.log('Signup has Completed.');
    });

});