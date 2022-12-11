
//This function shows all products
function showProducts() {
    const url = baseUrl_API + '/products';
    $.ajax({
        url: url,
        headers: {'Authorization': 'Bearer ' + jwt}
    }).done(function (data) {
        displayProducts(data);
    }).fail(function (jqXHR, textStatus) {
        //console.log(jqXHR);
        let error = {'code': jqXHR.status,
            'status':jqXHR.responseJSON.status};
        showMessage('Error', JSON.stringify(error, null, 4));
    });
}


//Callback function: display all products
function displayProducts(products) {

    let _html;
    _html = `<div class='content-row content-row-header'>
        <div class='product-name'>Product Name</div>
        <div class='product-category'>Category</div>
        <div class='product-price'>Price</div>
        <div class='product-description'>Description</div>
        </div>`;
    for (let x in products) {
        let product = products[x];
        let cssClass = (x % 2 == 0) ? 'content-row' : 'content-row content-row-odd';
        _html += `<div id='content-row-${product.product_id}' class='${cssClass}'>


            
            <div class='product-name'>${product.product_name}</div>
            <div class='product-category'>${product.categories}</div>            
            <div class='product-price'>${product.price}</div>
            <div class='product-description'>${product.description}</div>
            </div>`;
    }
    //Update the page
    updateMain('Products', 'All Products', _html);
}


/***********************************************************************************************************
 ******                            Show Comments made for a message                                   ******
 **********************************************************************************************************/
/* Display all comments. It get called when a user clicks on a message's id number in
 * the message list. The parameter is the message id number.
*/
function showComments(number) {
    let url = baseUrl_API + '/messages/' + number + '/comments';
    axios({
        method: 'get',
        url: url,
        cache: true,
        headers: {"Authorization": "Bearer " + jwt}
    })
        .then(function (response) {
            //console.log(response.data);
            displayComments(number, response);
        })
        .catch(function (error) {
            handleAxiosError(error);
        });

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

/***************************************************************************
 *************************
 *********                  This function handles errors occurred by an
 AXIOS request.     **********
 ****************************************************************************
 ***********************/
function handleAxiosError(error) {
    let errMessage;
    if (error.response) {
        // The request was made and the server responded with a status code of 4xx or 5xx
        errMessage = {"Code": error.response.status, "Status":
            error.response.data.status};
    } else if (error.request) {
        // The request was made but no response was received
        errMessage = {"Code": error.request.status, "Status":
            error.request.data.status};
    } else {
        // Something happened in setting up the request that triggered an error
        errMessage = JSON.stringify(error.message, null, 4);
    }
    showMessage('Error', errMessage);
}


/*******************************************************************************
 *****
 *****                  Paginating, sorting, and limiting courses
 *****
 *******************************************************************************/
//paginate all messages
function paginatePosts(response) {
    //calculate the total number of pages
    let limit = response.limit;
    let totalCount = response.totalCount;
    let totalPages = Math.ceil(totalCount / limit);
    //determine the current page showing
    let offset = response.offset;
    let currentPage = offset / limit + 1;
    //retrieve the array of links from response json
    let links = response.links;
    //convert an array of links to JSON document. Keys are "self", "prev", "next", "first", "last"; values are offsets.
    let pages = {};
    //extract offset from each link and store it in pages
    links.forEach(function (link) {
        let href = link.href;
        let offset = href.substr(href.indexOf('offset') + 7);
        pages[link.rel] = offset;
    });
    if (!pages.hasOwnProperty('prev')) {
        pages.prev = pages.self;
    }
    if (!pages.hasOwnProperty('next')) {
        pages.next = pages.self;
    }
    //generate HTML code for links
    let _html = `Showing Page ${currentPage} of ${totalPages}&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='#post' title="first page" onclick='showPosts(${pages.first})'> << </a>
                <a href='#post' title="previous page" onclick='showPosts(${pages.prev})'> < </a>
                <a href='#post' title="next page" onclick='showPosts(${pages.next})'> > </a>
                <a href='#post' title="last page" onclick='showPosts(${pages.last})'> >> </a>`;
    return _html;
}

//limit messages
function limitPosts(response) {
    //define an array of courses per page options
    let postsPerPageOptions = [5, 10, 20];
    //create a selection list for limiting courses
    let _html = `&nbsp;&nbsp;&nbsp;&nbsp; Items per page:<select id='post-limit-select' onChange='showPosts()'>`;
    postsPerPageOptions.forEach(function (option) {
        let selected = (response.limit == option) ? "selected" : "";
        _html += `<option ${selected} value="${option}">${option}</option>`;
    });
    _html += "</select>";
    return _html;
}
//sort messages
function sortPosts(response) {
    //create selection list for sorting
    let sort = response.sort;
    //sort field and direction: convert json to a string then remove {, }, and "
    let sortString = JSON.stringify(sort).replace(/["{}]+/g, "");
    console.log(sortString);
//define a JSON containing sort options
    let sortOptions = {
        "id:asc": "First Message ID -> Last Message ID",
        "id:desc": "Last Message ID -> First Message ID",
        "body:asc": "Message body A -> Z",
        "body:desc": "Message body Z -> A"
    };
    //create the selection list
    let _html = "&nbsp;&nbsp;&nbsp;&nbsp; Sort by: <select id='post-sort-select'" + "onChange='showPosts()'>";
    for (let option in sortOptions) {
        let selected = (option == sortString) ? "selected" : "";
        _html += `<option ${selected} value='${option}'>${sortOptions[option]}</option>`;
    }
    _html += "</select>";
    return _html;
}