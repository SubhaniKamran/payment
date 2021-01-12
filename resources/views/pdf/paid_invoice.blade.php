<style>
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    .row {
        margin-right: 15px;
        margin-left: -15px;
    }
    .row:before {
        display: table;
    }
    .row:after {
        clear: both;
    }
    .col-sm-6 {
        width: 50%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .header-backgroud {
        background-color: gray
    }
    .text-center {
        text-align: center;
    }
    .border {
        border: 1px solid black;
    }
    .border-bottom > td{
        border-bottom: 1px solid black;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <h1>Payments Express</h1>
            <p>3500 College Boulevard - Leawood, KS 66211</p>
            <br><br>
            <h5>BST Wireless*11132</h5>
            <p>1634 Central Ave <br> Middletown, OH 45004</p>
        </div>
        <div class="col-sm-6">
            <table>
                <tr>
                    <th class="header-backgroud border">
                        Card Number
                    </th>
                    <th class="header-backgroud border">
                        Invoice Date
                    </th>
                    <th class="header-backgroud border">
                        Invoice Number
                    </th>
                </tr>
                <tr class="text-center">
                    <td class="border">
                        {{$merchant_account}}
                    </td>
                    <td class="border">
                        {{$transaction_date}}
                    </td>
                    <td class="border">
                        {{$invoice_number}}
                    </td>
                </tr>
            </table>

            <br><br>

            <table style="width: 100%">
                <tr>
                    <th class="header-backgroud border">
                        Paid At
                    </th>
                </tr>
                <tr class="text-center">
                    <td class="border">
                        {{date('Y-m-d')}}
                    </td>
                </tr>
            </table>

            <br><br>

            <div style="text-align: right;">
                <h1>INVOICE</h1>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row text-center">
        <hr>
        <h4>Current Charges</h4>
        <table>
            <tr>
                <th class="header-backgroud border">
                    Bill Type
                </th>
                <th class="header-backgroud border">
                    Bill Account Number
                </th>
                <th class="header-backgroud border">
                    Customer Name
                </th>
                <th class="header-backgroud border">
                    Merchant Commission
                </th>
                <th class="header-backgroud border">
                    Company Commission
                </th>
                <th class="header-backgroud border">
                    Amount Received
                </th>
            </tr>
            <tr class="text-center border-bottom">
                <td>
                    {{$bill_type}}
                </td>
                <td>
                    {{$bill_account_number}}
                </td>
                <td>
                    {{$customer_name}}
                </td>
                <td>
                    {{$merchant_commission}}
                </td>
                <td>
                    {{$admin_commission}}
                </td>
                <td>
                    {{$amount_received}}
                </td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <table style="width:86%">
                <tr>
                    <th class="header-backgroud border">Amount paid</th>
                    <td class="text-center border">{{$amount_due}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
