<x-auth-layout>
    <x-auth-card>
        <x-slot name="title">
            <h5 class="text-primary mb-2 mt-4">Reset Password !</h5>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
        <h5 class="mb-4  text-success">
            {{ session('status') }}
        </h5>
        @endif

        <form class="form-horizontal mt-4 pt-2 text-left" method="POST" action="{{ route('forget.password.change.request') }}"  style="max-width: 400px; margin: auto">
            @csrf
            <input type="hidden" name="token" value="{{ request()->token ?? '' }}">

            <div class="mb-3">
                <label for="phone">{{ __('Phone Number') }}</label>
                <input id="phone" class="form-control" type="phone" name="phone"
                    value="{{ old('phone', request()->phone ?? '') }}" readonly required />
            </div>

            <div class="mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="new-password" placeholder="Enter new password" />
            </div>
            <div class="mb-3">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                    required autocomplete="new-password" placeholder="Enter confirm password" />
            </div>
            <div>
                <button class="btn btn-success w-100 waves-effect waves-light" type="submit">Reset Password</button>
            </div>
        </form>
    </x-auth-card>
</x-auth-layout>
