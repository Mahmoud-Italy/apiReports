<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<p>Hi {{ $row->first_name }},<br/></p>

<p>Your account verified successfully.</p>

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