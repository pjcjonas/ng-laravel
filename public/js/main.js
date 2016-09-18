$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    initClickEvents();
});

var initClickEvents = function() {
    $('.clientRow').unbind().on('click', function(event){
        var invoices = getClientInvoices($(this).data('clientid'));
        console.log(invoices);
    });

    $('.invoiceRow').unbind().on('click', function(event){
        var invoices = getInvoiceLineItems($(this).data('inv'));
        console.log(invoices);
    });
}

var getClientInvoices = function(clientID) {
    $.ajax({
        method: "POST",
        url: "/postClientInvoices",
        data: { clientID: clientID },
        dataType: 'json'
    })
    .done(function(response) {
        var invcoiesHtml = [];

        if (response.length < 1) {
            invcoiesHtml.push('<em>No invoices</em>');
        } else {
            invcoiesHtml.push('<table class="table"> <!-- INVOICES START -->');
            invcoiesHtml.push('    <thead class="bg-info">');
            invcoiesHtml.push('        <tr>');
            invcoiesHtml.push('        <th>Invoice Number</th>');
            invcoiesHtml.push('        <th width="20%">Invoice Date</th>');
            invcoiesHtml.push('        </tr>');
            invcoiesHtml.push('    </thead>');
            invcoiesHtml.push('    <tbody>');

            $.each(response, function(index, value){
                invcoiesHtml.push('        <tr class="invoiceRow" data-inv="' + value.id + '">');
                invcoiesHtml.push('            <td>' + value.invoiceNumber + '</td>');
                invcoiesHtml.push('            <td width="20%">' + value.invoiceNumber + '</td>');
                invcoiesHtml.push('        </tr>');
                invcoiesHtml.push('        <tr>');
                invcoiesHtml.push('            <td colspan="100%" id="inv' + value.id + '"></td>');
                invcoiesHtml.push('        </tr>');
            });

            invcoiesHtml.push('    </tbody>');
            invcoiesHtml.push('</table> <!-- INVOICES END -->');
        }

        buildOutputHtml("#client" + clientID, invcoiesHtml);
        initClickEvents();
    });
};



var getInvoiceLineItems = function(invoiceID) {
    $.ajax({
        method: "POST",
        url: "/postClientLineItems",
        data: { invoiceID: invoiceID },
        dataType: 'json'
    })
    .done(function(response) {

        /*
        created_at:"2016-09-18 10:33:35"
        currency:"ZAR"
        deleted:0
        id:51
        invoiceID:15
        name:"92YLR4wX5QEOav6"
        price:"6997.00"
        quantity:67
        updated_at:"2016-09-17 11:24:14"
        */

        var lineitemHtml = [];

        if (response.length < 1) {
            lineitemHtml.push('<em>No Line Items</em>');
        } else {
            lineitemHtml.push('<table class="table"> <!-- LINE ITEMS START -->');
            lineitemHtml.push('    <thead class="bg-success">');
            lineitemHtml.push('        <tr>');
            lineitemHtml.push('            <th>Name</th>');
            lineitemHtml.push('            <th>Quantity</th>');
            lineitemHtml.push('            <th>Price</th>');
            lineitemHtml.push('            <th>Created Date</th>');
            lineitemHtml.push('        </tr>');
            lineitemHtml.push('    </thead>');
            lineitemHtml.push('    <tbody>');

            $.each(response, function(index, value){
                lineitemHtml.push('        <tr>');
                lineitemHtml.push('            <td>' + value.name + '</td>');
                lineitemHtml.push('            <td>' + value.quantity + '</td>');
                lineitemHtml.push('            <td>' + value.price + ' '  + value.currency + '</td>');
                lineitemHtml.push('            <td>' + value.updated_at + '</td>');
                lineitemHtml.push('        </tr>');
            });

            lineitemHtml.push('    </tbody>');
            lineitemHtml.push('</table> <!-- LINE ITEMS END -->');
        }

        buildOutputHtml("#inv" + invoiceID, lineitemHtml);
        initClickEvents();
    });
};


var buildOutputHtml = function(location, htmlData) {
    var html = htmlData.join("");
    $(location).html(html);
}
