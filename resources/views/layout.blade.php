<!DOCTYPE html>
<html lang="en" data-url-prefix="/" data-footer="true" data-override='{"attributes": {"placement": "vertical", "layout": "boxed" }, "storagePrefix": "ecommerce-platform"}'
      @isset($html_tag_data) @foreach ($html_tag_data as $key=> $value)
      data-{{$key}}='{{$value}}'
    @endforeach
    @endisset
>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title>Account Management</title>
    <meta name="description" content="Account Management System"/>
    @include('_layout.head')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>



<body>
<div id="root">
    <div id="nav" class="nav-container d-flex" @isset($custom_nav_data) @foreach ($custom_nav_data as $key=> $value)
    data-{{$key}}="{{$value}}"
        @endforeach
        @endisset
    >
        @include('_layout.nav')
    </div>
    <main
        @isset($custom_main_class)
        class="{{$custom_main_class}}"
        @endisset
    >
        @yield('content')
    </main>
    @include('_layout.footer')
</div>
@include('_layout.modal_settings')
@include('_layout.modal_search')
@include('_layout.scripts')
<!-- Vendor Scripts Start -->


{{--<script src="/js/vendor/jquery-3.5.1.min.js"></script>--}}
{{--<script src="/js/vendor/bootstrap.bundle.min.js"></script>--}}
{{--<script src="/js/vendor/autoComplete.min.js"></script>--}}
{{--<script src="/js/vendor/clamp.min.js"></script>--}}
{{--<script src="/icon/acorn-icons.js"></script>--}}
{{--<script src="/icon/acorn-icons-interface.js"></script>--}}
{{--<script src="/js/cs/scrollspy.js"></script>--}}



</body>

</html>
