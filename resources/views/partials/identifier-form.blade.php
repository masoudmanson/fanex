@foreach($identifier as $k => $v)
    @if($v && $k != "id")
        {{--Nickname --}}
        <div class="row">
            <div class="col-xs-12">
                <label for="{{ $v }}" class="fanexLabel">@lang('index.additional'.$v) :</label>
                <div class="form-group bsWrapper">
                    <i class="icon-user bsIcon"></i>
                    <input type="text" class="form-control fanexInput @if($v == 'firstname' || $v == 'lastname') only_latin @else numberTextField @endif" id="{{ $v }}"
                           name="{{ $v }}" placeholder="@lang('index.additional'.$v)"
                           autocomplete="off">
                </div>
            </div>
        </div>
    @endif
@endforeach