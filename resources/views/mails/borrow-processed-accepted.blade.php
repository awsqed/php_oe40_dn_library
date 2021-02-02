@component('mail::message')

# {{ trans('notifications.mail.hello') }}, _{{ $notifiable ->fullname }}_!

{{ trans('notifications.borrow-processed.accepted.mail.intro') }}

@component('mail::table')
||{{ trans('books.title') }}|{{ trans('library.borrow.from') }}|{{ trans('library.borrow.to') }}|
|:----------------------------------------------------:|:----------------:|:---------:|:-------:|
|<img src="{{ $book->cover }}" height="128" width="80">|{{ $book->title }}|{{ $from }}|{{ $to }}|
@endcomponent

{{ trans('notifications.borrow-processed.accepted.mail.outro') }}

{{ trans('notifications.mail.regards') }},<br>
_{{ config('app.name') }}_

@endcomponent
