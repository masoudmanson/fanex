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
                                    <img src="{{ asset('css/images/app-icon.png') }}" alt="Fanex Logo">
                                </div>
                                <div class="col-xs-8 right-align">
                                    <p>@lang('payment.date') @lang('payment.invDate', ['dateEn' => $date->format('d M Y, H:i:s'), 'dateFa' => jdate($date)->format('%Y %B %d, H:i:s')])</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>@lang('payment.prTitle')</h2>

                                    <p>@lang('payment.prText', ['amount'=>'1500 EUR'])</p>

                                    <div class="proforma-heading">@lang('payment.prApplicant')</div>

                                    {{-- Applicant Details --}}
                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appTitle')</p></div>
                                            <div class="col-xs-12 col-sm-6">Masoud Amjadi</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appId')</p></div>
                                            <div class="col-xs-12 col-sm-6">1640113886</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appDob')</p></div>
                                            <div class="col-xs-12 col-sm-6">26 June 1991</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appPob')</p></div>
                                            <div class="col-xs-12 col-sm-6">Iran</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appAddress')</p></div>
                                            <div class="col-xs-12 col-sm-6">#13, Zaratash Alley, Ghoddosi St., Ghasr
                                                Sq., Tehran, Iran
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appPostalCode')</p></div>
                                            <div class="col-xs-12 col-sm-6">12326-45879</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appTel')</p></div>
                                            <div class="col-xs-12 col-sm-6">021 548 5874</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appMobile')</p></div>
                                            <div class="col-xs-12 col-sm-6">0914 840 1824</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appEmail')</p></div>
                                            <div class="col-xs-12 col-sm-6">masoudmanson@gmail.com</div>
                                        </li>

                                    </ul>

                                    <div class="proforma-heading">
                                        @lang('payment.prBeneficiary')
                                    </div>

                                    {{-- Beneficiary Details --}}
                                    <ul>
                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfName')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->firstname . ' ' . $beneficiary->lastname }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfCountry')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $countries[$beneficiary->country] }}
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appAddress')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->address }}
                                            </div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appTel')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->tel }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.appFax')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->fax }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfBankName')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->bank_name }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfBranch')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->branch_name }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfSwift')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->swift_code }}</div>
                                        </li>

                                        <li class="row mx-0">
                                            <div class="col-xs-12 col-sm-6"><p>@lang('payment.bnfIban')</p></div>
                                            <div class="col-xs-12 col-sm-6">{{ $beneficiary->iban_code }}</div>
                                        </li>

                                    </ul>

                                    {{-- Print Proforma --}}
                                    <a href="#" class="invoice-print" data-toggle="tooltip" id="print-pdf"
                                       title="@lang('payment.print')">
                                        <i class="icon-printer"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <form action="/invoice" method="post">
                        {{ csrf_field() }}

                        <div class="checkbox row mx-0 my-4 p-0">
                            <label><input type="checkbox" id="proforma-terms" name="terms" value="1">@lang('payment.agreement')</label>
                        </div>

                        <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                            <a href="{{ URL::previous() }}" class="btn fanexBtnNoline">@lang('payment.prfBack')</a>
                        </div>

                        <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                            <input type="hidden" value="{{ $transaction_sign }}" name="transaction_sign">
                            <input type="submit" disabled="disabled" id="proforma-btn" class="btn fanexBtnOutlineGrey"
                                   value="@lang('payment.prfPay')" title="Please Agree to the Terms & Conditions">
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
        $(document).ready(function() {
            $('#proforma-btn').attr('disabled', 'disabled');
            $('#proforma-terms').attr('checked', false);

            $('#proforma-terms').change(function() {
                if(this.checked) {
                    $('#proforma-btn').removeAttr('disabled');
                }
                else {
                    $('#proforma-btn').attr('disabled', 'disabled');
                }
            });
        });

            var form = $('#pdfWrapper'),
                cache_width = form.width(),
                a4 = [595.28, 841.89]; // for a4 size paper width and height

            $('#print-pdf').on('click', function() {
                $('body').scrollTop(0);
                createPDF();
            });
            //create pdf
            function createPDF() {
                getCanvas().then(function(canvas) {
                    var
                        img = canvas.toDataURL("image/png"),
                        doc = new jsPDF({
                            unit: 'px',
                            format: 'a4'
                        });
                    doc.addImage(img, 'PNG', 5, 5);
                    doc.save('invoice.pdf');
                    form.width(cache_width);
                });
            }

            // create canvas object
            function getCanvas() {
                form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
                return html2canvas(form, {
                    imageTimeout: 2000,
                    removeContainer: true
                });
            }

    </script>
@endsection