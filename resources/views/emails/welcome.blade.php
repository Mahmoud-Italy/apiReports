<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p v-html="{{ $data->wbody1 }}"></p>

<p><br/></p>
<p v-html="{{ $data->wbody2 }}"></p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->wbody3 }}"></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->wbody4 }}"></p>
</body>
</html>