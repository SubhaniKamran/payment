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

                <form action="setting" method="POST">
                     @csrf
                     <div class="form-row align-items-center">
                        <div class="form-group col-sm-6 ">
                            <label class="text-white" for="d_commission">Default Admin Transaction Fee</label>
                           <input type="number" class="form-control text-primary" value="{{$defaultCommission[0]->commission ?? 0}}" name="admin_transaction_fee" id="d_commission" placeholder="Enter Admin Transaction Fee">
                        </div>
                        <button type="submit" name="comssion" class="btn btn-Default mt-2">Save</button>
                    </div>
                </form>
                <form action="setting" method="POST">
                    @csrf
                    <div class="form-row align-items-center">
                        <div class="form-group col-sm-6 ">
                            <label class="text-white" for="d_commission">Instant Payment Fee</label>
                           <input type="number" class="form-control text-primary" value="{{$defaultCommission[1]->commission ?? 0}}" name="instant_payment_fee" id="d_commission" placeholder="Enter Instant Payment Fee">
                        </div>
                        <button type="submit" name="comssion" class="btn btn-Default mt-2">Save</button>
                    </div>
                </form>
                <hr class="my-4" style="border: 1px solid white;" />
                <h1 class="text-white">ACH Transaction Schedule</h1>
                <form method="POST" action="{{url('update_ach_schdule')}}">
                    @csrf
                    <div class="form-row align-items-center">
                       <div class="form-group col-sm-6 ">
                            <label class="text-white" for="day1">Day 1</label>
                            <select id="day1" name="day1" class="form-control">
                                <option value="saturday" <?=$achSchedule->day1 == 'saturday' ? 'selected="selected"' : ''?>>Saturday</option>
                                <option value="sunday" <?=$achSchedule->day1 == 'sunday' ? 'selected="selected"' : ''?>>Sunday</option>
                                <option value="monday" <?=$achSchedule->day1 == 'monday' ? 'selected="selected"' : ''?>>Monday</option>
                                <option value="tuesday" <?=$achSchedule->day1 == 'tuesday' ? 'selected="selected"' : ''?>>Tuesday</option>
                                <option value="wednesday" <?=$achSchedule->day1 == 'wednesday' ? 'selected="selected"' : ''?>>Wednesday</option>
                                <option value="thursday" <?=$achSchedule->day1 == 'thursday' ? 'selected="selected"' : ''?>>Thursday</option>
                                <option value="friday" <?=$achSchedule->day1 == 'friday' ? 'selected="selected"' : ''?>>Friday</option>
                            </select>
                       </div>
                   </div>
                   <div class="form-row align-items-center">
                       <div class="form-group col-sm-6 ">
                            <label class="text-white" for="day2">Day 2</label>
                            <select id="day2" name="day2" class="form-control">
                                <option value="saturday" <?=$achSchedule->day2 == 'saturday' ? 'selected="selected"' : ''?>>Saturday</option>
                                <option value="sunday" <?=$achSchedule->day2 == 'sunday' ? 'selected="selected"' : ''?>>Sunday</option>
                                <option value="monday" <?=$achSchedule->day2 == 'monday' ? 'selected="selected"' : ''?>>Monday</option>
                                <option value="tuesday" <?=$achSchedule->day2 == 'tuesday' ? 'selected="selected"' : ''?>>Tuesday</option>
                                <option value="wednesday" <?=$achSchedule->day2 == 'wednesday' ? 'selected="selected"' : ''?>>Wednesday</option>
                                <option value="thursday" <?=$achSchedule->day2 == 'thursday' ? 'selected="selected"' : ''?>>Thursday</option>
                                <option value="friday" <?=$achSchedule->day2 == 'friday' ? 'selected="selected"' : ''?>>Friday</option>
                            </select>
                       </div>
                   </div>
                   <button type="submit" class="btn btn-Default mt-2">Save</button>
               </form>

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
