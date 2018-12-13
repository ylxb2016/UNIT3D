@php $pool = App\Pool::where('complete', '=', 0)->first(); @endphp
@if ($pool)
<div class="alert alert-warning text-center">
    <h2 class="mt-10"><strong>BON Pool:</strong> There is currently an active Freeleech Pool!</h2>
    <p>The current pool stands at {{ number_format($pool->current_pot) }} {{ trans('bon.bon') }} out of {{ number_format($pool->goal) }} {{ trans('bon.bon') }}. <a href="{{ route('pool') }}">Contribute Now!</a></p>
</div>
@endif

@if (config('other.freeleech') == true || config('other.invite-only') == false || config('other.doubleup') == true)
    <div class="alert alert-info" id="alert1">
        <div class="text-center">
    <span>
      @if (config('other.freeleech') == true) {{ trans('common.freeleech_activated') }}! @endif
        @if (config('other.invite-only') == false) {{ trans('common.openreg_activated') }}! @endif
        @if (config('other.doubleup') == true) {{ trans('common.doubleup_activated') }}! @endif
    </span>
            <strong>
                <div id="promotions"></div>
            </strong></div>
    </div>
@endif
