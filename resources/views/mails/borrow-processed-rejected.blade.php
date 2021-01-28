@component('mail::message')

# {{ trans('notifications.mail.hello') }}, _{{ $notifiable ->fullname }}_!

{{ trans('notifications.borrow-processed.rejected.mail.intro') }}

@component('mail::table')
|                                                      |{{ trans('books.title') }}|
|:----------------------------------------------------:|:------------------------:|
|<img src="{{ $book->cover }}" height="128" width="80">|{{ $book->title }}        |
@endcomponent

{{ trans('notifications.mail.regards') }},<br>
_{{ config('app.name') }}_

@endcomponent
