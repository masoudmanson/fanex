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
                        <h2 class="dash-subtitle m-0">@lang('payment.bnfEdit', ['user' => $beneficiary->firstname . ' ' . $beneficiary->lastname])</h2>
                    </div>

                    <div class="col-xs-1 px-0">
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    {{-- Add Beneficiary Form --}}
                    <form action="/beneficiaries/{{ $beneficiary->id }}" method="POST" id="add-bnf-form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        {{-- Firstname --}}
                        <div class="form-group bsWrapper">
                            @if($errors->first('firstname'))
                                <label for="firstname"
                                       class="fanexLabel">@lang('payment.bnfFormFirstname')</label>
                            @endif
                            <i class="icon-user bsIcon"></i>
                            <div class="mandatoryField">
                                <input type="text"
                                       class="onlyAlpha form-control fanexInput @if($errors->first('firstname')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-firstname"
                                       name="firstname" placeholder="@lang('payment.bnfFormFirstname')"
                                       autocomplete="off"
                                       value="{{ $beneficiary->firstname }}">
                            </div>
                            @if($errors->first('firstname'))
                                <div class="fanexDanger">{{ $errors->first('firstname') }}</div>
                            @endif
                        </div>

                        <div id="add-new-bnf-ajax">

                            {{-- Lastname --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('lastname'))
                                    <label for="lastname" class="fanexLabel">@lang('payment.bnfFormLastname')</label>
                                @endif
                                <i class="icon-user bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="onlyAlpha form-control fanexInput  @if($errors->first('lastname')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-lastname"
                                           name="lastname" placeholder="@lang('payment.bnfFormLastname')"
                                           autocomplete="off" value="{{ $beneficiary->lastname }}">
                                </div>
                                @if($errors->first('lastname'))
                                    <div class="fanexDanger">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('account_number'))
                                    <label for="account_number" class="fanexLabel">@lang('payment.bnfFormCC')</label>
                                @endif
                                <i class="icon-card bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="noSpecialChars onlyDigits form-control fanexInput  @if($errors->first('account_number')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-accountnumber"
                                           name="account_number" placeholder="@lang('payment.bnfFormCC')"
                                           autocomplete="off"
                                           value="{{ $beneficiary->account_number }}">
                                </div>

                                @if($errors->first('account_number'))
                                    <div class="fanexDanger">{{ $errors->first('account_number') }}</div>
                                @endif
                            </div>

                            {{-- country --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('country'))
                                    <label for="address" class="fanexLabel">@lang('payment.bnfFormCountry')</label>
                                @endif
                                <i class="icon-globe bsIcon"></i>

                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="country" id="bnfCountry">
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
                                    <label for="address" class="fanexLabel">@lang('payment.bnfFormAddr')</label>
                                @endif
                                <i class="icon-globe bsIcon"></i>
                                <input type="text"
                                       class="onlyAlphaDash form-control fanexInput  @if($errors->first('address')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-address"
                                       name="address" placeholder="@lang('payment.bnfFormAddr')" autocomplete="off"
                                       value="{{ $beneficiary->address }}">

                                @if($errors->first('address'))
                                    <div class="fanexDanger">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('tel'))
                                    <label for="tel" class="fanexLabel">@lang('payment.bnfFormPhone')</label>
                                @endif
                                <i class="icon-mobile bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="noSpecialChars onlyDigits form-control fanexInput  @if($errors->first('tel')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-phone"
                                           name="tel" placeholder="@lang('payment.bnfFormPhone')" autocomplete="off"
                                           value="{{ $beneficiary->tel }}">
                                </div>

                                @if($errors->first('tel'))
                                    <div class="fanexDanger">{{ $errors->first('tel') }}</div>
                                @endif
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('fax'))
                                    <label for="fax" class="fanexLabel">@lang('payment.bnfFormFax')</label>
                                @endif
                                <i class="icon-fax bsIcon"></i>
                                <input type="text"
                                       class="noSpecialChars onlyDigits form-control fanexInput  @if($errors->first('fax')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                       id="bnf-fax"
                                       name="fax" placeholder="@lang('payment.bnfFormFax')" autocomplete="off"
                                       value="{{ $beneficiary->fax }}">

                                @if($errors->first('fax'))
                                    <div class="fanexDanger">{{ $errors->first('fax') }}</div>
                                @endif
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('bank_name'))
                                    <label for="bank_name" class="fanexLabel">@lang('payment.bnfFormBank')</label>
                                @endif
                                <i class="icon-bank bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="onlyAlphaDash form-control fanexInput  @if($errors->first('bank_name')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-bankname"
                                           name="bank_name" placeholder="@lang('payment.bnfFormBank')"
                                           autocomplete="off"
                                           value="{{ $beneficiary->bank_name }}">
                                </div>

                                @if($errors->first('bank_name'))
                                    <div class="fanexDanger">{{ $errors->first('bank_name') }}</div>
                                @endif
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper ">
                                @if($errors->first('branch_name'))
                                    <label for="branch_name" class="fanexLabel">@lang('payment.bnfFormBranch')</label>
                                @endif
                                <i class="icon-branch bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="onlyAlphaDash form-control fanexInput  @if($errors->first('branch_name')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-branch"
                                           name="branch_name" placeholder="@lang('payment.bnfFormBranch')"
                                           autocomplete="off" value="{{ $beneficiary->branch_name }}">
                                </div>

                                @if($errors->first('branch_name'))
                                    <div class="fanexDanger">{{ $errors->first('branch_name') }}</div>
                                @endif
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('swift_code'))
                                    <label for="swift_code" class="fanexLabel">@lang('payment.bnfFormSwift')</label>
                                @endif
                                <i class="icon-swift bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="onlyAlphanumeric form-control fanexInput  @if($errors->first('swift_code')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-swift"
                                           name="swift_code" placeholder="@lang('payment.bnfFormSwift') @lang('payment.bnfFormSwiftSample')"
                                           autocomplete="off"
                                           value="{{ $beneficiary->swift_code }}">
                                </div>

                                @if($errors->first('swift_code'))
                                    <div class="fanexDanger">{{ $errors->first('swift_code') }}</div>
                                @endif
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                @if($errors->first('iban_code'))
                                    <label for="iban_code" class="fanexLabel">@lang('payment.bnfFormIban')</label>
                                @endif
                                <i class="icon-code bsIcon"></i>
                                <div class="mandatoryField">
                                    <input type="text"
                                           class="onlyAlphanumeric form-control fanexInput  @if($errors->first('iban_code')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-iban"
                                           name="iban_code" placeholder="@lang('payment.bnfFormIban') &rlm; @lang('payment.bnfFormIbanSample')"
                                           autocomplete="off"
                                           dir="auto"
                                           value="{{ $beneficiary->iban_code }}">
                                </div>

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
            $('.selectpicker').selectpicker();
            $('#bnfCountry').selectpicker('val', '{{ $beneficiary->country }}');
        });
    </script>
@endsection