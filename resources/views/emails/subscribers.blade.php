<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<p>
<a href="{{$slug}}" traget="_blank">{{ $title }}</a>
</p>
<p>{!! nl2br($body) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->vbody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->vbody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->vbody4) !!}</p>
</body>
</html>