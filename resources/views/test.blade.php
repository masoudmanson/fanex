@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">

                        <form class="form-group" action="/payment" method="get">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input type="text" class="form-control" id="exampleInputAmount" name="amount" placeholder="Amount">
                                    <div class="input-group-addon">.00</div>
                                </div>
                            </div>


                            {{--<button type="submit" class="btn btn-default">Submit</button>--}}

                            <input type="submit" class="btn btn-default" value="payment" name="payment"  />

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


