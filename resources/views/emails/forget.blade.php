<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p v-html="{{ $data->fbody1 }}"></p>
<p><b>{{ $row->token }}</b></p>

<p><br/></p>
<p v-html="{{ $data->fbody2 }}"></p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->fbody3 }}"></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->fbody4 }}"></p>
</body>
</html>