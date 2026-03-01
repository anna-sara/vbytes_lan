<div>
    <h1>{{$title}}</h1>
    <div>{!! str($content)->replace('[NAME]', $name)->markdown()->sanitizeHtml() !!}</div>
<div>
