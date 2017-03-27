<!DOCTYPE html>
<html lang="en">
    <head>
        @include('auth.partials._head')
    </head>
    <body>
        {{-- Main content --}}
        @yield('content')

        {{-- Footer --}}
        @include('public.partials._footer')

        {{-- JavaScripts --}}
        @include('public.partials._scripts')
    </body>
</html>
