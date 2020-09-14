<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>{!! nl2br($data->cabody1) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->cabody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->cabody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->cabody4) !!}</p>
</body>
</html>