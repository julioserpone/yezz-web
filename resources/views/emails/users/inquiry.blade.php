@component('mail::message')
# INQUIRY USER

@component('mail::panel')
{{ env('MAIL_FROM_NAME') }}
 
![{{ env('MAIL_FROM_NAME') }}][logo]

[logo]: {{ asset('/img/page/yezz-logo.png') }} "Logo"

@endcomponent

<dl>
    <dt>MESSAGE:</dt>
    <dd>{{ $data['comment'] }} </dd>
</dl>

@component('mail::table')
| Customer         |                         |
| ---------------- |:-----------------------:|
| Category         | {{ $data['section'] }}  |
| Subcategory      | {{ $data['form'] }}     |
| Name             | {{ $data['name'] }}     |
| Email            | {{ $data['email'] }}    |
| Country          | {{ $data['country'] }}  |
| City             | {{ $data['city'] }}     |
| Product Model    | {{ $data['product'] }}  |
| IMEI             | {{ $data['imei'] }}     |
| Marketing Region | {{ $data['region'] }}   |
| Language         | {{ $data['language'] }} |

@endcomponent


@endcomponent
