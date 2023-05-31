<!DOCTYPE html>
<html>
<head>
    @include('frontend.layouts.head')
</head>
<body>
    <div>

        {{-- header section --}}
        <header>
            @include('frontend.layouts.header')
        </header>
        
        {{-- main section --}}
        <main class="pb-5 ">
            @yield('content')
        </main>
        
        <!-- Footer section -->
        
        @include('frontend.layouts.footer')
    </div>
    
</body>
</html>
