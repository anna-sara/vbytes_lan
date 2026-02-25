<x-mail::message>
# {{ $title }}

{{ $type }} {{ $name }}

{!! str($content)->markdown()->sanitizeHtml() !!}

</x-mail::message>
