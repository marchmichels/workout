/***********************************************************************************************************
 ******                            Show Posts                                                         ******
 **********************************************************************************************************/
//This function shows all posts. It gets called when a user clicks on the Post link in the nav bar.

// Pagination, sorting, and limiting are disabled
function showPosts () {
	console.log('show all messages');

}

//Callback function: display all posts; The parameter is a promise returned by axios request.
function displayPosts (response) {
    //console.log(response);
    let _html;
    _html =
        "<div class='content-row content-row-header'>" +
        "<div class='post-id'>Message ID</></div>" +
        "<div class='post-body'>Message Body</></div>" +
        "<div class='post-create'>Create Time</div>" +
        "<div class='post-update'>Update Time</div>" +
        "</div>";
    let posts = response.data;
    posts.forEach(function(post, x){
        let cssClass = (x % 2 == 0) ? 'content-row' : 'content-row content-row-odd';
        _html += "<div class='" + cssClass + "'>" +
            "<div class='post-id'>" +
            "<span class='list-key' onclick=showComments('" + post.id + "') title='Get post details'>" + post.id + "</span>" +
            "</div>" +
            "<div class='post-body'>" + post.body + "</div>" +
            "<div class='post-create'>" + post.created_at + "</div>" +
            "<div class='post-update'>" + post.updated_at + "</div>" +
            "</div>" +
            "<div class='container post-detail' id='post-detail-" + post.id + "' style='display: none'></div>";
    });

    //Finally, update the page
    updateMain('Messages', 'All Messages', _html);
}


/***********************************************************************************************************
 ******                            Show Comments made for a message                                   ******
 **********************************************************************************************************/
/* Display all comments. It get called when a user clicks on a message's id number in
 * the message list. The parameter is the message id number.
*/
function showComments(number) {
    console.log('get a message\'s all comments');

}


// Callback function that displays all details of a course.
// Parameters: course number, a promise
function displayComments(number, response) {
    let _html = "<div class='content-row content-row-header'>Comments</div>";
    let comments = response.data;
    //console.log(number);
    //console.log(comments);
    comments.forEach(function(comment, x){
        _html +=
            "<div class='post-detail-row'><div class='post-detail-label'>Comment ID</div><div class='post-detail-field'>" + comment.id + "</div></div>" +
            "<div class='post-detail-row'><div class='post-detail-label'>Comment Body</div><div class='post-detail-field'>" + comment.body + "</div></div>" +
            "<div class='post-detail-row'><div class='post-detail-label'>Create Time</div><div class='post-detail-field'>" + comment.created_at + "</div></div>";
    });

    $('#post-detail-' + number).html(_html);
    $("[id^='post-detail-']").each(function(){   //hide the visible one
        $(this).not("[id*='" + number + "']").hide();
    });

    $('#post-detail-' + number).toggle();
}

