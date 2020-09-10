<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>{!! nl2br($data->fbody1) !!}</p>
<p><b>{{ $row->token }}</b></p>

<p><br/></p>
<p>{!! nl2br($data->fbody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->fbody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->fbody4) !!}</p>
</body>
</html>