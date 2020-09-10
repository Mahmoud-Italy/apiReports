<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>{!! $data->rbody1 !!}</p>

<p><br/></p>
<p>{!! $data->rbody2 !!}</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>{!! $data->rbody3 !!}</p>
<p style='color:#a5a5a5;font-size:11px'>{!! $data->rbody4 !!}</p>
</body>
</html>