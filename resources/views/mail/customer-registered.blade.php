@component('mail::message')
# Registration Confirmation

This is a confirmation of your registration for Market Place Produce's online ordering platform. No further action is required, you will be notified when your account is activated.

@component('mail::panel')
{{ $customer->name }}

{{ $customer->address }}

{{ $customer->contact_name }}

{{ $customer->contact_phone }}

{{ $customer->contact_email }}
@endcomponent

If any of the information above is incorrect, please reach out via email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
