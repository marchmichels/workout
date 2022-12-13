/***********************************************************************************************************
 ******                            Show Users                                                    ******
 **********************************************************************************************************/
//This function shows all users. It gets called when a user clicks on the Users link in the nav bar.
function showUsers() {
    console.log('show all the users');
    const url = baseUrl_API + '/users';
    $.ajax({
        url: url,
        headers: {'Authorization': 'Bearer ${jwt}'}
    }).done(function (data) {
        displayUsers(data);
    }).fail(function (jqXHR, textStatus) {
        let error = {'code': jqXHR.staus,
            'status':jqXHR.responseJson.status};
        showMessage('Error', JSON.stringify(error, null, 4));
    });

}


//Callback function: display all users; The parameter is an array of user objects.
function displayUsers(users) {
    console.log(users);
    let _html;
    _html = `<div class='content-row content-row-header'>
        <div class='user-username'>Username</div>
        <div class='user-username'>First</div>
        <div class='user-username'>Last</div>
        <div class='user-street'>Street</div>
        <div class='user-username'>City</div>
        <div class='user-username'>State</div>
        <div class='user-username'>Zipcode</div>
        </div>`;
    for (let x in users) {
        let user = users[x];
        console.log(user);
        let cssClass = (x % 2 == 0) ? 'content-row' : 'content-row content-row-odd';
        _html += `<div id='content-row-${user.user_id}' class='${cssClass}'>
            <div class='user-name'>
                <span class='list-key' data-user='${user.user_id}' 
                     onclick=showUserOrderPreview('${user.user_id}') 
                     title='Get orders made by the user'>${user.username}
                </span>
            </div>
            <div class='user-username'>${user.first_name}</div>
            <div class='user-username'>${user.last_name}</div>
            <div class='user-street'>${user.street_address}</div>
            <div class='user-username'>${user.city}</div>            
            <div class='user-username'>${user.state}</div>            
            <div class='user-username'>${user.zipcode}</div>            
            
            </div>`;
    }
    //Finally, update the page
    updateMain('Users', 'All Users', _html);
}


/***********************************************************************************************************
 ******                            Show Orders Made by a User                                 ******
 **********************************************************************************************************/
/* Display orders made by a user. It gets called when a user clicks on a user's name in
 * the user list. The parameter is the user's id.
*/
//Display orders made by a user in a modal
function showUserOrderPreview(id) {
    console.log('preview a user\'s all orders');
    const url = baseUrl_API + '/users/' + id + '/orders';
    const name = $("span[data-user='" + id + "']").html();
    //console.log(url);
    //console.log(name);
    $.ajax({
        url: url,
        headers: {"Authorization": "Bearer " + jwt}
    }).done(function(data){
        console.log(data)
        displayUserOrderPreview(name, data);
    }).fail(function(xaXHR) {
        let error = {'Code': jqXHR.status,
            'Status':jqXHR.responseJSON.status};
        showMessage('Error', JSON.stringify(error, null, 4));
    });

}




// Callback function that displays all orders made by a user.
// Parameters: user's name, an array of order objects
function displayUserOrderPreview(user, orders) {
    console.log(user, orders);
    let _html = "<div class='post_preview'>No orders were found.</div>";
    if (orders.length > 0) {
        _html = "<table class='post_preview'>" +
            "<tr>" +
            "<th class='post_preview-body'>Order ID</th>" +
            "<th class='post_preview-image'>Product ID</th>" +
            "<th class='post_preview-create'>Order Date</th>" +
            "</tr>";

        for (let x in orders) {
            let aOrder = orders[x];
            console.log(aOrder)
            _html += "<tr>" +
                "<td class='post_preview-body'>" + aOrder.order_id + "</td>" +
                "<td class='post_preview-image'>" + aOrder.product_id + "</td>" +
                "<td class='post_preview-create'>" + aOrder.order_date + "</td>" +
                "</tr>"
        }
        _html += "</table>"
    }

    // set modal title and content
    $('#modal-title').html("Orders made by " + user);
    $('#modal-button-ok').hide();
    $('#modal-button-close').html('Close').off('click');
    $('#modal-content').html(_html);

    // Display the modal
    $('#modal-center').modal();
}