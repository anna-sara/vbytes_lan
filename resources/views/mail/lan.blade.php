<div>
    <h1>{{$title}}</h1>
    <p>{{$type}} {{$name}}!</p>
    <div>{!! str($content)->markdown()->sanitizeHtml() !!}</div>
<div>
