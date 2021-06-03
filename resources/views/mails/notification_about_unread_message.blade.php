@component('mail::message')
# Notification

Hi, {{ $toUser->name }} {{ $toUser->surname }}!

You have an unread message from

{{ $fromUser->name }} {{ $fromUser->surname }}
@component('mail::button', ['url' => $url])
Go to site
@endcomponent

Thanks, {{ config('app.name') }}
@endcomponent
