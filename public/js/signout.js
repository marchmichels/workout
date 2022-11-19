//This function signs a user out. It gets called when the Sign out link is clicked.
function signout() {
    $('#modal-title').html("Sign out");
    $('#modal-content').html('Are you sure you want to sign out from the site?');
    $('#modal-button-ok').html("Sign out").show().off('click').click(function() {
        // empty the jwt variable
        jwt = '';

        //Update the main section content
        updateMain('Signing out', 'Confirmation', 'You are now signed out. Thank you for visiting.');

        // Disable the professor, course, and student links in the nav bar
        $("li#li-professor > a, li#li-post > a, li#li-admin > a").addClass('nav-link disabled');

        // Show the sign-in link and hide the sign-out link
        $("li#li-signin").show();
        $("li#li-signout").hide();
    });
    $('#modal-button-close').html('Cancel').off('click').click(function () {
        //change the hash back to the old hash if the cancel button is clicked.
        location.hash = oldHash;
    });

    // Display the modal
    $('#modal-center').modal();
}