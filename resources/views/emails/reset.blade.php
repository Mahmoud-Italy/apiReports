<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>{!! nl2br($data->rbody1) !!}</p>

<p><br/></p>
<p>{!! nl2br($data->rbody2) !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->rbody3) !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! nl2br($data->rbody4) !!}</p>
</body>
</html>