<div>
    <h1>{{$title}}</h1>
    <div>{{$type}} {{$name}} {!! str($content)->markdown()->sanitizeHtml() !!}</div>
<div>
