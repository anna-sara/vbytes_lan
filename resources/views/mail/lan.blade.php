<div>
    <h1>{{$title}}</h1>
    <div><span>{{$type}} {{$name}}</span><span>{!! str($content)->markdown()->stripTags('p')->sanitizeHtml() !!}</span></div>
<div>
