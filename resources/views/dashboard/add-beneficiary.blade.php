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
                        <h2 class="dash-subtitle m-0">@lang('payment.bnfAddNew')</h2>
                    </div>

                    <div class="col-xs-1 px-0">
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">

                    {{-- Add Beneficiary Form --}}
                    <form action="/beneficiaries" method="post" id="add-bnf-form">
                        {{ csrf_field() }}

                        @include('partials.new-beneficiary')

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
            $('#bnfCountry').selectpicker('val', 'IR');
        });
    </script>
@endsection