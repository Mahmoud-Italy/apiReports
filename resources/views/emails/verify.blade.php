<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p v-html="{{ $data->vbody1 }}"></p>
<p><b>{{ $row->verification }}</b></p>

<p><br/></p>
<p v-html="{{ $data->vbody2 }}"></p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->vbody3 }}"></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->vbody4 }}"></p>
</body>
</html>