@component('mail::message')

# {{ $subject }}

@component('mail::promotion')
{{ $body }}
@endcomponent

<h3 style="text-align: center">If you have any questions, you can <a class="matex-link" href={{ 'mailto:' . config('mail.customer-support.address') }}>contact us!</a></h3>

<p style="text-align: center">Thanks, <br><strong>{{ config('app.name') }}</strong></p>

@endcomponent