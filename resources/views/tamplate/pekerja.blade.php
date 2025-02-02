@if(auth()->check() && auth()->user()->level_user == 1)
    <script>
        window.location.href = "/admin/dashboard";
    </script>

@elseif(auth()->check() && auth()->user()->level_user == 2)
    <script>
        window.location.href = "/majikan/dashboard";
    </script>
@endif
@include('tamplate.header')

@include('tamplate.menu_pekerja')

<!-- Hero Section Begin -->
@yield('content')
<!-- Blog Section End -->

<!-- Footer Section Begin -->
@include('tamplate.footer')
<!-- Footer Section End -->

