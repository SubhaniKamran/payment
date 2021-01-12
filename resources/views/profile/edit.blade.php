@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
<style>
    #profileImage {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #512DA8;
        font-size: 35px;
        color: #fff;
        text-align: center;
        line-height: 150px;
        margin-top: 20px;
    }
</style>
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->firstname,
        'description' => __('This is your profile page. You can update your Profile and account details here.'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="">
                            <div class="card-profile-image">
                                <a href="#">
                                    <div id="profileImage"></div>
                                    {{-- <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" class="rounded-circle"> --}}
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div> --}}
                    <div class="card-body pt-0 pt-md-4">
                        {{-- <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5"></div>
                            </div>
                        </div> --}}
                        <div class="text-center">
                            <h3>
                                {{ auth()->user()->firstname}} {{ auth()->user()->lastname}}<span class="font-weight-light"></span>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ auth()->user()->phone}}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ auth()->user()->address}}
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>{{ auth()->user()->email}}
                            </div>
                            <hr class="my-4" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="firstname" id="input-name" class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('firstname', auth()->user()->firstname) }}" required autofocus>

                                    @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        @if (auth()->user()->role == 'merchant')
                        <form method="post" action="{{ route('user.add_card_to_stripe') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" value="{{auth()->user()->id}}" />
                            <input type="hidden" name="stripe_customer_id" value="{{auth()->user()->stripe_customer_id}}" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Credit/Debit Card information') }}</h6>

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

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('card_number') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Card Number') }}</label>
                                    <input type="number" name="card_number" id="input-name" maxlength="16" 
                                    class="form-control form-control-alternative{{ $errors->has('card_number') ? ' is-invalid' : '' }}" 
                                    placeholder="{{ __('4242424242424242') }}" 
                                    value="{{ old('card_number', auth()->user()->card_number) }}" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                    required>

                                    @if ($errors->has('card_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('card_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('card_exp_month') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Expiry Month') }}</label>
                                    <input type="number" name="card_exp_month" id="input-email" maxlength="2" 
                                    class="form-control form-control-alternative{{ $errors->has('card_exp_month') ? ' is-invalid' : '' }}" 
                                    placeholder="{{ __('01') }}" value="{{ old('card_exp_month', auth()->user()->card_exp_month) }}" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                    required>

                                    @if ($errors->has('card_exp_month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('card_exp_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('card_cvc') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('CVC') }}</label>
                                    <input type="number" name="card_cvc" id="input-email" maxlength="3" 
                                    class="form-control form-control-alternative{{ $errors->has('card_cvc') ? ' is-invalid' : '' }}" 
                                    placeholder="{{ __('123') }}" value="{{ old('card_cvc', auth()->user()->card_cvc) }}" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                    required>

                                    @if ($errors->has('card_cvc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('card_cvc') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('card_exp_year') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Expiry Year') }}</label>
                                    <input type="number" name="card_exp_year" id="input-email" maxlength="4" 
                                    class="form-control form-control-alternative{{ $errors->has('card_exp_year') ? ' is-invalid' : '' }}" 
                                    placeholder="{{ __('2020') }}" value="{{ old('card_exp_year', auth()->user()->card_exp_year) }}" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                    required>

                                    @if ($errors->has('card_exp_year'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('card_exp_year') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4" <?php if (auth()->user()->stripe_card_id) { ?>
                                        disabled
                                    <?php } ?>>{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        @endif
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>

                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var firstname = "<?=auth()->user()->firstname?>";
            var lastname = "<?=auth()->user()->lastname?>";
            var intials = firstname.charAt(0) + lastname.charAt(0);
            $('#profileImage').text(intials);
        });
    </script>
@endpush