<div class="mainForm">
    {{-- Form Loading Container --}}
    <div id="mainFormLoader" style="display:none;">
        <div class="spinner2">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <h1 class="pb-3 mt-0">@lang('index.contact')</h1>

    <form action="/contact" method="post">
        {{ csrf_field() }}

        {{-- Name + Email --}}
        <div class="row">
            {{-- Name --}}
            <div class="col-md-6 col-sm-12 pr-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-user bsIcon"></i>
                    <input type="text" class="form-control fanexInput" id="name"
                           name="name" placeholder="@lang('index.contactName')" autocomplete="off">
                </div>
            </div>
            {{-- Email --}}
            <div class="col-md-6 col-sm-12 pl-lg-2">
                <div class="form-group bsWrapper">
                    <div class="form-group bsWrapper">
                        <i class="icon-mail bsIcon"></i>
                        <input type="text" class="form-control fanexInput" id="email"
                               name="email" placeholder="@lang('index.contactMail')" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Text --}}
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group bsWrapper">
                    <div class="form-group bsWrapper">
                        <textarea class="fanexInput" name="contactText" id="contactText" placeholder="@lang('index.contactText')"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Submition --}}
        <div class="row">
            {{-- Send Contact Mail --}}
            <div class="col-sm-6 col-xs-12 pl-md-2 pull-right">
                <input type="submit" class="btn fanexBtnOutlineOrange" value="Send"/>
                {{--<div class="btn fanexBtnOutlineOrange hasIcon" onclick="sendMail()"><i class="icon-telegram"></i></div>--}}
            </div>
        </div>

    </form>
</div>
