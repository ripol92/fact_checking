@component('mail::message')
# Feedback from factchecking user {{$userName}}

{{$feedback}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
