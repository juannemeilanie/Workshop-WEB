<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.header')
</head>
<body>
<div class="container-scroller">

    @include('layout.navbar')

    <div class="container-fluid page-body-wrapper">

        @include('layout.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">

                {{-- CONTENT --}}
                @yield('content')

            </div>

            @include('layout.footer')
            @include('layout.javascript global')
            @include('layout.javascript page')
        </div>

    </div>
</div>


</body>
</html>
