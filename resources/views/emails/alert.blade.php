@component('mail::message')
# hello

you have new bill.

@component('mail::button', ['url' => ''])
Send
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
