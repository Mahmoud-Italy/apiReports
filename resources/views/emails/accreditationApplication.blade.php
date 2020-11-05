<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row }},<br/></p>

<p>{!! nl2br($data->aabody1) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->aabody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->aabody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->aabody4) !!}</p>
</body>
</html>