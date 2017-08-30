@extends('layouts.master')

@section('styles')
    <style>
        body {
            background: #f4f4f4 url({{ asset('css/images/pattern.png') }});
            background-size: 30%;
        }

        .navbar-right {
            display: none;
        }
    </style>
@endsection

@section('header')
    @include('partials.nav', ["type"=>"dark"])
@endsection

@section('content')
    <div class="container-fluid additional-wrapper">
        <div class="row m-0 p-0">
            <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12 col-lg-push-3 col-md-push-2 col-sm-push-1 white-div">

                <div class="staticMainForm m-0">
                    {{-- Form Loading Container --}}
                    <div id="mainFormLoader" style="display:none;">
                        <div class="errors" style="display: none"></div>
                        <div class="spinner2">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>

                    <h1 class="pb-3 mt-0">@lang('index.additionalTitle')</h1>

                    <form action="/additional-info" method="post">
                        {{ csrf_field() }}

                        {{--<input type="hidden" name="state" value="{{$state}}" id="state" style="display: none">--}}

                        {{-- Select Authorizer --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="authorizer" class="fanexLabel">@lang('index.formAuthorizer') :</label>
                                <div class="form-group bsWrapper">
                                    <i class="icon-coin bsIcon"></i>
                                    <select class="form-control fanexInput selectpicker" data-style="fanexInput"
                                            name="authorizer"
                                            id="authorizer">
                                        <option value="" selected="selected"
                                                disabled="disabled">@lang('index.formAuthorizer')</option>
                                        @foreach($identifiers as $identifier)
                                            <option value="{{ $identifier->id }}">@lang('index.'.$identifier->name)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="identifier-ajax-form">

                        </div>

                        {{-- Form Submition --}}
                        <div class="row">
                            {{-- Calculate Amount --}}
                            <div class="col-sm-6 col-xs-12 pr-md-2 mb-xs-4">
                            </div>
                            {{-- Go For Payment --}}
                            <div class="col-sm-6 col-xs-12 pl-md-2">
                                <input type="hidden" value="{{ $additional_data }}" name="additional">
                                <input type="submit" class="btn fanexBtnOutlineGrey" id="continue_btn"
                                       value="@lang('index.continue')"
                                       name="payment" disabled="disabled"/>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ["type"=>'dark'])
@endsection

@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#main-content-wrapper').css({'padding-bottom': 0});
            $('#continue_btn').attr('disabled', 'disabled');
            $('#authorizer').val('');
            $('.selectpicker').selectpicker('refresh');

            $('#authorizer').on('change', function() {
                var identifier = $(this).val();
                $.ajax({
                    method: 'get',
                    url: '/additional-info/' + identifier,
                    data: {
                        '_token': csrfToken,
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.response);
                    },
                }).done(function(response) {
                    $('#identifier-ajax-form').html(response);
                    $('#continue_btn').removeAttr('disabled');
                    console.log('do it now');
                    $('body').getNiceScroll().resize();
                });
            });
        });

        $(document).on('keypress', '.only_latin', function(event){
            var englishAlphabetAndWhiteSpace = /[A-Za-z ]/g;
            var key = String.fromCharCode(event.which);
            if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
                return true;
            }
            return false;
        });

        $(document).on('paste', '.only_latin', function(event){
            event.preventDefault();
        });
    </script>
@endsection

