@component('mail::message')

# {{ trans('notifications.mail.hello') }}, _{{ $notifiable ->fullname }}_!

{{ trans_choice('notifications.new-borrows-report.mail.intro', $newBorrows->count()) }}

@component('mail::table')

{{ trans('books.title') }}|{{ trans('users.fullname') }}|
:-------------------------|:----------------------------|
@foreach ($newBorrows as $borrow)
@php
    $book = $borrow->book;
    $user = $borrow->user;
@endphp
{{ $book->title }}        |{{ $user->fullname }}        |
@endforeach

@endcomponent

@component('mail::button', ['url' => "{{ route('borrows.index') }}"])
{{ trans('notifications.mail.check-it-now') }}
@endcomponent

{{ trans('notifications.mail.regards') }},<br>
_{{ config('app.name') }}_

@component('mail::subcopy')
{{ trans('notifications.mail.subcopy') }}: [{{ route('borrows.index') }}]({{ route('borrows.index') }})
@endcomponent

@endcomponent
