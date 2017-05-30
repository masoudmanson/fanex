@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
{{ $redirect_uri }}
{{ $state }}
                        <form class="form-group" action="/additional-info" method="post">
                            {{ csrf_field() }}

                            <div class = "form-group">
                                <label for = "nickname">Nick Name</label>
                                <input name="nickname" type = "text" class = "form-control" id = "nickname" placeholder = "Enter nickname">
                                <input type = "text" name="state" value="{{$state}}" class = "form-control" id = "state" style="display: none">
                                <input type = "text" name="token" value="{{$token}}" class = "form-control" id = "token" style="display: none">
                            </div>

                            <div class = "form-group">
                                <label for = "account_number">Account Number</label>
                                <input name="account_number" type = "text" class = "form-control" id = "account" placeholder = "Enter account number">
                            </div>

                            <div class = "form-group">
                                <label for = "mobile">Mobile</label>
                                <input name="mobile" type = "text" class = "form-control" id = "mobile" placeholder = "mobile">
                            </div>


                            <button type="submit" class="btn btn-default">Submit</button>

                            {{--<input type="submit" class="btn btn-default" value="payment" name="payment"  />--}}

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


