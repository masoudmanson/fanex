@foreach($beneficiaries as $bnf)
    <div class="panel panel-default filtered ctr-{{ $bnf->country }}" id="bnf-{{ $bnf->id }}">
        <div class="panel-heading">
            <div class="row p-0 m-0">
                <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip"
                     title="@lang('profile.bnfName')">
                    <i class="icon-user acc-main-icon hidden-xs"></i>
                    <span class="acc-user"><b>{{ $bnf->firstname . ' ' . $bnf->lastname }}</b></span>
                </div>
                <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip"
                     title="@lang('payment.bnfFormCC')">
                    <span class="acc-date">{{ $bnf->account_number }}</span>
                </div>
                <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip"
                     title="@lang('profile.bnfCountry')">
                    <span class="acc-cash">{{ $countries[$bnf->country] }}</span>
                </div>
                <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip"
                     title="@lang('payment.bnfFormPhone')">
                    <span class="acc-date">{{ $bnf->tel }}</span>
                </div>
                <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                    <a href="/send/{{ $bnf->id }}">
                        <i class="icon-trans" title="@lang('profile.bnfSendMoney')"></i>
                    </a>
                    {{--<a href="/">--}}
                    {{--<i class="icon-chat hidden-xs" title="@lang('profile.bnfSendMsg')"></i>--}}
                    {{--</a>--}}
                    <a href="/beneficiaries/{{ $bnf->id }}/edit">
                        <i class="icon-edit" title="@lang('profile.bnfEdit')"></i>
                    </a>

                    <a href="javascript:;" onclick="deleteBnf({{ $bnf->id }})">
                        <i class="icon-delete" title="@lang('profile.bnfDelete')"></i>
                    </a>
                </div>
                <a class="col-md-1 col-sm-1 col-xs-1 accordion-toggle" data-toggle="collapse"
                   data-parent="#ajax-beneficiary-list" href="{{ "#row".$bnf->id }}">
                    <span class="acc-arrow"></span>
                </a>
            </div>
        </div>

        <div id="{{ "row".$bnf->id }}" class="panel-collapse collapse">
            <div class="panel-body p-0">
                <div class="row m-0 p-0">
                    <div class="col-sm-12 col-md-6 p-0 m-0">
                        {{-- Beneficiary Name --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('profile.bnfName')">
                            <i class="icon-user bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-firstname">
                                {{ $bnf->firstname . ' ' . $bnf->lastname }}
                            </div>
                        </div>

                        {{--Country --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('profile.bnfCountry')">
                            <i class="icon-globe bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-country">
                                {{ $countries[$bnf->country] }}
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormAddr')">
                            <i class="icon-globe bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-address">
                                @if($bnf->address) {{ $bnf->address }} @else  <span class="opacity-50 unselectable" unselectable="on">@lang('payment.bnfFormAddr')</span> @endif
                            </div>
                        </div>

                        {{-- Phone Number --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormPhone')">
                            <i class="icon-mobile bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-phone">
                                {{ $bnf->tel }}
                            </div>
                        </div>

                        {{--Fax Number --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormFax')">
                            <i class="icon-fax bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-fax">
                                @if($bnf->fax) {{ $bnf->fax }} @else  <span class="opacity-50 unselectable" unselectable="on">@lang('payment.bnfFormFax')</span> @endif
                            </div>
                        </div>

                    </div>

                    {{-- Left Column --}}
                    <div class="col-sm-12 col-md-6 p-0 m-0">
                        {{-- Bank Name --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormBank')">
                            <i class="icon-bank bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-bankname">
                                {{ $bnf->bank_name }}
                            </div>
                        </div>

                        {{-- Branch Address --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormBranch')">
                            <i class="icon-branch bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-branch">
                                {{ $bnf->branch_name }}
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormCC')">
                            <i class="icon-card bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-accountnumber">
                                {{ $bnf->account_number }}
                            </div>
                        </div>

                        {{-- Swift Code --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormSwift')">
                            <i class="icon-swift bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-swift">
                                {{ $bnf->swift_code }}
                            </div>
                        </div>

                        {{-- iBan Number --}}
                        <div class="form-group bsWrapper" data-toggle="tooltip"
                             title="@lang('payment.bnfFormIban')">
                            <i class="icon-code bsIcon"></i>
                            <div class="form-control fanexInput fanexInputPanel"
                                 id="bnf-ajax-iban">
                                {{ $bnf->iban_code }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach