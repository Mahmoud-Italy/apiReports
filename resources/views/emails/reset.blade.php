<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p v-html="{{ $data->rbody1 }}"></p>

<p><br/></p>
<p v-html="{{ $data->rbody2 }}"></p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->rbody3 }}"></p>
<p style='color:#a5a5a5;font-size:11px' v-html="{{ $data->rbody4 }}"></p>
</body>
</html>