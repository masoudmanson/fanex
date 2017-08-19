@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>@lang('payment.prfTitle')</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-xs-12 p-0">
                        <h2 class="dash-subtitle">@lang('payment.prfSubtitle')</h2>
                        <div class="proforma-wrapper mb-4" id="pdfWrapper">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p class="fanex-text-orange" id="fanex-logo"><i class="icon-fanex"></i></p>
                                </div>
                                <div class="col-xs-8 right-align">
                                    <p>@lang('payment.date') @lang('payment.invDate', ['dateEn' => $date->format('d M Y, H:i:s'), 'dateFa' => jdate($date)->format('%Y %B %d, H:i:s')])</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="proforma-h2">@lang('payment.prTitle')</h2>

                                    {{--<p class="proforma-p">@lang('payment.prText', ['amount'=>number_format($amount, 2).' '.$currency])</p>--}}

                                    {{-- Payment Details --}}
                                    <div class="proforma-heading">@lang('payment.prPayment')</div>
                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="proforma-p">@lang('payment.invAmount')</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">{{ number_format($amount, 2) . ' ' . $currency }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="proforma-p">@lang('payment.invExp')</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">0 @lang('index.formRials')</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="proforma-p">@lang('payment.invTax')</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">0 @lang('index.formRials')</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6">
                                                <p class="proforma-p">@lang('payment.invSum')</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <p>{{ number_format($amount, 2) . ' ' . $currency . ' + &rlm; 0' }} @lang('index.formRials')</p>
                                                <p class="acc-factor-sum">
                                                   = {{ number_format($payable, 2) }}  @lang('index.formRials')</p>
                                            </div>
                                        </li>
                                    </ul>

                                    {{-- Applicant Details --}}
                                    <div class="proforma-heading">@lang('payment.prApplicant')</div>
                                    <ul>
                                        @if($user->firstname && $user->lastname)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appTitle')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->firstname . ' ' . $user->lastname }}</div>
                                            </li>
                                        @endif

                                        @if($user->identity_number)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6">
                                                    <p class="proforma-p">@lang('payment.appId')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->identity_number }}</div>
                                            </li>
                                        @endif

                                        @if($user->date_of_birth)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appDob')</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">@lang('payment.invDate', ['dateEn' => $user->date_of_birth->format('d M Y, H:i:s'), 'dateFa' => jdate($user->date_of_birth)->format('%Y %B %d, H:i:s')])</div>
                                            </li>
                                        @endif

                                        @if($user->place_of_birth)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6">
                                                    <p class="proforma-p">@lang('payment.appPob')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->place_of_birth }}</div>
                                            </li>
                                        @endif

                                        @if($user->address)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appAddress')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->address }}</div>
                                            </li>
                                        @endif

                                        @if($user->postal_code)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appPostalCode')</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->postal_code }}</div>
                                            </li>
                                        @endif

                                        @if($user->tel)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appTel')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->tel }}</div>
                                            </li>
                                        @endif

                                        @if($user->mobile)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appMobile')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->mobile }}</div>
                                            </li>
                                        @endif

                                        @if($user->email)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6"><p
                                                            class="proforma-p">@lang('payment.appEmail')</p></div>
                                                <div class="col-xs-12 col-sm-6">{{ $user->email }}</div>
                                            </li>
                                        @endif

                                    </ul>

                                    <div class="proforma-heading">
                                        @lang('payment.prBeneficiary')
                                    </div>

                                    {{-- Beneficiary Details --}}
                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfName')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->firstname . ' ' . $beneficiary->lastname }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfCountry')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $countries[$beneficiary->country] }}
                                            </div>
                                        </li>

                                        @if($beneficiary->address)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6">
                                                    <p class="proforma-p">@lang('payment.appAddress')</p></div>
                                                <div class="col-xs-12 col-sm-6">
                                                    {{ $beneficiary->address }}
                                                </div>
                                            </li>
                                        @endif

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.appTel')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->tel }}</div>
                                        </li>

                                        @if($beneficiary->fax)
                                            <li class="row mx-0">
                                                <div class="col-xs-12 col-sm-6">
                                                    <p class="proforma-p">@lang('payment.appFax')</p></div>
                                                <div class="col-xs-12 col-sm-6">
                                                    {{ $beneficiary->fax }}
                                                </div>
                                            </li>
                                        @endif

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfBankName')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->bank_name }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfBranch')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->branch_name }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfSwift')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->swift_code }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p
                                                        class="proforma-p">@lang('payment.bnfIban')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->iban_code }}</div>
                                        </li>

                                    </ul>

                                    {{-- Print Proforma --}}
                                    {{--<a href="#" class="invoice-print" data-toggle="tooltip" id="print-pdf"--}}
                                    <a href="" class="invoice-print" data-toggle="tooltip" id="pdf-test"
                                       title="@lang('payment.print')">
                                        <i class="icon-printer"></i>
                                        <span>@lang('payment.print')</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0 not-print">
                    <form action="{{ route('issue_invoice') }}" method="post">
                        {{ csrf_field() }}
                        <div class="checkbox row mx-0 my-4 p-0">
                            <label><input type="checkbox" id="proforma-terms" name="terms"
                                          value="1">@lang('payment.agreement')</label>
                        </div>

                        <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                            <a href="{{ URL::previous() }}" class="btn fanexBtnNoline">@lang('payment.prfBack')</a>
                        </div>

                        <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                            <input type="hidden" value="{{ $transaction_sign }}" name="transaction_sign">
                            <input type="submit" disabled="disabled" id="proforma-btn" class="btn fanexBtnOutlineGrey"
                                   value="@lang('payment.prfPay')" title="@lang('payment.accept')">
                        </div>
                    </form>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 4])
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    <script>
        // Countdown Rates Exiration Time
        var finish = {{ $finish_time }};
        countdown(finish);

        $(document).ready(function () {
            $('#proforma-btn').attr('disabled', 'disabled');
            $('#proforma-terms').attr('checked', false);

            $('#proforma-terms').change(function () {
                if (this.checked) {
                    $('#proforma-btn').removeAttr('disabled');
                }
                else {
                    $('#proforma-btn').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection