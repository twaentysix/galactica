@component('mail::message')
# Confirm Your Email Address

Please click the button below to confirm your email address:

@component('mail::button', ['url' => $confirmationLink])
Confirm Email
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
