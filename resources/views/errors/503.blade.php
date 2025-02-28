<x-guest-layout>
    <!-- end row -->
    <div class="row pt-4 align-items-center justify-content-center">
        <div class="col-sm-5">
            <div class="">
                <img src="{{ admin_asset('images/errors/500.png') }}" alt="" class="img-fluid mx-auto d-block"
                    style="max-height: 400px">
            </div>

            <div class="text-center mb-5">
                <h1 class="font-large-2 my-1">
                    Service Unavailable!
                </h1>
                <p class="px-2">
                    {{ $exception->getMessage() ?: 'Sorry, I’m currently unable to handleyour request. Try again
                    later!'}}
                    @if (setting('site.email'))
                    <em>
                        <strong>
                            If you have any emergency, you can mail us <a href="mailto:{{ setting('site.email') }}">
                                {{setting('site.email')}}
                            </a>
                        </strong>
                    </em>
                    @endif
                </p>
                <a class="btn btn-info mt-3" href="{{ back_url() }}">
                    <i class="mdi mdi-reply mr-1"></i>
                    Back
                </a>
            </div>
        </div>

    </div>
    <x-admin.auth-footer class="text-black" />

</x-guest-layout>
