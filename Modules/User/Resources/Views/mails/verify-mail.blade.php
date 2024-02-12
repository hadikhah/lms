@component('mail::message')
# @lang('your activation code in lms')

@lang('This email has been sent to you because of your registration on the lms website') , **@lang('If you have not registered yourself')**, @lang('ignore this email')

@component('mail::panel')
@lang('activation code'): {{ $code }}
@endcomponent

{{ config('app.name') }}
@endcomponent
