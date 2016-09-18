@extends('templates/master')

@section('main')

<div class="panel panel-default">
    <div class="panel-heading"><strong>CLIENTS</strong>
        <button data-toggle="modal" data-target=".addClientModal" type="button" class="btn btn-success pull-right btn-xs">
            <span class="glyphicon glyphicon-plus"></span>Add New Client
        </button>
    </div>

    <table class="table table-bordered"> <!-- CLIENT START -->
        <tbody id="mainClientsHolder">
            <?php foreach($clients as $client) { ?>
                <tr class="clientRow" id="clientRow<?= $client['id'] ?>" data-clientid="<?= $client['id'] ?>">
                    <td class="text-center"  width="30px">
                        <small><strong>#<?= $client['id'] ?></strong></small>
                    </td>
                    <td><?= $client['name'] ?></td>
                    <td width="20px">
                        <span class="glyphicon glyphicon-triangle-bottom "></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="100%" style="padding:0 !important" id="client<?= $client['id'] ?>">

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table> <!-- CLIENT END -->
</div>

<div class="modal fade addInvoiceLineItemModal" tabindex="-1" role="dialog" aria-labelledby="addInvoiceLineItemModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Invoice Lineitem</h4>
            </div>
            <div class="modal-body">
                <form class="" action="" method="post" id="formAddLineItem">
                    <input type="hidden" name="lineItemInvoiceID" id="lineItemInvoiceID" value="0">
                    <div class="form-group">
                        <label for="aaaa">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="aaaa">Currency</label>
                        <select class="form-control" id="currency" name="currency" >
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="JPY">JPY</option>
                            <option value="GBP">GBP</option>
                            <option value="AUD">AUD</option>
                            <option value="CAD">CAD</option>
                            <option value="CHF">CHF</option>
                            <option value="ZAR">ZAR</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aaaa">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Price" step="any">
                    </div>
                    <div class="form-group">
                        <label for="aaaa">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateAndSaveLineItem()">Save Lineitem</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Client</h4>
            </div>
            <div class="modal-body">
                <form class="" action="" method="post" id="formAddclient">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateAndSaveClient()">Save Client</button>
            </div>
        </div>
    </div>
</div>

@stop
