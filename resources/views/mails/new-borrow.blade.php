@component('mail::message')

# {{ trans('notifications.mail.hello') }}, _{{ $notifiable ->fullname }}_!

{{ trans('notifications.new-borrow.mail.intro') }}

@component('mail::table')
|                                                      |{{ trans('books.title') }}|{{ trans('users.fullname') }}|
|:----------------------------------------------------:|:------------------------:|:---------------------------:|
|<img src="{{ $book->cover }}" height="128" width="80">|{{ $book->title }}        |{{ $user->fullname }}        |
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
