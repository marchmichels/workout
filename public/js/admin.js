/***********************************************************************************************************
 ******                            Show All Messages for Admin                                        ******
 **********************************************************************************************************/

//This function gets called when the Admin link in the nav bar is clicked. It shows all the records of messages
function showAllPosts() {
	console.log('Show all messages for admin.');
}


//Callback function that shows all the messages. The parameter is an array of messages.
// The first parameter is an array of messages and second parameter is the subheading, defaults to null.
function displayAllPosts(posts, subheading=null) {
    console.log("display all message for the editing purpose")

    // search box and the row of headings
    let _html = `<div style='text-align: right; margin-bottom: 3px'>
            <input id='search-term' placeholder='Enter search terms'> 
            <button id='btn-post-search' onclick='searchPosts()'>Search</button></div>
            <div class='content-row content-row-header'>
            <div class='post-id'>Message ID</div>
            <div class='post-body'>Body</div>
            <div class='post-image'>Image</div>
            <div class='post-create'>Create Time</div>
            <div class='post-update'>Update Time</div>
            </div>`;  //end the row

    // content rows
    for (let x in posts) {
        let post = posts[x];
        _html += `<div class='content-row'>
            <div class='post-id'>${post.id}</div>
            <div class='post-body' id='post-edit-body-${post.id}'>${post.body}</div> 
            <div class='post-image' id='post-edit-image_url-${post.id}'>${post.image_url}</div>
            <div class='post-create' id='post-edit-created_at-${post.id}'>${post.created_at}</div> 
            <div class='post-update' id='post-edit-updated_at-${post.id}'>${post.updated_at}</div>`;

            _html += `<div class='list-edit'><button id='btn-post-edit-${post.id}' onclick=editPost('${post.id}') class='btn-light'> Edit </button></div>
            <div class='list-update'><button id='btn-post-update-${post.id}' onclick=updatePost('${post.id}') class='btn-light btn-update' style='display:none'> Update </button></div>
            <div class='list-delete'><button id='btn-post-delete-${post.id}' onclick=deletePost('${post.id}') class='btn-light'>Delete</button></div>
            <div class='list-cancel'><button id='btn-post-cancel-${post.id}' onclick=cancelUpdatePost('${post.id}') class='btn-light btn-cancel' style='display:none'>Cancel</button></div>`

        _html += '</div>';  //end the row
    }

    //the row of element for adding a new message

        _html += `<div class='content-row' id='post-add-row' style='display: none'> 
            <div class='post-id post-editable' id='post-new-user_id' contenteditable='true' content="User ID"></div>
            <div class='post-body post-editable' id='post-new-body' contenteditable='true'></div>
            <div class='post-image post-editable' id='post-new-image_url' contenteditable='true'></div>
            <div class='list-update'><button id='btn-add-post-insert' onclick='addPost()' class='btn-light btn-update'> Insert </button></div>
            <div class='list-cancel'><button id='btn-add-post-cancel' onclick='cancelAddPost()' class='btn-light btn-cancel'>Cancel</button></div>
            </div>`;  //end the row

        // add new message button
        _html += `<div class='content-row post-add-button-row'><div class='post-add-button' onclick='showAddRow()'>+ ADD A NEW MESSAGE</div></div>`;

    //Finally, update the page
    subheading = (subheading == null) ? 'All Messages' : subheading;
    updateMain('Messages', subheading, _html);
}

/***********************************************************************************************************
 ******                            Search Messages                                                    ******
 **********************************************************************************************************/
function searchPosts() {
   console.log('searching for messages');
}


/***********************************************************************************************************
 ******                            Edit a Message                                                     ******
 **********************************************************************************************************/

// This function gets called when a user clicks on the Edit button to make items editable
function editPost(id) {
    //Reset all items
    resetPost();

    //select all divs whose ids begin with 'post' and end with the current id and make them editable
    // $("div[id^='post-edit'][id$='" + id + "']").each(function () {
    //     $(this).attr('contenteditable', true).addClass('post-editable');
    // });

    $("div#post-edit-body-" + id).attr('contenteditable', true).addClass('post-editable');
    $("div#post-edit-image_url-" + id).attr('contenteditable', true).addClass('post-editable');
    $("div#post-edit-created_at-" + id).attr('contenteditable', true).addClass('post-editable');
    $("div#post-edit-updated_at-" + id).attr('contenteditable', true).addClass('post-editable');

    $("button#btn-post-edit-" + id + ", button#btn-post-delete-" + id).hide();
    $("button#btn-post-update-" + id + ", button#btn-post-cancel-" + id).show();
    $("div#post-add-row").hide();
}

//This function gets called when the user clicks on the Update button to update a message record
function updatePost(id) {
	console.log('update the message whose id is ' + id);
}


//This function gets called when the user clicks on the Cancel button to cancel updating a message
function cancelUpdatePost(id) {
    showAllPosts();
}

/***********************************************************************************************************
 ******                            Delete a Message                                                   ******
 **********************************************************************************************************/

// This function confirms deletion of a message. It gets called when a user clicks on the Delete button.
function deletePost(id) {
    $('#modal-button-ok').html("Delete").show().off('click').click(function () {
        removePost(id);
    });
    $('#modal-button-close').html('Cancel').show().off('click');
    $('#modal-title').html("Warning:");
    $('#modal-content').html('Are you sure you want to delete the message?');

    // Display the modal
    $('#modal-center').modal();
}

// Callback function that removes a message from the system. It gets called by the deletePost function.
function removePost(id) {
	console.log('remove the message whose id is ' + id);
}


/***********************************************************************************************************
 ******                            Add a Message                                                      ******
 **********************************************************************************************************/
//This function shows the row containing editable fields to accept user inputs.
// It gets called when a user clicks on the Add New Student link
function showAddRow() {
    resetPost(); //Reset all items
    $('div#post-add-row').show();
}

//This function inserts a new message. It gets called when a user clicks on the Insert button.
function addPost() {
	console.log('Add a new message');
}



// This function cancels adding a new message. It gets called when a user clicks on the Cancel button.
function cancelAddPost() {
    $('#post-add-row').hide();
}

/***********************************************************************************************************
 ******                            Check Fetch for Errors                                             ******
 **********************************************************************************************************/
/* This function checks fetch request for error. When an error is detected, throws an Error to be caught
 * and handled by the catch block. If there is no error detetced, returns the promise.
 * Need to use async and await to retrieve JSON object when an error has occurred.
 */
let checkFetch = async function (response) {
    if (!response.ok) {
        await response.json()  //need to use await so Javascipt will until promise settles and returns its result
            .then(result => {
                throw Error(JSON.stringify(result, null, 4));
            });
    }
    return response;
}


/***********************************************************************************************************
 ******                            Reset post section                                                 ******
 **********************************************************************************************************/
//Reset post section: remove editable features, hide update and cancel buttons, and display edit and delete buttons
function resetPost() {
    // Remove the editable feature from all divs
    $("div[id^='post-edit-']").each(function () {
        $(this).removeAttr('contenteditable').removeClass('post-editable');
    });

    // Hide all the update and cancel buttons and display all the edit and delete buttons
    $("button[id^='btn-post-']").each(function () {
        const id = $(this).attr('id');
        if (id.indexOf('update') >= 0 || id.indexOf('cancel') >= 0) {
            $(this).hide();
        } else if (id.indexOf('edit') >= 0 || id.indexOf('delete') >= 0) {
            $(this).show();
        }
    });
}