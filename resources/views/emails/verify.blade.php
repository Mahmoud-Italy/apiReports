<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>{!! nl2br($data->vbody1) !!}</p>

<p><b>{{ $row->verification }}</b></p>

<p><br/></p>
<p>{!! nl2br($data->vbody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->vbody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->vbody4) !!}</p>
</body>
</html>