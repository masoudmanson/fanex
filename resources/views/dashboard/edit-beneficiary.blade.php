@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            {{-- SideBar --}}
            @include('partials.profileSidebar', ["page" => "beneficiaries"])

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0" style="margin-top: 30px;">

                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-11 px-0">
                        <h2 class="dash-subtitle m-0">@lang('profile.bnfEdit') {{ $beneficiary->firstname . ' ' . $beneficiary->lastname }}</h2>
                    </div>

                    <div class="col-xs-1 px-0">
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    {{-- Add Beneficiary Form --}}
                    <form action="/beneficiaries" method="post" id="add-bnf-form">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">

                        {{-- Firstname --}}
                        <div class="form-group bsWrapper">
                            @if($errors->first('firstname'))
                                <label for="firstname" class="fanexLabel">@lang('payment.bnfFirstname')</label>
                            @endif
                            <i class="icon-user bsIcon"></i>
                            <input type="text"
                                   class="form-control fanexInput @if($errors->first('firstname')) fanexInputError @else fanexInputWhite @endif"
                                   id="bnf-firstname"
                                   name="firstname" placeholder="@lang('payment.bnfFirstname')" autocomplete="off"
                                   value="{{ old('firstname') }}">

                            @if($errors->first('firstname'))
                                <div class="fanexDanger">{{ $errors->first('firstname') }}</div>
                            @endif
                        </div>

                        <div id="add-new-bnf-ajax">

                            {{-- Lastname --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('lastname'))
                                    <label for="lastname" class="fanexLabel">@lang('payment.bnfLastname')</label>
                                @endif
                                <i class="icon-user bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('lastname')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-lastname"
                                       name="lastname" placeholder="@lang('payment.bnfLastname')"
                                       autocomplete="off" value="{{ old('lastname') }}">
                                @if($errors->first('lastname'))
                                    <div class="fanexDanger">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('account_number'))
                                    <label for="account_number" class="fanexLabel">@lang('payment.bnfCC')</label>
                                @endif
                                <i class="icon-card bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput credit-card @if($errors->first('account_number')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-accountnumber"
                                       name="account_number" placeholder="@lang('payment.bnfCC')" autocomplete="off"
                                       value="{{ old('account_number') }}">

                                @if($errors->first('account_number'))
                                    <div class="fanexDanger">{{ $errors->first('account_number') }}</div>
                                @endif
                            </div>

                            {{-- country --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('country'))
                                    <label for="country" class="fanexLabel">@lang('payment.bnfCountry')</label>
                                @endif
                                <i class="icon-globe bsIcon"></i>

                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="country">
                                    @foreach($countries as $key=>$value)
                                        <option value="{{ $key }}" class="enable">{{ $value }}</option>
                                    @endforeach
                                </select>

                                @if($errors->first('country'))
                                    <div class="fanexDanger">{{ $errors->first('country') }}</div>
                                @endif
                            </div>

                            {{-- Address --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('address'))
                                    <label for="address" class="fanexLabel">@lang('payment.bnfAddr')</label>
                                @endif
                                <i class="icon-globe bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('address')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-address"
                                       name="address" placeholder="@lang('payment.bnfAddr')" autocomplete="off"
                                       value="{{ old('address') }}">

                                @if($errors->first('address'))
                                    <div class="fanexDanger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('tel'))
                                    <label for="tel" class="fanexLabel">@lang('payment.bnfPhone')</label>
                                @endif
                                <i class="icon-mobile bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('tel')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-phone"
                                       name="tel" placeholder="@lang('payment.bnfPhone')" autocomplete="off"
                                       value="{{ old('tel') }}">

                                @if($errors->first('tel'))
                                    <div class="fanexDanger">{{ $errors->first('tel') }}</div>
                                @endif
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('fax'))
                                    <label for="fax" class="fanexLabel">@lang('payment.bnfFax')</label>
                                @endif
                                <i class="icon-fax bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('fax')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-fax"
                                       name="fax" placeholder="@lang('payment.bnfFax')" autocomplete="off"
                                       value="{{ old('fax') }}">

                                @if($errors->first('fax'))
                                    <div class="fanexDanger">{{ $errors->first('fax') }}</div>
                                @endif
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('bank_name'))
                                    <label for="bank_name" class="fanexLabel">@lang('payment.bnfBank')</label>
                                @endif
                                <i class="icon-bank bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('bank_name')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-bankname"
                                       name="bank_name" placeholder="@lang('payment.bnfBank')" autocomplete="off"
                                       value="{{ old('bank_name') }}">

                                @if($errors->first('bank_name'))
                                    <div class="fanexDanger">{{ $errors->first('bank_name') }}</div>
                                @endif
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('branch_name'))
                                    <label for="branch_name" class="fanexLabel">@lang('payment.bnfBranch')</label>
                                @endif
                                <i class="icon-branch bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('branch_name')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-branch"
                                       name="branch_name" placeholder="@lang('payment.bnfBranch')"
                                       autocomplete="off" value="{{ old('branch_name') }}">

                                @if($errors->first('branch_name'))
                                    <div class="fanexDanger">{{ $errors->first('branch_name') }}</div>
                                @endif
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('swift_code'))
                                    <label for="swift_code" class="fanexLabel">@lang('payment.bnfSwift')</label>
                                @endif
                                <i class="icon-swift bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('swift_code')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-swift"
                                       name="swift_code" placeholder="@lang('payment.bnfSwift')" autocomplete="off"
                                       value="{{ old('swift_code') }}">

                                @if($errors->first('swift_code'))
                                    <div class="fanexDanger">{{ $errors->first('swift_code') }}</div>
                                @endif
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('iban_code'))
                                    <label for="iban_code" class="fanexLabel">@lang('payment.bnfIban')</label>
                                @endif
                                <i class="icon-code bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput  @if($errors->first('iban_code')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-iban"
                                       name="iban_code" placeholder="@lang('payment.bnfIban')" autocomplete="off"
                                       value="{{ old('iban_code') }}">

                                @if($errors->first('iban_code'))
                                    <div class="fanexDanger">{{ $errors->first('iban_code') }}</div>
                                @endif
                            </div>
                        </div>

                        {{--Form Actions--}}
                        <div class="row p-0 m-0">
                            <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                                <a href="/beneficiaries" class="btn fanexBtnNoline" id="backBtn"
                                   value="Back">@lang('payment.back')</a>
                            </div>
                            <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                                <input type="submit" class="btn fanexBtnOrange" value="@lang('profile.bnfSave')"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker('val', 'IR');
        });
    </script>
@endsection