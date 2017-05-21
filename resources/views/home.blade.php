@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">

                    <form class="form-group" action="/calculate" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="currency">Currency:</label>
                            <select name="currency">
                                <option value="Turkish Lira">Turkish Lira</option>
                                <option value="Euro">Euro</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="country">Country:</label>
                            <select name="country">
                                <option value="Turkey">Turkey</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="paymentMethod">Payment Method:</label>
                            <select name="payment_method">
                                <option value="transfer">Transfer To Account</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input type="text" class="form-control" id="exampleInputAmount" name="amount" placeholder="Amount">
                                <div class="input-group-addon">.00</div>
                            </div>
                        </div>


                        {{--<button type="submit" class="btn btn-default">Submit</button>--}}

                        <input type="submit" class="btn btn-default" value="calculate" name="calculate" />
                        <input type="submit" class="btn btn-default" value="payment" name="payment"  />

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


