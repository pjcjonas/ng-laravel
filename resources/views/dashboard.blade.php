@extends('templates/master')

@section('main')

    <table class="table"> <!-- CLIENT START -->
        <thead class="bg-primary">
            <tr>
                <th></th>
                <th>Client Name</th>
                <th class="text-right">Client ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $client) { ?>
                <tr class="clientRow" data-clientid="<?= $client['id'] ?>">
                    <td width="20px">
                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                    </td>
                    <td><strong><?= $client['name'] ?></strong></td>
                    <td class="text-right">
                        <em><strong>#<?= $client['id'] ?></strong></em>
                    </td>
                </tr>
                <tr>
                    <td colspan="100%" style="padding:0 !important" id="client<?= $client['id'] ?>"> <!-- ### CLIENT ID HERE FOR INVOICES-->

                        <table class="table" style="display:none !important"> <!-- INVOICES START -->
                            <thead class="bg-info">
                                <tr>
                                    <th>Invoice Number</th>
                                    <th width="20%">Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>INV12234</td>
                                    <td width="20%">2016-05-02</td>
                                </tr>
                                <tr>
                                    <td colspan="100%" id=""> <!-- ### INVOICE ID HERE LINE ITEMS-->

                                        <table class="table"> <!-- LINE ITEMS START -->
                                            <thead class="bg-success">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Item Name Here</td>
                                                    <td>12</td>
                                                    <td>ZAR 2000</td>
                                                    <td>2016-05-02</td>
                                                </tr>
                                                <tr>
                                                    <td>Item Name Here</td>
                                                    <td>12</td>
                                                    <td>ZAR 2000</td>
                                                    <td>2016-05-02</td>
                                                </tr>
                                                <tr>
                                                    <td>Item Name Here</td>
                                                    <td>12</td>
                                                    <td>ZAR 2000</td>
                                                    <td>2016-05-02</td>
                                                </tr>
                                            </tbody>
                                        </table> <!-- LINE ITEMS END -->

                                    </td>
                                </tr>
                            </tbody>
                        </table> <!-- CLIENT END -->

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table> <!-- CLIENT END -->

@stop
