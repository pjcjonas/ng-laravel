// On document ready
$(function(){

    // Add CSRT token registration the ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Init the click events
    initClickEvents();
});

// Global variables
var selectedClientID = 0;
var selectedInvoiceID = 0;

// Setup te click events
var initClickEvents = function() {
    $('.clientRow').unbind().on('click', function(event){
        var invoices = getClientInvoices($(this).data('clientid'));
    });

    $('.invoiceRow').unbind().on('click', function(event){
        var lineItems = getInvoiceLineItems($(this).data('inv'));
    });
}

// Ajax load the selected clients invoices
var getClientInvoices = function(clientID) {
    $.ajax({
        method: "POST",
        url: "/postClientInvoices",
        data: { clientID: clientID },
        dataType: 'json'
    })
    .done(function(response) {
        var invcoiesHtml = [];

        invcoiesHtml.push('<table class="table"> <!-- INVOICES START -->');
        invcoiesHtml.push('    <thead>');
        invcoiesHtml.push('        <tr>');
        invcoiesHtml.push('            <th colspan="100%">');
        invcoiesHtml.push('                <button onclick="addInvoice(\'' + clientID + '\')" data-toggle="modal" data-target=".addInvoiceModal" type="button" class="btn btn-success pull-right btn-xs">');
        invcoiesHtml.push('                    <span class="glyphicon glyphicon-plus"></span>Add Invoice');
        invcoiesHtml.push('                </button>');
        invcoiesHtml.push('            </th>');
        invcoiesHtml.push('        </tr>');
        invcoiesHtml.push('        <tr>');
        invcoiesHtml.push('            <th>Invoice Number</th>');
        invcoiesHtml.push('            <th width="20%" class="text-right">Invoice Date</th>');
        invcoiesHtml.push('        </tr>');
        invcoiesHtml.push('    </thead>');
        invcoiesHtml.push('    <tbody id="clientInvoices' + clientID + '">');

        if (response.length < 1) {
            invcoiesHtml.push('        <tr class="removeLine">');
            invcoiesHtml.push('            <td colspan="100%" style="padding:0 !important"> No invoices found</td>');
            invcoiesHtml.push('        </tr>');
        } else {
            $.each(response, function(index, value){
                invcoiesHtml.push('        <tr class="invoiceRow" id="invoiceRow' + value.id + '" data-inv="' + value.id + '">');
                invcoiesHtml.push('            <td>' + value.invoiceNumber + '</td>');
                invcoiesHtml.push('            <td class="text-right">' + value.invoiceDate + '</td>');
                invcoiesHtml.push('        </tr>');
                invcoiesHtml.push('        <tr>');
                invcoiesHtml.push('            <td colspan="100%" style="padding:0 !important" id="inv' + value.id + '"></td>');
                invcoiesHtml.push('        </tr>');
            });
        }

        invcoiesHtml.push('    </tbody>');
        invcoiesHtml.push('</table> <!-- INVOICES END -->');

        buildOutputHtml("#client" + clientID, invcoiesHtml);
        if (selectedClientID != clientID) {
            buildOutputHtml("#client" + selectedClientID, []);
            $("#clientRow" + selectedClientID).removeClass('bg-success');
            $("#clientRow" + clientID).addClass('bg-success');
            selectedClientID = clientID;
        }
        initClickEvents();
    });
};

// Ajax load the selected invoice's Lineitems
var getInvoiceLineItems = function(invoiceID) {
    $.ajax({
        method: "POST",
        url: "/postClientLineItems",
        data: { invoiceID: invoiceID },
        dataType: 'json'
    })
    .done(function(response) {

        var lineitemHtml = [];

        lineitemHtml.push('<table class="table"> <!-- LINE ITEMS START -->');
        lineitemHtml.push('    <thead>');
        lineitemHtml.push('        <tr>');
        lineitemHtml.push('            <th colspan="100%">');
        lineitemHtml.push('                <button onclick="addInvoiceLineitemModal(\'' +invoiceID+ '\')" data-toggle="modal" data-target=".addInvoiceLineItemModal" type="button" class="btn btn-success pull-right btn-xs">');
        lineitemHtml.push('                    <span class="glyphicon glyphicon-plus"></span>Add Lineitem');
        lineitemHtml.push('                </button>');
        lineitemHtml.push('            </th>');
        lineitemHtml.push('        </tr>');
        lineitemHtml.push('        <tr>');
        lineitemHtml.push('            <th width="50%">Name</th>');
        lineitemHtml.push('            <th>Quantity</th>');
        lineitemHtml.push('            <th>Price</th>');
        lineitemHtml.push('            <th class="text-right">Created Date</th>');
        lineitemHtml.push('        </tr>');
        lineitemHtml.push('    </thead>');
        lineitemHtml.push('    <tbody id="clientInvoiceLineItems' +invoiceID+ '">');

        if (response.length < 1) {
            lineitemHtml.push('        <tr class="removeLine">');
            lineitemHtml.push('            <td colspan="100%">No lineitems for this invoice</td>');
            lineitemHtml.push('        </tr>');
        } else {
            $.each(response, function(index, value){
                lineitemHtml.push('        <tr>');
                lineitemHtml.push('            <td>' + value.name + '</td>');
                lineitemHtml.push('            <td>' + value.quantity + '</td>');
                lineitemHtml.push('            <td>' + value.price + ' '  + value.currency + '</td>');
                lineitemHtml.push('            <td class="text-right">' + value.updated_at + '</td>');
                lineitemHtml.push('        </tr>');
            });
        }

        lineitemHtml.push('    </tbody>');
        lineitemHtml.push('</table> <!-- LINE ITEMS END -->');

        buildOutputHtml("#inv" + invoiceID, lineitemHtml);
        if (selectedInvoiceID != invoiceID) {
            buildOutputHtml("#inv" + selectedInvoiceID, []);
            $("#invoiceRow" + selectedInvoiceID).removeClass('bg-warning');
            $("#invoiceRow" + invoiceID).addClass('bg-warning');
            selectedInvoiceID = invoiceID;
        }

        initClickEvents();
    });
};

// Generate html output - html()
var buildOutputHtml = function(location, htmlData) {
    var html = htmlData.join("");
    $(location).html(html);
};

// Generate html output - append()
var appendOutputHtml = function(location, htmlData) {
    var html = htmlData.join("");
    $(location).append(html);
};

// Generate html output - prepend()
var prependOutputHtml = function(location, htmlData) {
    var html = htmlData.join("");
    $(location).prepend(html);
};

// Generates new modal based on the last invoice ID
var addInvoice = function(clientID) {
    $.ajax({
        method: "POST",
        url: "/postAddInvoice",
        data: { clientID: clientID },
        dataType: 'json'
    })
    .done(function(response) {
        var invcoiesHtml = [];
        if (response.invoiceNumber) {
            invcoiesHtml.push('        <tr class="invoiceRow" id="invoiceRow' + response.lastInsertId + '" data-inv="' + response.lastInsertId + '">');
            invcoiesHtml.push('            <td>' + response.invoiceNumber + '</td>');
            invcoiesHtml.push('            <td class="text-right">' + response.invoiceDate + '</td>');
            invcoiesHtml.push('        </tr>');
            invcoiesHtml.push('        <tr>');
            invcoiesHtml.push('            <td colspan="100%" style="padding:0 !important" id="inv' + response.lastInsertId + '"></td>');
            invcoiesHtml.push('        </tr>');
            $(".removeLine").remove();
        }
        prependOutputHtml("#clientInvoices" + clientID, invcoiesHtml);
        initClickEvents();
        $('.addInvoiceLineItemModal').modal('hide');
    });
};

// Sets new lineitem invoice ID
var addInvoiceLineitemModal = function(invoiceID) {
    $('#lineItemInvoiceID').val(invoiceID);
};

// Opens modal, validates and saves new line item
var validateAndSaveLineItem = function() {

    $.ajax({
        method: "POST",
        url: "/postAddLineItem",
        data: {data: $('#formAddLineItem').serialize()},
        dataType: 'json'
    })
    .done(function(response) {
        $("#formAddLineItem .form-control").removeClass('bg-danger');
        if (!response.status) {
            $.each(response.errors, function (key, value) {
                $("#formAddLineItem #" + key).addClass('bg-danger');
            });
            return;
        }

        var lineitemHtml = [];
        lineitemHtml.push('        <tr>');
        lineitemHtml.push('            <td>' + response.data.name + '</td>');
        lineitemHtml.push('            <td>' + response.data.quantity + '</td>');
        lineitemHtml.push('            <td>' + response.data.price + ' '  + response.data.currency + '</td>');
        lineitemHtml.push('            <td class="text-right">' + response.date + '</td>');
        lineitemHtml.push('        </tr>');

        prependOutputHtml("#clientInvoiceLineItems" + response.lineitemID, lineitemHtml);
        $(".removeLine").remove();
        initClickEvents();
        $('.addInvoiceLineItemModal').modal('hide');
    });

};

// Create a new client
var validateAndSaveClient = function() {

    $.ajax({
        method: "POST",
        url: "/postAddClient",
        data: {data: $('#formAddclient').serialize()},
        dataType: 'json'
    })
    .done(function(response) {
        console.log(response);
        $("#formAddLineItem .form-control").removeClass('bg-danger');
        if (!response.status) {
            $.each(response.errors, function (key, value) {
                $("#formAddLineItem #" + key).addClass('bg-danger');
            });
            return;
        }

        var clientHtml = [];
        clientHtml.push('<tr class="clientRow" id="clientRow' + response.data.id + '" data-clientid="' + response.data.id + '">');
        clientHtml.push('    <td class="text-center"  width="30px">');
        clientHtml.push('        <small><strong>#' + response.data.id + '</strong></small>');
        clientHtml.push('    </td>');
        clientHtml.push('    <td>' + response.data.name + '</td>');
        clientHtml.push('    <td width="20px">');
        clientHtml.push('        <span class="glyphicon glyphicon-triangle-bottom "></span>');
        clientHtml.push('    </td>');
        clientHtml.push('</tr>');
        clientHtml.push('<tr>');
        clientHtml.push('    <td colspan="100%" style="padding:0 !important" id="client' + response.data.id + '">');
        clientHtml.push('    </td>');
        clientHtml.push('</tr>');

        prependOutputHtml("#mainClientsHolder", clientHtml);
        initClickEvents();
        $('.addClientModal').modal('hide');
    });

};


var confirmDeleteClient = function(clientID, clientName) {

    var deleteClient = confirm("Are you sure you want to delete client: " + clientID + " | " + clientName);

    if (deleteClient) {
        $.ajax({
            method: "POST",
            url: "/postDeleteClientByID",
            data: {id: clientID},
            dataType: 'json'
        })
        .done(function(response) {
            if (response) {
                $("#clientRow" + clientID).remove();
                $("#client" + clientID).remove();
            }
        });
    }

}
