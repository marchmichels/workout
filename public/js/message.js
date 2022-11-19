//This function displays a message. It includes the message heading and body.
function showMessage(heading, body) {
    //set the hash
    window.location.hash = 'message';

    //Update the page to display messages
    updateMain('Messages', heading, '<pre>' + body + '</pre>')

    //Toggle the signin and signout links in the nav bar
    if (heading.indexOf('Signup Error') >= 0) {
        $("li#li-signup").show();
        $("li#li-signin, li#li-signout").hide();
    } else if (heading.indexOf('Error') >= 0 || heading.indexOf('Signup Message') >= 0) {
        $("li#li-signin").show();
        $("li#li-signup, li#li-signout").hide();
    } else {
        $('a.nav-link.disabled').removeClass('disabled');   //enable links
        $("li#li-signin, li#li-signup").hide();
        $("li#li-signout").show();
    }
}
