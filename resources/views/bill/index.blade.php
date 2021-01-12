@extends('layouts.app')

@section('content')
<style>
    .chip {
        display: inline-block;
        padding: 0 18px;
        height: 40px;
        font-size: 14px;
        line-height: 40px;
        border-radius: 25px;
        background-color: #f1f1f1;
    }
    
    .closebtn {
        padding-left: 10px;
        color: #888;
        font-weight: bold;
        float: right;
        font-size: 20px;
        cursor: pointer;
    }
    
    .closebtn:hover {
         color: #000;
    }
    
    @media (min-width: 575px){
        .input-group{
            background-color: #000
        }
    }

</style>
<div class="header bg-gradient-primary pb-6 pt-5 pt-md-6" method="GET" action="">
    <!-- Form -->
    <form class="navbar-search navbar-search-dark form-inline mr-5 ml-5 mb-4 d-none d-sm-flex d-md-flex ml-lg-auto justify-content-end">
        <div class="row">
            <div class="col-md-12 col-lg-6 mt-2">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Account Number" type="text" name="account_number" value="{{$account_number}}">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Customer Name" type="text" name="customer_name" value="{{$customer_name}}">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 mt-2">
                <div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Bill Type" type="text" name="bill_type" value="{{$bill_type}}">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input class="form-control" placeholder="Merchant Name" type="text" name="merchant_name" value="{{$merchant_name}}">
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </div>
        </div>
    </form>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong>Success!</strong> <span id="success_message"></span></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card">
                    
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="firstname">Invoice ID</th>
                                    <th scope="col" class="sort" data-sort="lastname">Merchant Name</th>
                                    <th scope="col" class="sort" data-sort="email">Bill Type</th>
                                    <th scope="col" class="sort" data-sort="email">Bill Status</th>
                                    <th scope="col" class="sort" data-sort="phone">Amount</th>
                                    <th scope="col" class="sort" data-sort="phone">Customer Name</th>
                                    <th scope="col" class="sort" data-sort="services">Account Number</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if($payments->count())
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ $payment->user->firstname }}</td>
                                            <td>{{ $payment->billType->name }}</td>
                                            <td>{{ $payment->status }}</td>
                                            <td>{{ $payment->amount_received }}</td>
                                            <td>{{ $payment->customer_name }}</td>
                                            <td>{{ $payment->bill_account_number }}</td>
                                            <td><a href="{{ url('public/'.$payment->invoice) }}" class="btn btn-primary btn-sm">Download</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">No Data Available!</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
