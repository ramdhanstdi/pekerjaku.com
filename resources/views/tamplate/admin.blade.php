@if(auth()->check() && auth()->user()->level_user == 2)
    <script>
        window.location.href = "/majikan/dashboard";
    </script>

@elseif(auth()->check() && auth()->user()->level_user == 3)
    <script>
        window.location.href = "/pekerja/dashboard";
    </script>
@endif
@include('tamplate.header')

@include('tamplate.menu_admin')

<!-- Hero Section Begin -->
@yield('content')
<!-- Blog Section End -->
<!-- Footer Section Begin -->
@include('tamplate.footer')
<!-- Footer Section End -->
@stack('script')
