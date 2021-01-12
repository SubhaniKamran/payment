@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-3 pt-5 pt-md-6">
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
                <form id="payment_form" method="POST" action="{{ route('payment.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="bill_type_id" id="bill_type_id" class="form-control form-control-alternative">
                                <option>--- Select Service ---</option>
                                @foreach ($billTypes as $billType)
                                    <option value="{{$billType->id}}">{{$billType->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="customer_name" value="" placeholder="Customer Name" class="form-control form-control-alternative" required />
                        </div>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="bill_account_number" value="" placeholder="Bill Account Number" class="form-control form-control-alternative" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" name="bill_amount" id="bill_amount" value="" placeholder="Bill Amount" class="form-control form-control-alternative" required />
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="button"  onclick="calculate_payment()" class="btn btn-info btn-block">Calculate Payment</button>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                        <input type="text" name="amount_received" id="amount_received" value="" placeholder="Calculated Amount" class="form-control form-control-alternative" required />
                        </div>
                    </div>
                </div>
                <input type="hidden" id="admin_commission" name="admin_commission" value="" />
                <input type="hidden" id="merchant_commission" name="merchant_commission" value="" />
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Submit Payment</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
    <script type="text/javascript">

        function calculate_payment() {
            var token = '<?=csrf_token()?>';
            var bill_amount=$('#bill_amount').val()
            var bill_type_id=$('#bill_type_id').find(":selected").val();
            if (bill_type_id == '--- Select Service ---') {
                alert('Please select a service first.');
            } else if (bill_amount == '' || bill_amount == 0) {
                alert('Please enter bill amount.');
            } else {
                $.ajax({
					type:'POST',
					url:'<?=url("calculatePyment")?>',
					data:{ _token :token, bill: bill_amount, bill_type_id:bill_type_id },
					success:function(data) {
                      $('#amount_received').val(data.total_bill);
                      $('#admin_commission').val(data.admin_commission);
                      $('#merchant_commission').val(data.merchant_commission);
					}
				});
            }
        }

    </script>
@endpush
