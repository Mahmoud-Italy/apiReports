<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row }},<br/></p>

<p>{!! nl2br($data->pabody1) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->pabody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->pabody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->pabody4) !!}</p>
</body>
</html>