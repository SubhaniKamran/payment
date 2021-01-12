@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-6 pt-5 pt-md-6">

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ implode('', $errors->all('')) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif


                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center mb-3">
                        <div style="width: 18rem;">
                            <div class="card card-stats mb-4 mb-lg-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Balance</h5>
                                            <span class="h2 font-weight-bold mb-0">{{auth()->user()->credit_balance ?? 0}}</span>
                                        </div>
                                        <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="far fa-credit-card"></i>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center mt-3">
                        <form action="pay_now" method="POST" style="width: 18rem;">
                            @csrf
                            <div class="form-row align-items-center">
                            <div class="form-group col-sm-6 ">
                                <label class="text-white" for="amount">Pay Now</label>
                                <input type="text" class="form-control text-primary" value="{{auth()->user()->credit_balance ?? 0}}" name="amount" id="amount" placeholder="1000" readonly>
                            </div>
                            @foreach ($paymentTransactions as $paymentTransaction)
                                <input type="hidden" name="payment_transactions[]" value="{{$paymentTransaction->id}}"/>
                            @endforeach
                            <button type="submit" name="comssion" class="btn btn-Default mt-2">Send Payment</button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <h3 style="color: #eeff00">Please note that Instant Payment Fee (${{$instantPaymentFee}}) will be charged on each transaction.</h3>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endpush
