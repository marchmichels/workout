/***********************************************************************************************************
 ******                            Show Users                                                    ******
 **********************************************************************************************************/
//This function shows all users. It gets called when a user clicks on the Users link in the nav bar.
function showUsers() {
    console.log('show all the users');

}


//Callback function: display all users; The parameter is an array of user objects.
function displayUsers(users) {
    let _html;
    _html = `<div class='content-row content-row-header'>
        <div class='user-name'>Name</div>
        <div class='user-email'>Email</div>
        <div class='user-profileicon-phone'>Profile Icon</div>
        <div class='user-username'>Username</div>
        </div>`;
    for (let x in users) {
        let user = users[x];
        let cssClass = (x % 2 == 0) ? 'content-row' : 'content-row content-row-odd';
        _html += `<div id='content-row-${user.id}' class='${cssClass}'>
            <div class='user-name'>
                <span class='list-key' data-user='${user.id}' 
                     onclick=showUserPostsPreview('${user.id}') 
                     title='Get messages made by the user'>${user.name}
                </span>
            </div>
            <div class='user-email'>${user.email}</div>
            <div class='user-profileicon'>${user.profile_icon}</div>
            <div class='user-username'>${user.username}</div>            
            </div>`;
    }
    //Finally, update the page
    updateMain('Users', 'All Users', _html);
}


/***********************************************************************************************************
 ******                            Show Posts Made by a User                                 ******
 **********************************************************************************************************/
/* Display posts made by a user. It get called when a user clicks on a user's name in
 * the user list. The parameter is the user's id.
*/
//Display posts made by a user in a modal
function showUserPostsPreview(id) {
    console.log('preview a user\'s all posts');

}




// Callback function that displays all posts made by a user.
// Parameters: user's name, an array of Post objects
function displayUserPostsPreview(user, posts) {
    let _html = "<div class='post_preview'>No messages were found.</div>";
    if (posts.length > 0) {
        _html = "<table class='post_preview'>" +
            "<tr>" +
            "<th class='post_preview-body'>Message</th>" +
            "<th class='post_preview-image'>Image</th>" +
            "<th class='post_preview-create'>Created At</th>" +
            "<th class='post_preview-update'>Updated At</th>" +
            "</tr>";

        for (let x in posts) {
            let aPost = posts[x];
            _html += "<tr>" +
                "<td class='post_preview-body'>" + aPost.body + "</td>" +
                "<td class='post_preview-image'>" + aPost.image_url + "</td>" +
                "<td class='post_preview-create'>" + aPost.created_at + "</td>" +
                "<td class='post_preview-update'>" + aPost.updated_at + "</td>" +
                "</tr>"
        }
        _html += "</table>"
    }

    // set modal title and content
    $('#modal-title').html("Messages made by " + user);
    $('#modal-button-ok').hide();
    $('#modal-button-close').html('Close').off('click');
    $('#modal-content').html(_html);

    // Display the modal
    $('#modal-center').modal();
}