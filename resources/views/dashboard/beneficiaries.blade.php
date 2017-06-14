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
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-9 px-0">
                        <ul class="filter-ul">
                            <li class="filter-li active" data-filter="all" style="margin-right: 5px;"><a href="#"><span class="mini-title">All</span><span class="large-title">All</span></a></li>
                            <li class="filter-li flag" data-filter="ir" title="Islamic Republic of Iran"><i class="flag-icon-squared flag-icon-ir"></i></li>
                            <li class="filter-li flag" data-filter="tr" title="Turkey"><i class="flag-icon-squared flag-icon-tr"></i></li>
                            <li class="filter-li flag" data-filter="us" title="United States of America"><i class="flag-icon-squared flag-icon-us"></i></li>
                            <li class="filter-li flag" data-filter="uk" title="United Kingdom"><i class="flag-icon-squared flag-icon-gb-eng"></i></li>
                        </ul>
                    </div>

                    <div class="col-xs-3 px-0">
                        <ul class="filter-ul filter-right">
                            <li class="filter-li-link"><a href="/beneficiaries/add">Add New</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default search" id="search-input">
                            <input type="text" class="panel-heading fanexInputWhite search-filter" placeholder="Search in Beneficiaries">
                            <div id="searchbox" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p>Trans. No.:</p>
                                                <p>Bnf. Acc. No.:</p>
                                                <p>Bank Name:</p>
                                                <p>Payment Date:</p>
                                                <p>Trans. Status:</p>
                                                <p>Trans. Type:</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p>v8845ewf1w23fwefwe</p>
                                                <p>6104337912543665</p>
                                                <p>Pasargad</p>
                                                <p>{{ \Carbon\Carbon::now()->format("d M Y, H:s:i") }}</p>
                                                <p class="fanex-text-orange">Pending</p>
                                                <p>Transfer To Account</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5 acc-factor">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p class="table-header">Item</p>
                                                <p>Prem. Amount:</p>
                                                <p>Expense:</p>
                                                <p>Tax:</p>
                                                <hr>
                                                <p>Sum</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p class="table-header">Price</p>
                                                <p>5000 EUR</p>
                                                <p>15 EUR</p>
                                                <p>4.5 EUR</p>
                                                <hr>
                                                <p>5019.5 EUR</p>
                                                <p class="acc-factor-sum">= 155000000 Rials</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default filtered ctr-ir">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip" title="Beneficiary Name">
                                        <i class="icon-user acc-main-icon"></i>
                                        <span class="acc-user"><b>Masoud Amjadi</b></span>
                                    </div>
                                    <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip" title="Beneficiary Account Number">
                                        <span class="acc-date">6104-3379-1254-3665</span>
                                    </div>
                                    <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip" title="Country">
                                        <span class="acc-cash">Iran</span>
                                    </div>
                                    <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip" title="Mobile Number">
                                        <span class="acc-date">09148401824</span>
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                        <a href="/">
                                            <i class="icon-trans" title="Send Money"></i>
                                        </a>
                                        <a href="/">
                                            <i class="icon-chat hidden-xs" title="Send Message"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-edit"title="Edit Info"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-delete" title="Delete Beneficiary"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row1"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row1" class="panel-collapse collapse">
                                <div class="panel-body p-0">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Beneficiary Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Name">
                                                <i class="icon-user bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-firstname">
                                                    Masoud Amjadi
                                                </div>
                                            </div>

                                            {{-- Account Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Account Number">
                                                <i class="icon-card bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-accountnumber">
                                                    6104337912543665
                                                </div>
                                            </div>

                                            {{-- Country --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Country">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-country">
                                                    Iran
                                                </div>
                                            </div>

                                            {{-- Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Address">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-address">#123, Noavari
                                                    12, Pardis Tech Park, Tehran
                                                </div>
                                            </div>

                                            {{-- Phone Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Mobile Number">
                                                <i class="icon-mobile bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-phone">09148401824
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Left Column --}}
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Bank Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Bank Name">
                                                <i class="icon-bank bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-bankname">
                                                    Pasargad
                                                </div>
                                            </div>

                                            {{-- Branch Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Branch Address">
                                                <i class="icon-branch bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-branch">
                                                    #12, Pasargad 13, Africa Blv, Tehran, Iran
                                                </div>
                                            </div>

                                            {{-- Swift Code --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Swift Code">
                                                <i class="icon-swift bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-swift">
                                                    54584534468431346463131
                                                </div>
                                            </div>

                                            {{-- iBan Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="iBan Number">
                                                <i class="icon-code bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-iban">
                                                    4646464000011054048880
                                                </div>
                                            </div>

                                            {{-- Fax Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Fax Number">
                                                <i class="icon-fax bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-fax">02171951111</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default filtered ctr-tr">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip" title="Beneficiary Name">
                                        <i class="icon-user acc-main-icon"></i>
                                        <span class="acc-user"><b>Pooria Pahlevani</b></span>
                                    </div>
                                    <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip" title="Beneficiary Account Number">
                                        <span class="acc-date">6104-3379-1254-3665</span>
                                    </div>
                                    <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip" title="Country">
                                        <span class="acc-cash">Turkey</span>
                                    </div>
                                    <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip" title="Mobile Number">
                                        <span class="acc-date">09148401824</span>
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                        <a href="/">
                                            <i class="icon-trans" title="Send Money"></i>
                                        </a>
                                        <a href="/">
                                            <i class="icon-chat hidden-xs" title="Send Message"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-edit"title="Edit Info"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-delete" title="Delete Beneficiary"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row2"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row2" class="panel-collapse collapse">
                                <div class="panel-body p-0">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Beneficiary Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Name">
                                                <i class="icon-user bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-firstname">
                                                    Pooria Pahlevani
                                                </div>
                                            </div>

                                            {{-- Account Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Account Number">
                                                <i class="icon-card bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-accountnumber">
                                                    6104337912543665
                                                </div>
                                            </div>

                                            {{-- Country --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Country">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-country">
                                                    Turkey
                                                </div>
                                            </div>

                                            {{-- Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Address">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-address">#123, Noavari
                                                    12, Pardis Tech Park, Tehran
                                                </div>
                                            </div>

                                            {{-- Phone Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Mobile Number">
                                                <i class="icon-mobile bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-phone">09148401824
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Left Column --}}
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Bank Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Bank Name">
                                                <i class="icon-bank bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-bankname">
                                                    Pasargad
                                                </div>
                                            </div>

                                            {{-- Branch Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Branch Address">
                                                <i class="icon-branch bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-branch">
                                                    #12, Pasargad 13, Africa Blv, Tehran, Iran
                                                </div>
                                            </div>

                                            {{-- Swift Code --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Swift Code">
                                                <i class="icon-swift bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-swift">
                                                    54584534468431346463131
                                                </div>
                                            </div>

                                            {{-- iBan Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="iBan Number">
                                                <i class="icon-code bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-iban">
                                                    4646464000011054048880
                                                </div>
                                            </div>

                                            {{-- Fax Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Fax Number">
                                                <i class="icon-fax bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-fax">02171951111</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default filtered ctr-us">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip" title="Beneficiary Name">
                                        <i class="icon-user acc-main-icon"></i>
                                        <span class="acc-user"><b>Hamidreza Amouzegar</b></span>
                                    </div>
                                    <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip" title="Beneficiary Account Number">
                                        <span class="acc-date">6104-3379-1254-3665</span>
                                    </div>
                                    <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip" title="Country">
                                        <span class="acc-cash">USA</span>
                                    </div>
                                    <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip" title="Mobile Number">
                                        <span class="acc-date">09148401824</span>
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                        <a href="/">
                                            <i class="icon-trans" title="Send Money"></i>
                                        </a>
                                        <a href="/">
                                            <i class="icon-chat hidden-xs" title="Send Message"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-edit"title="Edit Info"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-delete" title="Delete Beneficiary"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row3"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row3" class="panel-collapse collapse">
                                <div class="panel-body p-0">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Beneficiary Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Name">
                                                <i class="icon-user bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-firstname">
                                                    Pooria Pahlevani
                                                </div>
                                            </div>

                                            {{-- Account Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Account Number">
                                                <i class="icon-card bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-accountnumber">
                                                    6104337912543665
                                                </div>
                                            </div>

                                            {{-- Country --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Country">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-country">
                                                    Turkey
                                                </div>
                                            </div>

                                            {{-- Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Address">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-address">#123, Noavari
                                                    12, Pardis Tech Park, Tehran
                                                </div>
                                            </div>

                                            {{-- Phone Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Mobile Number">
                                                <i class="icon-mobile bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-phone">09148401824
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Left Column --}}
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Bank Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Bank Name">
                                                <i class="icon-bank bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-bankname">
                                                    Pasargad
                                                </div>
                                            </div>

                                            {{-- Branch Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Branch Address">
                                                <i class="icon-branch bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-branch">
                                                    #12, Pasargad 13, Africa Blv, Tehran, Iran
                                                </div>
                                            </div>

                                            {{-- Swift Code --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Swift Code">
                                                <i class="icon-swift bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-swift">
                                                    54584534468431346463131
                                                </div>
                                            </div>

                                            {{-- iBan Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="iBan Number">
                                                <i class="icon-code bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-iban">
                                                    4646464000011054048880
                                                </div>
                                            </div>

                                            {{-- Fax Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Fax Number">
                                                <i class="icon-fax bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-fax">02171951111</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default filtered ctr-uk">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip" title="Beneficiary Name">
                                        <i class="icon-user acc-main-icon"></i>
                                        <span class="acc-user"><b>Mohammad Parham</b></span>
                                    </div>
                                    <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip" title="Beneficiary Account Number">
                                        <span class="acc-date">6104-3379-1254-3665</span>
                                    </div>
                                    <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip" title="Country">
                                        <span class="acc-cash">England</span>
                                    </div>
                                    <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip" title="Mobile Number">
                                        <span class="acc-date">09148401824</span>
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                        <a href="/">
                                            <i class="icon-trans" title="Send Money"></i>
                                        </a>
                                        <a href="/">
                                            <i class="icon-chat hidden-xs" title="Send Message"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-edit"title="Edit Info"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-delete" title="Delete Beneficiary"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row4"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row4" class="panel-collapse collapse">
                                <div class="panel-body p-0">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Beneficiary Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Name">
                                                <i class="icon-user bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-firstname">
                                                    Pooria Pahlevani
                                                </div>
                                            </div>

                                            {{-- Account Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Account Number">
                                                <i class="icon-card bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-accountnumber">
                                                    6104337912543665
                                                </div>
                                            </div>

                                            {{-- Country --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Country">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-country">
                                                    Turkey
                                                </div>
                                            </div>

                                            {{-- Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Address">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-address">#123, Noavari
                                                    12, Pardis Tech Park, Tehran
                                                </div>
                                            </div>

                                            {{-- Phone Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Mobile Number">
                                                <i class="icon-mobile bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-phone">09148401824
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Left Column --}}
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Bank Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Bank Name">
                                                <i class="icon-bank bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-bankname">
                                                    Pasargad
                                                </div>
                                            </div>

                                            {{-- Branch Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Branch Address">
                                                <i class="icon-branch bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-branch">
                                                    #12, Pasargad 13, Africa Blv, Tehran, Iran
                                                </div>
                                            </div>

                                            {{-- Swift Code --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Swift Code">
                                                <i class="icon-swift bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-swift">
                                                    54584534468431346463131
                                                </div>
                                            </div>

                                            {{-- iBan Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="iBan Number">
                                                <i class="icon-code bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-iban">
                                                    4646464000011054048880
                                                </div>
                                            </div>

                                            {{-- Fax Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Fax Number">
                                                <i class="icon-fax bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-fax">02171951111</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $('.filter-li').on('click', function() {
                $('.filter-li').removeClass('active');
                $(this).addClass('active');
                var filter = $(this).attr('data-filter');
                if(filter == 'all') {
                    $('.filtered').slideDown(200);
                }
                else {
                    $('.filtered').slideUp(200);
                    $('.filtered.ctr-'+filter).slideDown(200);
                }
            });

        });
    </script>
@endsection