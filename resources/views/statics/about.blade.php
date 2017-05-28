@extends('layouts.master')

@section('styles')
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldHigh.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/black.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <style>
        .bgWrapper {
            background-color: #333 !important;
        }
        .bgDiv i {
            color: #666;
            font-size: 120px;
        }
    </style>
@endsection

@section('header')
    @include('partials.nav')
@endsection

@section('content')
    <div class="bgWrapper">
        <div class="col-lg-6 col-md-12 bgDiv bgDivLeft"></div>
        <div class="col-lg-6 col-md-12 bgDiv bgDivRight">
            <i class="icon-group">Masoud</i>
        </div>
    </div>
    <div class="container-fluid indexWrapper">
        <div class="row m-0">
            {{-- Form Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                @include('partials.mainForm')
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="staticHeader">
                    <p class="fanexLogoName">About Us</p>
                    <div class="fanexMotto">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias distinctio minima minus
                            nobis, ratione sapiente. Consectetur corporis doloribus, earum eveniet inventore minus, modi
                            neque pariatur placeat, provident quibusdam ratione sit!</p>
                        <p>Ab aut eum, expedita fugit ipsa iure, perferendis, quasi quo saepe sequi similique soluta
                            tempore ut veniam voluptate. A, aperiam consequuntur distinctio doloribus fugiat id minima
                            nesciunt sequi temporibus! Est.</p>
                        <p>Alias asperiores aspernatur at dicta enim, facilis illum ipsa ipsam laudantium modi nobis
                            nostrum perspiciatis repellat ullam veritatis? Cupiditate, debitis distinctio eveniet maxime
                            minima molestias nostrum officiis quam quia velit.</p>
                        <p>Alias aliquam aliquid, autem beatae consectetur debitis dolorem ducimus eaque eveniet ex
                            facere fugit hic incidunt ipsa ipsam itaque perferendis porro quam quibusdam quisquam saepe
                            sapiente sit unde veniam voluptatem.</p>
                        <p>Consectetur expedita minima necessitatibus obcaecati quam vel voluptates. Amet aut cupiditate
                            deserunt eaque fugiat hic maxime molestias nulla possimus quaerat, quam quia quo repudiandae
                            suscipit vitae voluptatem voluptates! Consequatur, iure.</p>
                        <p>Adipisci aliquam architecto aspernatur facilis harum illum itaque minima minus nam porro
                            quidem quis quod repellat rerum sapiente, tempore ullam veritatis! Aperiam enim obcaecati
                            possimus quaerat quisquam quos veniam voluptate.</p>
                        <p>Accusamus adipisci architecto asperiores atque consectetur cumque deleniti dicta eaque et
                            eveniet, iste non odio possimus reiciendis repellendus tempora voluptas voluptatum?
                            Accusantium ad aut error illum iure officiis quae sunt?</p>
                        <p>Accusamus animi beatae cum deserunt dolorem, doloribus earum est et ipsum libero magni
                            maiores nam nemo neque odit perferendis quas, qui quia ratione repellat, sunt ullam
                            veritatis! Doloremque, et, incidunt!</p>
                        <p>Animi aut consectetur facere impedit, obcaecati odit provident quae rem repellendus rerum
                            suscipit veniam vitae. Accusantium animi dignissimos ipsum, laborum officia optio quibusdam
                            quisquam recusandae soluta ullam vel voluptates voluptatum!</p>
                        <p>Autem corporis culpa cum deleniti earum, excepturi fuga hic inventore ipsam laboriosam
                            molestiae necessitatibus nobis odit praesentium quod sit tempore veritatis vero voluptates
                            voluptatibus. Amet animi incidunt nihil odit sint.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection