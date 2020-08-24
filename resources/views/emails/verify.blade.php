<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>Thanks for signing up, 
<br/>The journey has just begun, and soon you will be able to get your own certificate of diploma.</p>
<p>All you need to do now is complete your registration by verify your account:</p>
<p><b>{{ $row->verification }}</b></p>

<p><br/>Best wishes,</p>
<p>The AIPS Team</p>

<p><hr></p>
<p style='color:#a5a5a5;font-size:11px'>
  You received this email because you are a registered member on AIPS, 
  Replies to this email address will not be read
</p>
<p style='color:#a5a5a5;font-size:11px'>
  Copyright {{date('Y')}} American Institute of Professional Studies Incorporated. All rights reserved.
</p>
</body>
</html>