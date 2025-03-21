<x-auth-layout>

    @push('extra-styles')
        <style>
            .digit-group {
                .splitter {
                    padding: 0 5px;
                    color: white;
                    font-size: 24px;
                }
            }
            input.form-control{
                width: 45px;
                height: 50px;
                font-size: 25px;
                text-align: center;
                color: gray;
                display: inline;
            }
            .prompt {
                margin-bottom: 20px;
                font-size: 20px;
                color: white;
            }
        </style>
    @endpush

    @push('extra-scripts')
        <script>
            $('.grid-area').find('input').each(function() {
                $(this).attr('maxlength', 1);
                $(this).on('keyup', function(e) {
                    var parent = $($(this).parent());
                    if(e.keyCode === 8 || e.keyCode === 37) {
                        var prev = parent.find('input#' + $(this).data('previous'));
                        if(prev.length) {
                            $(prev).select();
                        }
                    } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                        var next = parent.find('input#' + $(this).data('next'));
                        if(next.length) {
                            $(next).select();
                        } else {
                            if(parent.data('autosubmit')) {
                                parent.submit();
                            }
                        }
                    }
                });
            });
        </script>
    @endpush


    <x-auth-card>
        <x-slot name="title">
            <h4 class="text-dark mb-2 mt-4">OTP Verification</h4>
            <p class="text-dark">
                We have sent you a verification OTP to your email, please input the verification OTP.
            </p>
        </x-slot>

        <div class="text-left">
            <x-validation-errors class="mb-4" />
        </div>

        <form class="form-horizontal mt-4 pt-2" method="POST" action="{{ route('forget.password.request') }}" id="resend_form">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}" readonly required>
        </form>

        <form class="form-horizontal mt-4 pt-2" method="POST" action="{{ route('forget.otp.verify.request') }}" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off" style="max-width: 400px; margin: auto">
            @csrf
            <input type="hidden" name="email" value="{{ request()->email }}" readonly required>

            {{-- <input type="number" name="otp" id="otp" value="" class="form-control mb-1" required> --}}
            <div class="grid-area text-center d-flex justify-content-around">
                @for ($i = 1; $i <= config('otp.length'); $i++)
                    <input type="text" id="digit-{{ $i }}" class="form-control" name="otp[]" @if($i != config('otp.length')) data-next="digit-{{ $i+1 }}" @endif @if($i != 1) data-previous="digit-{{ $i - 1 }}" @endif />
                @endfor
            </div>

            <button type="submit" class="btn btn-danger w-100 waves-effect waves-light mt-3">
                {{ __('Verify OTP') }}
            </button>

            <p class="text-muted pt-2">Haven't received yet ?  <a href="#" onclick="$('#resend_form').submit()"><span class="text-primary">Resend</span></a></p>

        </form>
    </x-auth-card>
</x-auth-layout>
