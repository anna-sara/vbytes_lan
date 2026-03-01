<div>
    <h1>{{$title}}</h1>
    <div><span>{{$type}} {{$name}}</span> {!! str($content)->markdown()->sanitizeHtml() !!}</div>
<div>
