<p class="mt-8 text-center text-xs text-80">
    <a href="https://google.com" class="text-primary dim no-underline">{{config('app.name')}}.</a>
    <span class="px-1">&middot;</span>
    &copy; {{ date('Y') }} {{config('app.name')}} Admin
    <span class="px-1">&middot;</span>
    {{-- v{{ \Laravel\Nova\Nova::version() }} --}}
</p>
