@auth
    <img
        src="{{ asset('img/logo_black_trim.png') }}"
        class="h-6"
    />
@endauth
 
@guest
    <img
        src="{{ asset('img/logo_black.png') }}"
        class="w-full sm:max-w-md mt-6 sm:mt-0 px-6 sm:px-0"
    />
@endguest