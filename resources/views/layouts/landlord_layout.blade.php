<!DOCTYPE html>
<html dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}" lang="zxx" class="js">

<head>
    <meta charset="utf-8">

    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>{{ __('Rental Management System')}}</title>

    @if(app()->getLocale()=='ar')
        <link rel="stylesheet" href="{{ asset('assets/css/dashlite.rtl.min.css')}}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/dashlite.min.css')}}">
    @endif

    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css')}}">
    <link id="skin-default" rel="stylesheet"
          href="{{ asset('assets/css/skins/theme-'.setting('skin_color').'.css')}}">
    @livewireStyles
    @stack('css')

    <style>
        .filepond--credits {
            display: none;
        }
    </style>
</head>

<body
    class="nk-body npc-general has-sidebar {{ setting('color_mode_style')}}  {{ setting('main_ui_style')}} {{ app()->getLocale()=='ar'?'has-rtl':'' }}"
    dir="{{ app()->getLocale()=='ar'?'rtl':'ltr' }}"
>

<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
    @include('landlord.includes.sidebar')
    <!-- sidebar @e -->
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
        @include('landlord.includes.header')
        <!-- End Main Header Here @e -->
            <!-- content @s -->
        @yield('content')
        <!-- content @e -->
            <!-- footer @s -->
        @include('landlord.includes.footer')
        <!-- footer @e -->
        </div>
    </div>
    <!-- wrap @e -->
</div>
<!-- main @e -->

<!-- app-root @e -->

<!-- JavaScript -->
<script src="{{ asset('assets/js/bundle.js')}}"></script>
<script src="{{ asset('assets/js/scripts.js')}}"></script>
@livewireScripts
<x-livewire-alert::scripts/>

@stack('scripts')

</body>

</html>
