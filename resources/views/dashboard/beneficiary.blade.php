@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>@lang('payment.bnfTitle')</b></h1>
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0" id="bnf-slc-container">
                    {{-- Select From Existing Beneficiaries --}}
                    <div class="col-md-6 col-sm-12 p-0 pr-lg-3">
                        <h2 class="dash-subtitle">@lang('payment.bnfSelect')</h2>

                        {{-- Select Beneficiary Box --}}
                        <form action="{{ route('proforma_with_selected_bnf') }}" method="POST" id="select-bnf-form">
                            {{ csrf_field() }}
                            {{-- Existing Beneficiaries --}}
                            <div class="form-group bsWrapper mim">
                                <i class="icon-user bsIcon"></i>
                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="bnf"
                                        id="bnfSelect">
                                    <option selected disabled value="0">@lang('payment.bnfSelect')</option>
                                    @foreach($beneficiaries as $bnf)
                                        <option value="{{ $bnf['id'] }}"
                                                class="enable">{{ $bnf['firstname']. ' ' .$bnf['lastname'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Show Beneficiary information --}}
                            <div id="bnf-ajax-div" style="display: none;">
                                {{-- Firstname --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormFirstname')">
                                    <i class="icon-user bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-name">
                                        @lang('payment.bnfFirstname')
                                    </div>
                                </div>

                                {{-- Account Number --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormCC')">
                                    <i class="icon-card bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-accountnumber">
                                        @lang('payment.bnfCC')
                                    </div>
                                </div>

                                {{-- Country --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormCountry')">
                                    <i class="icon-globe bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-country">
                                        @lang('payment.bnfCountry')
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormAddr')">
                                    <i class="icon-globe bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-address">
                                        @lang('payment.bnfAddr')
                                    </div>
                                </div>

                                {{-- Phone Number --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormPhone')">
                                    <i class="icon-mobile bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-phone">
                                        @lang('payment.bnfPhone')
                                    </div>
                                </div>

                                {{-- Fax Number --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormFax')">
                                    <i class="icon-fax bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-fax">
                                        @lang('payment.bnfFax')
                                    </div>
                                </div>

                                {{-- Bank Name --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormBank')">
                                    <i class="icon-bank bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-bankname">
                                        @lang('payment.bnfBank')
                                    </div>
                                </div>

                                {{-- Branch Address --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormBranch')">
                                    <i class="icon-branch bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-branch">
                                        @lang('payment.bnfBranch')
                                    </div>
                                </div>

                                {{-- Swift Code --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormSwift')">
                                    <i class="icon-swift bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-swift">
                                        @lang('payment.bnfSwift')
                                    </div>
                                </div>

                                {{-- iBan Number --}}
                                <div class="form-group bsWrapper" title="@lang('payment.bnfFormIban')">
                                    <i class="icon-code bsIcon"></i>
                                    <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-iban">
                                        @lang('payment.bnfIban')
                                    </div>
                                </div>

                            </div>

                            {{-- Submit the form --}}
                            <div class="col-xs-12 p-0" style="float: none;">
                                <input type="hidden" name="hash" value="" id="bnfSelectHash">
                                <input type="submit" id="bnfSelectSubmit" class="btn fanexBtnOutlineGrey"
                                       value="@lang('payment.showProformaSelect')" style="display: none;"/>
                            </div>
                        </form>
                    </div>

                    {{-- Create a New Benificiary --}}
                    <div class="col-md-6 col-sm-12 p-0 pl-lg-3">
                        <h2 class="dash-subtitle">@lang('payment.bnfNew')</h2>

                        {{-- Add Beneficiary Form --}}
                        <form action="{{ route('proforma_with_new_bnf') }}" method="post" id="add-bnf-form">
                            {{ csrf_field() }}

                            @include('partials.new-beneficiary')

                            {{-- Form Submition --}}
                            <div class="col-xs-12 p-0 sb-4">
                                <input type="submit" id="bnfSaveSubmit" class="btn fanexBtnOutlineGrey"
                                       value="@lang('payment.showProformaSave')" style="display: none;"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 3])
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    <script>
        var beneficiaries = {!! $beneficiaries !!};
        var countries = {!! $countries !!};
        $(document).ready(function () {
            $('#bnfCountry').selectpicker('val', 'IR');

            $('#bnfSelect').on('change blur', function () {
                $('#bnfSaveSubmit').fadeOut(200);
                $('#bnfSelectSubmit').fadeIn(200);
                $('#add-bnf-form').css({"opacity": 0.5});
                $('#add-new-bnf-ajax').slideUp(200);

                var bnf_id = $(this).val();
                var bnf = $.grep(beneficiaries, function (e) {
                    return e.id == bnf_id;
                })[0];
                $('#bnfSelectHash').val(bnf.hash);

                $('#bnf-ajax-name').text(bnf.firstname + ' ' + bnf.lastname);
                $('#bnf-ajax-accountnumber').text(bnf.account_number);
                if (bnf.address)
                    $('#bnf-ajax-address').text(bnf.address);
                $('#bnf-ajax-country').text(countries[bnf.country]);
                $('#bnf-ajax-phone').text(bnf.tel);
                if (bnf.fax)
                    $('#bnf-ajax-fax').text(bnf.fax);
                $('#bnf-ajax-bankname').text(bnf.bank_name);
                $('#bnf-ajax-branch').text(bnf.branch_name);
                $('#bnf-ajax-swift').text(bnf.swift_code);
                $('#bnf-ajax-iban').text(bnf.iban_code);

                $('#bnf-ajax-div').slideDown(300);
            });

            $('#add-bnf-form input').on('focus', function () {
                $('#bnfSelect').val(0);
                $('.selectpicker').selectpicker('refresh');
                $('#add-bnf-form').css({"opacity": 1});
                $('#add-new-bnf-ajax').slideDown(200);
                $('#bnf-ajax-div').slideUp(300);
                $('#bnfSaveSubmit').fadeIn(200);
                $('#bnfSelectSubmit').fadeOut(200);
            });
        });
    </script>
@endsection