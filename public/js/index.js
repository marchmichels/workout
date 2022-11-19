var oldHash = '';
var baseUrl_API = ""; // you need to fill this variable with your own api url

$(function () {
    //Handle hashchange event; when a click is clicked, invoke an appropriate function
    window.addEventListener('hashchange', function (event) {
        let hash = location.hash.substr(1);  //need to remove the # symbol at the beginning.
        oldHash = event.oldURL.substr(event.oldURL.indexOf('#') + 1);

        if ($("a[href='#" + hash + "'").hasClass('disabled')) {
            showMessage('Signin Error', 'Access is not permitted. Please <a href="index.php#signin">sign in</a> to explore the site.');
            return;
        }

        //set active link
        $('li.nav-item.active').removeClass('active');
        $('li.nav-item#li-' + hash).addClass('active');

        //call appropriate function depending on the hash
        switch (hash) {
            case 'home':
                home();
                break;
            case 'user':
                showUsers();
                break;
            case 'post':
                showPosts();
                break;
            case 'admin':
                showAllPosts();
                break;
            case 'signin':
                signin();
                break;
            case 'signup':
                signup();
                break;
            case 'signout':
                signout();
                break;
            case 'message':
                break;
            default:
                home();
        }
    });
    if(jwt == '') {
        //display homepage content and set the hash to 'home'
        home();
        window.location.hash = 'home';
    }
});

// This function sets the content of the homepage.
function home() {
    let _html =
        `<p>This application demonstrates a responsive <strong>Single Page Application (SPA)</strong> architecture. SPAs are for an improved user experience.
        A SPA avoids interruption of the user experience between successive pages, making the application behave more like a 
        desktop application.</p>
        
        <p>The entire application consists of two pages: the sign in /sign up page and the main page for displaying section data.
        This application is an API client. Data of the application is provided by a API service called <strong>MyChatter API</strong>. 
        The application uses four common HTTP methods for CRUD operations: <strong>GET, POST, PUT, and DELETE</strong>.</p>
        
        <p>This application uses three different approaches for requesting API data:</p>
        <ul>
        <li><a href="https://en.wikipedia.org/wiki/Ajax_(programming)" target="_blank">AJAX</a> </li>
        <li><a href="https://github.com/axios/axios" target="_blank">Axios</a></li>
        <li><a href="https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch" target="_blank">Fetch</a></li>
        </ul>
        
        <p>For quick web development, <a href="https://jquery.com/" target="_blank">jQuery</a> and <a href="https://getbootstrap.com/" target="_blank">Bootstrap</a> are used.</p>
        <p>Please click on the "Sign in" link to sign in and explore the site. If you don't already have an account, please sign up and create a new account.</p>`;

    // Update the section heading, sub heading, and content
    updateMain('Home', 'Welcome to MyChatter Application', _html);
}

// This function updates main section content.
function updateMain(main_heading, sub_heading, section_content) {
    $('main').show();  //show main section
    $('.form-signup, .form-signin').hide(); //hide the sign-in and sign-up forms

    //update section content
    $('div#main-heading').html(main_heading);
    $('div#sub-heading').html(sub_heading);
    $('div#section-content').html(section_content);
}