<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->name }},<br/></p>

<p>{!! nl2br($row->message) !!}</p>

<p><br/></p>
<p>
Best wishes,<br/>
The BeMo Team
</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>
  You received this email because you are a registered member on BeMo, Replies to this email address will not be read
</p>
<p style='color:#a5a5a5;font-size:11px'>
  Copyright 2020 BeMo Professional Studies Incorporated. All rights reserved.
</p>
</body>
</html>