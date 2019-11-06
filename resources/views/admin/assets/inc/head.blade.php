<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Admin | {{ config('app.name', 'Laravel') }}</title>

<!-- Scripts -->
<script type="text/javascript">
    var appconfigs = {
        'baseurl' : '{{ url('/') }}'
    }
</script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/fontawesome-v5.7.2.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js" defer></script>
<script src="{{ asset('js/admin.js') }}" defer></script>
@yield('js')

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@yield('css')
