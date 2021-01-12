@extends('layouts.app')

@section('content')
<div class="header bg-gradient-primary pb-6 pt-5 pt-md-6">
    <!-- Form -->
    {{-- <form
        class="navbar-search navbar-search-dark form-inline mr-5 mb-4 d-none d-md-flex ml-lg-auto justify-content-end">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
            </div>
        </div>
    </form> --}}
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
                                <h3 class="mb-0">Bill Types</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-primary" id="add_bill_type_btn" data-toggle="modal" data-target="#addModal">Add Bill Type</button>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Name</th>
                                    <th scope="col" class="sort" data-sort="budget">Admin Transaction Fee</th>
                                    <th scope="col" class="sort" data-sort="status">Logo</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if($billTypes->count())
                                    @foreach($billTypes as $billType)
                                        <tr>
                                            <td>{{ $billType->name }}</td>
                                            <td>{{ $billType->admin_transaction_fee }}</td>
                                            <td><img width="60px" src="{{url('uploads')}}/{{$billType->logo}}"></td>
                                            <td><button type="button" class="btn-icon-clipboard edit"
                                                    id="{{ $billType->id }}" data-original-title="Edit"
                                                    style="width: 68px"><i class="ni ni-calendar-grid-58"></i></button>
                                                <button type="button" class="btn-icon-clipboard delete"
                                                    id="{{ $billType->id }}" data-original-title="Delete"
                                                    style="width: 68px"><i class="ni ni-basket"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td class="text-center">No Data Available!</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        {{ $billTypes->links() }}
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
                <h5 class="modal-title" id="addModalLabel">Add Bill Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_form" enctype="multipart/form-data">
            <div class="modal-body">
					@csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
								<label for="bill_name">Name</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Name">
							</div>
                        </div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="admin_transaction_fee">Admin Transaction Fee</label>
                                <input type="text" class="form-control" name="admin_transaction_fee"
                                    placeholder="Admin Transaction Fee">
                            </div>
						</div>
					</div>
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
								<label for="bill_logo">Logo</label>
                                <input type="file" class="form-control-file" name="logo"
                                    placeholder="Logo">
							</div>
						</div>
					</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
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
                <h5 class="modal-title" id="editModalLabel">Edit Bill Type</h5>
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
								<label for="bill_name">Name</label>
                                <input type="text" class="form-control" id="bill_name" name="name"
                                    placeholder="Name">
							</div>
                        </div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="admin_transaction_fee">Admin Transaction Fee</label>
                                <input type="text" class="form-control" id="admin_transaction_fee" name="admin_transaction_fee"
                                    placeholder="Admin Transaction Fee">
                            </div>
						</div>
					</div>
					<div class="row">
                        <div class="col-md-12">
							<div class="form-group">
								<label for="bill_logo">Logo</label>
                                <input type="file" class="form-control-file" id="bill_logo" name="logo"
                                    placeholder="Logo">
							</div>
						</div>
                    </div>
                    <input type="hidden" id="bill_id" name="id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
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
                        Are you sure you want to Delete ?
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

@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".edit").on('click', function() {
				var id = $(this).attr('id');
				$.ajax({
					type:'GET',
					url:'<?=url("bill")?>/'+id+'/edit',
					data:'_token = <?php echo csrf_token() ?>',
					success:function(data) {
						$("#bill_id").val(data.data.id);
						$("#bill_name").val(data.data.name);
						$("#admin_transaction_fee").val(data.data.admin_transaction_fee);
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
					url:'<?=url("bill")?>/'+id,
					data:{_method: 'delete', _token :token},
					success:function(data) {
                        $("#deleteModal").modal('toggle');
						$("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("bill")?>'); }, 5000);
					}
				});
            });

            $("#add_form").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    url: '<?=url("bill")?>',
                    dataType: "json",
                    success: function(data) {
                        $("#addModal").modal('toggle');
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("bill")?>'); }, 4000);
                    },
                    error: function() {
                               
                    }
                });
            });
            $("#edit_form").submit(function(event) {
                event.preventDefault();
                var editFormData = new FormData(this);
                var id = $("#bill_id").val();
                $.ajax({
                    type: "POST",
                    data: editFormData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    url: '<?=url("bill")?>/'+id,
                    dataType: "json",
                    success: function(data) {
                        $("#editModal").modal('toggle');
                        $("#success_message").html(data.message);
                        $(".alert-success").css('display', 'block');
                        setTimeout(function(){ window.location.replace('<?=url("bill")?>'); }, 4000);
                    },
                    error: function() {
                               
                    }
                });
            });
        });

    </script>
@endpush
