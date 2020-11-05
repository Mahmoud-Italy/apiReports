<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row }},<br/></p>

<p>{!! nl2br($data->iabody1) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->iabody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->iabody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->iabody4) !!}</p>
</body>
</html>