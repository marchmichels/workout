
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
