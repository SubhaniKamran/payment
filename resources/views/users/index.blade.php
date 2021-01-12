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
</style>
<div class="header bg-gradient-primary pb-6 pt-5 pt-md-6" method="GET" action="">
    <!-- Form -->
    <form class="navbar-search navbar-search-dark form-inline mr-5 mb-4 d-none d-md-flex ml-lg-auto justify-content-end">
        <div class="form-group mr-3">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text" name="search" value="{{$search}}">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Filter</button>
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
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="mb-0">Merchants</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-primary" id="add_bill_type_btn" data-toggle="modal" data-target="#addModal">Add Merchant</button>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="firstname">First Name</th>
                                    <th scope="col" class="sort" data-sort="lastname">Last Name</th>
                                    <th scope="col" class="sort" data-sort="email">Email</th>
                                    <th scope="col" class="sort" data-sort="phone">Phone</th>
                                    <th scope="col" class="sort" data-sort="phone">Status</th>
                                    <th scope="col" class="sort" data-sort="services">Services</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if($users->count())
                                    @foreach($users as $user)

                                                    
                                                @if(($user->deleted_at) == NULL)

                                                    @if(($user->status) == "unverified")
                                                        
                                                        
                                                        <tr>
                                                            <td>{{ $user->firstname }}</td>
                                                            <td>{{ $user->lastname }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td>                                                    
                                                                <span class="badge badge-pill badge-warning">
                                                                    {{$user->status}}
                                                                </span>           
                                                            </td>
                                                            <td>@foreach ($user->merchantServices as $service)
                                                                <div class="chip">
                                                                    {{$service->billType->name}}
                                                                    <span class="closebtn" onclick="removeService(this.parentElement, {{$service->id}})">&times;</span>
                                                                </div>
                                                            @endforeach</td>
                                                            <td><button type="button" class="btn-icon-clipboard edit"
                                                                    id="{{ $user->id }}" data-original-title="Edit"
                                                                    style="width: 68px"><i class="ni ni-calendar-grid-58"></i></button>
                                                                <button type="button" class="btn-icon-clipboard delete"
                                                                    id="{{ $user->id }}" data-original-title="Delete"
                                                                    style="width: 68px"><i class="ni ni-basket"></i></button>
                                                                @if ($user->status == 'unverified')
                                                                    <button type="button" class="btn-icon-clipboard verify"
                                                                    id="{{ $user->id }}" data-original-title="Verify"
                                                                    style="width: 68px"><i class="ni ni-check-bold"></i></button>
                
                                                                @endif
                                                                <button type="button" class="btn-icon-clipboard services"
                                                                    id="{{ $user->id }}" data-original-title="Assign Services"
                                                                    style="width: 68px"><i class="ni ni-archive-2"></i></button>
                                                            </td>
                                                        </tr>

                                                    @else
                                                                                                                
                                                        <tr>
                                                            <td>{{ $user->firstname }}</td>
                                                            <td>{{ $user->lastname }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td>                                                    
                                                                <span class="badge badge-pill badge-success">
                                                                    {{$user->status}}
                                                                </span>           
                                                            </td>
                                                            <td>@foreach ($user->merchantServices as $service)
                                                                <div class="chip">
                                                                    {{$service->billType->name}}
                                                                    <span class="closebtn" onclick="removeService(this.parentElement, {{$service->id}})">&times;</span>
                                                                </div>
                                                            @endforeach</td>
                                                            <td><button type="button" class="btn-icon-clipboard edit"
                                                                    id="{{ $user->id }}" data-original-title="Edit"
                                                                    style="width: 68px"><i class="ni ni-calendar-grid-58"></i></button>
                                                                <button type="button" class="btn-icon-clipboard delete"
                                                                    id="{{ $user->id }}" data-original-title="Delete"
                                                                    style="width: 68px"><i class="ni ni-basket"></i></button>
                                                                @if ($user->status == 'unverified')
                                                                    <button type="button" class="btn-icon-clipboard verify"
                                                                    id="{{ $user->id }}" data-original-title="Verify"
                                                                    style="width: 68px"><i class="ni ni-check-bold"></i></button>
                
                                                                @endif
                                                                <button type="button" class="btn-icon-clipboard services"
                                                                    id="{{ $user->id }}" data-original-title="Assign Services"
                                                                    style="width: 68px"><i class="ni ni-archive-2"></i></button>
                                                            </td>
                                                        </tr> 

                                                    @endif

                                                @else
                                                        
                                                        @if(($user->status) == "verified")
                                                                                                                
                                                            <tr>
                                                                <td>{{ $user->firstname }}</td>
                                                                <td>{{ $user->lastname }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->phone }}</td>
                                                                <td>                                                    
                                                                    <span class="badge badge-pill badge-danger">
                                                                        Banned
                                                                    </span>       
                                                                </td>
                                                                <td>@foreach ($user->merchantServices as $service)
                                                                    <div class="chip">
                                                                        {{$service->billType->name}}
                                                                    </div>
                                                                @endforeach</td>
                                                                <td>
                                                                    <button type="button" class="btn-icon-clipboard unlock"
                                                                    id="{{ $user->id }}" data-original-title="Unlock"
                                                                    style="width: 68px"><i class="ni ni-lock-circle-open"></i></button>
                                                                    
                                                                </td>
                                                            </tr> 

                                                        @endif
                                                        

                                                       
                                                @endif

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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none">
                    <span class="alert-inner--text"><strong>Error!</strong> <span id="error_message"></span></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" name="firstname"
                                placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname"
                                placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email"
                                placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone"
                                placeholder="Phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address"
                                placeholder="Address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Credit Limit</label>
                            <input type="text" class="form-control" name="credit_limit"
                                placeholder="Credit Limit" value="1000">
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Status</label>
                            <select class="form-control form-control-alternative" name="status">
                                <option value="unverified" selected>Un-Verified</option>
                                <option value="verified" disabled>Verified</option>
                            </select>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_form_btn">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form">
                <input type="hidden" name="delete_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to Proceed ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" id="deleteNow">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unlock Modal -->
<div class="modal fade" id="unlockModal" tabindex="-1" role="dialog" aria-labelledby="unlockModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlockModelLabel">Unlock Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Unlock_form">
                <input type="hidden" name="unlock_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to Proceed ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" id="unlockNow">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_form" method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                {{ method_field('PUT') }} 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Email">
                        </div>
                    </div>
                    <input type="hidden" name="password" value="123456">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Address">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="credit_limit">Credit Limit</label>
                            <input type="text" class="form-control" id="credit_limit" name="credit_limit"
                                placeholder="Credit Limit">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="merchant_id" name="id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Services Modal -->
<div class="modal fade" id="servicesModal" tabindex="-1" role="dialog" aria-labelledby="servicesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="servicesModalLabel">Merchant Services</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-danger alert-dismissible fade services_modal_error_msg show" role="alert" style="display: none">
                <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-inner--text"><strong>Error!</strong> <span id="services_modal_error_msg"></span></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="services_form" method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                @foreach ($billTypes as $billType)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-3">
                                <input class="custom-control-input" id="{{$billType->id}}{{$billType->name}}" name="services[{{$billType->id}}][bill_type_id]" type="checkbox">
                                <label class="custom-control-label" for="{{$billType->id}}{{$billType->name}}">{{$billType->name}}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" name="services[{{$billType->id}}][commission]" class="form-control" placeholder="Commission" />
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="hidden" id="merchant_id_for_commission" name="user_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".edit").on('click', function() {
				var id = $(this).attr('id');
				$.ajax({
					type:'GET',
					url:'<?=url("user")?>/'+id+'/edit',
					data:'_token = <?php echo csrf_token() ?>',
					success:function(data) {
						$("#merchant_id").val(data.data.id);
						$("#firstname").val(data.data.firstname);
						$("#lastname").val(data.data.lastname);
						$("#email").val(data.data.email);
						$("#phone").val(data.data.phone);
						$("#address").val(data.data.address);
						$("#credit_limit").val(data.data.credit_limit);
						$("#editModal").modal();
					}
				});
			});
            
            $(".delete").on('click', function() {
                $("#deleteModal").modal();
				var id = $(this).attr('id');
                $('input[name="delete_id"]').val(id);
			});

            $("#deleteNow").on('click', function() {
                var id = $('input[name="delete_id"]').val();
                var token = '<?=csrf_token()?>';
				$.ajax({
					type:'POST',
					url:'<?=url("user")?>/'+id,
					data:{_method: 'delete', _token :token},
					success:function(data) {
                        $("#deleteModal").modal('toggle');
						$("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("user")?>'); }, 5000);
					}
				});
            });

            $(".verify").on('click', function() {
				var id = $(this).attr('id');
                var token = '<?=csrf_token()?>';
				$.ajax({
					type:'POST',
					url:'<?=url("user/verify")?>/'+id,
					data:{_token :token},
					success:function(data) {
						$("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("user")?>'); }, 4000);
					}
				});
			});

            $('.services').on('click', function() {
                var id = $(this).attr('id'); // Merchant ID
                $("#merchant_id_for_commission").val(id);
                $.ajax({
					type:'GET',
					url:'<?=url("user/get_services")?>/'+id,
					data:'_token = <?php echo csrf_token() ?>',
					success:function(data) {
                        for (let i = 0; i < data.data.length; ++i) {
                            $('input[name="services['+data.data[i].bill_type_id+'][bill_type_id]"]').prop('checked', true);
                            $('input[name="services['+data.data[i].bill_type_id+'][commission]"]').val(data.data[i].commission);
                        }
						$('#servicesModal').modal();
					}
				});
            });

            $("#services_form").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    url: '<?=url("user/assign_services")?>',
                    dataType: "json",
                    success: function(data) {
                        $("#servicesModal").modal('toggle');
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                    },
                    error: function(data) {
                        $('#services_modal_error_msg').html(data.responseJSON.message);
                        $(".services_modal_error_msg").css('display', 'block');
                    }
                });
            });

            $("#add_form").submit(function(e) {
                e.preventDefault();
                // $('#add_form_btn').prop('disabled', true);
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    url: '<?=url("user")?>',
                    dataType: "json",
                    success: function(data) {
                        $("#addModal").modal('toggle');
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("user")?>'); }, 4000);
                    },
                    error: function(data) {
                        $("#error_message").html(data.responseJSON.messages);
                        $(".alert-danger").css('display', 'block');
                    }
                });
            });
            $("#edit_form").submit(function(event) {
                event.preventDefault();
                var editFormData = new FormData(this);
                var id = $("#merchant_id").val();
                $.ajax({
                    type: "POST",
                    data: editFormData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    url: '<?=url("user")?>/'+id,
                    dataType: "json",
                    success: function(data) {
                        $("#editModal").modal('toggle');
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("user")?>'); }, 4000);
                    },
                    error: function() {
                               
                    }
                });
            });
        });


        function removeService(element, id) {
            if (confirm("Are you sure! you want to remove this service?")) {
                $.ajax({
					type:'GET',
					url:'<?=url("user/delete_services")?>/'+id,
					data:'_token = <?php echo csrf_token() ?>',
					success:function(data) {
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
						element.style.display='none';
					}
				});
            }
        }

        $(".unlock").on('click', function() {
                $("#unlockModal").modal();
				var id = $(this).attr('id');
                $('input[name="unlock_id"]').val(id);
        });
        
        $("#unlockNow").on('click', function() {
                var id = $('input[name="unlock_id"]').val();
                var token = '<?=csrf_token()?>';
				$.ajax({
					type:'POST',
					url:'<?=url("user/unlock_merchant")?>/'+id,
					data:{ _token :token},
					success:function(data) {
                        $("#unlockModal").modal('toggle');
						$("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("user")?>'); }, 5000);
					}
				});
            });
    </script>
@endpush
