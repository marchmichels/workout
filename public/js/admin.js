/***********************************************************************************************************
 ******                            Show All Messages for Admin                                        ******
 **********************************************************************************************************/

//This function gets called when the Admin link in the nav bar is clicked. It shows all the records of messages
function showAllProducts() {
    const url = baseUrl_API + "/products?limit=50";
    fetch(url, {
        method: 'GET',
        headers: {"Authorization": "Bearer " + jwt}
    })
        .then(checkFetch)
        .then(response => response.json())
        .then(products => displayAllProducts(products))
        .catch(err => showMessage("Errors", err)) //display errors
}


//Callback function that shows all the messages. The parameter is an array of messages.
// The first parameter is an array of messages and second parameter is the subheading, defaults to null.
function displayAllProducts(products, subheading=null) {
    console.log("display all products for the editing purpose")

    // search box and the row of headings
    let _html = `<div style='text-align: right; margin-bottom: 3px'>
<!--            <input id='search-term' placeholder='Enter search terms'> -->
<!--            <button id='btn-post-search' onclick='searchProducts()'>Search</button></div>-->
            <div class='content-row content-row-header'>
            <div class='product-id'>Product ID</div>
            <div class='product-name'>Product Name</div>
            <div class='product-category'>Category</div>
            <div class='product-price'>Price</div>
            <div class='product-description'>Description</div>
            </div>`;  //end the row

    // content rows
    for (let x in products) {
        let product = products[x];
        _html += `<div class='content-row'>
            <div class='product-id'>${product.product_id}</div>
            <div class='product-name' id='product-edit-name-${product.product_id}'>${product.product_name}</div> 
            <div class='product-category' id='product-edit-category-${product.product_id}'>${product.categories}</div>
            <div class='product-price' id='product-edit-price-${product.product_id}'>${product.price}</div> 
            <div class='product-description' id='product-edit-description-${product.product_id}'>${product.description}</div>`;

        _html += `<div class='list-edit'><button id='btn-product-edit-${product.product_id}' onclick=editProduct('${product.product_id}') class='btn-light'> Edit </button></div>
            <div class='list-update'><button id='btn-product-update-${product.product_id}' onclick=updateProduct('${product.product_id}') class='btn-light btn-update' style='display:none'> Update </button></div>
            <div class='list-delete'><button id='btn-product-delete-${product.product_id}' onclick=deleteProduct('${product.product_id}') class='btn-light'>Delete</button></div>
            <div class='list-cancel'><button id='btn-product-cancel-${product.product_id}' onclick=cancelUpdateProduct('${product.product_id}') class='btn-light btn-cancel' style='display:none'>Cancel</button></div>`

        _html += '</div>';  //end the row
    }


    //the row of element for adding a new message

    _html += `


            <div class='content-row' id='product-add-row' style='display: none'> 
            <div class='product-id'><strong>Product ID</strong></div>
            <div class='product-name'><strong>Product Name</strong></div> 
            <div class='product-category'><strong>Category</strong></div>
            <div class='product-price'><strong>Price</strong></div> 
            <div class='product-description'><strong>Description</strong></div>
            </div>



            <div class='content-row' id='product-add-row' style='display: none'> 
            <div class='product-id product-editable' id='product-new-product_id' contenteditable='false' content="Product ID">(auto generated)</div>
            <div class='product-name product-editable' id='product-new-product_name' contenteditable='true'></div>
            <div class='product-category product-editable' id='product-new-category' contenteditable='true'></div>
            <div class='product-price product-editable' id='product-new-price' contenteditable='true'></div>
            <div class='product-description product-editable' id='product-new-description' contenteditable='true'></div>
            <div class='list-update'><button id='btn-add-product-insert' onclick='addProduct()' class='btn-light btn-update'> Insert </button></div>
            <div class='list-cancel'><button id='btn-add-product-cancel' onclick='cancelAddProduct()' class='btn-light btn-cancel'>Cancel</button></div>
            </div>`;  //end the row

    // add new message button
    _html += `<div class='content-row product-add-button-row'><div class='product-add-button' onclick='showAddRow()'>+ ADD A NEW PRODUCT</div></div>`;

    //Finally, update the page
    subheading = (subheading == null) ? 'All Products' : subheading;
    updateMain('Products', subheading, _html);
}

// /***********************************************************************************************************
//  ******                            Search Products                                                    ******
//  **********************************************************************************************************/
// function searchPosts() {
//     let term = $("#search-term").val();
//     //console.log(term);
//     const url = baseUrl_API + "/messages?q=" + term;
//     let subheading = '';
//     //console.log(url);
//     if (term == '') {
//         subheading = "All Messages";
//     } else if (isNaN(term)) {
//         subheading = "Messages Containing '" + term + "'"
//     } else {
//         subheading = "Messages whose ID is having" + term;
//     }
// //send the request
//     fetch(url, {
//         method: 'GET',
//         headers: {"Authorization": "Bearer " + jwt}
//     })
//         .then(checkFetch)
//         .then(response => response.json())
//         .then(posts => displayAllPosts(posts))
//         .catch(err => showMessage("Errors", err)) //display errors
// }


/***********************************************************************************************************
 ******                            Edit a Product                                                     ******
 **********************************************************************************************************/

// This function gets called when a user clicks on the Edit button to make items editable
function editProduct(id) {
    //Reset all items
    resetProduct();

    //select all divs whose ids begin with 'post' and end with the current id and make them editable
    // $("div[id^='post-edit'][id$='" + id + "']").each(function () {
    //     $(this).attr('contenteditable', true).addClass('post-editable');
    // });

    $("div#product-edit-name-" + id).attr('contenteditable', true).addClass('product-editable');
    $("div#product-edit-category-" + id).attr('contenteditable', true).addClass('product-editable');
    $("div#product-edit-price-" + id).attr('contenteditable', true).addClass('product-editable');
    $("div#product-edit-description-" + id).attr('contenteditable', true).addClass('product-editable');

    $("button#btn-product-edit-" + id + ", button#btn-product-delete-" + id).hide();
    $("button#btn-product-update-" + id + ", button#btn-product-cancel-" + id).show();
    $("div#post-add-row").hide();
}

//This function gets called when the user clicks on the Update button to update a message record
function updateProduct(id) {
    let data = {};
    data['product_name'] = $("div#product-edit-name-" + id).html();
    data['category'] = $("div#product-edit-category-" + id).html();
    data['price'] = $("div#product-edit-price-" + id).html();
    data['description'] = $("div#product-edit-description-" + id).html();
    console.log(data);
    const url = baseUrl_API + "/products/" + id;
    console.log(url);
    fetch(url, {
        method: 'PATCH',
        headers: {
            "Authorization": "Bearer " + jwt,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(checkFetch)
        .then(() => resetProduct())
        .catch(error => showMessage("Errors", error))
}


//This function gets called when the user clicks on the Cancel button to cancel updating a message
function cancelUpdateProduct(id) {
    showAllProducts();
}

/***********************************************************************************************************
 ******                            Delete a Message                                                   ******
 **********************************************************************************************************/

// This function confirms deletion of a message. It gets called when a user clicks on the Delete button.
function deleteProduct(id) {
    $('#modal-button-ok').html("Delete").show().off('click').click(function () {
        removeProduct(id);
    });
    $('#modal-button-close').html('Cancel').show().off('click');
    $('#modal-title').html("Warning:");
    $('#modal-content').html('Are you sure you want to delete the product?');

    // Display the modal
    $('#modal-center').modal();
}

// Callback function that removes a message from the system. It gets called by the deletePost function.
function removeProduct(id) {
    let url = baseUrl_API + "/products/" + id;
    fetch(url, {
        method: 'DElETE',
        headers: {"Authorization": "Bearer " + jwt,},
    })
        .then(checkFetch)
        .then(() => showAllProducts())
        .catch(error => showMessage("Errors", error))
}


/***********************************************************************************************************
 ******                            Add a Product                                                      ******
 **********************************************************************************************************/
//This function shows the row containing editable fields to accept user inputs.
// It gets called when a user clicks on the Add New Student link
function showAddRow() {
    resetProduct(); //Reset all items
    $('div#product-add-row').show();
}

//This function inserts a new message. It gets called when a user clicks on the Insert button.
function addProduct() {
    let data = {};
    $("div[id^='product-new-']").each(function () {
        let field = $(this).attr('id').substr(12);
        let value = $(this).html();
        data[field] = value;
    });
// data['user_id'] = $("div#post-new-user_id").html();
// data['body'] = $("div#post-new-body").html();
// data['image_url'] = $("div#post-new-image_url").html();
    console.log(data);
    const url = baseUrl_API + "/products";
    console.log(url);
    fetch(url, {
        method: 'POST',
        headers: {
            "Authorization": "Bearer " + jwt,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
        .then(checkFetch)
        .then(() => showAllProducts())
        .catch(err => showMessage("Errors", err))
}



// This function cancels adding a new message. It gets called when a user clicks on the Cancel button.
function cancelAddProduct() {
    $('#product-add-row').hide();
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
function resetProduct() {
    // Remove the editable feature from all divs
    $("div[id^='product-edit-']").each(function () {
        $(this).removeAttr('contenteditable').removeClass('product-editable');
    });

    // Hide all the update and cancel buttons and display all the edit and delete buttons
    $("button[id^='btn-product-']").each(function () {
        const id = $(this).attr('id');
        if (id.indexOf('update') >= 0 || id.indexOf('cancel') >= 0) {
            $(this).hide();
        } else if (id.indexOf('edit') >= 0 || id.indexOf('delete') >= 0) {
            $(this).show();
        }
    });
}