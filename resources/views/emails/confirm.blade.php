<!DOCTYPE html>
<html>
<head>
</head>
<body>
	{{ $name }}, thank you for registering. We just need you to <a href="{{ route('email.confirm', ['email_token'=>$token]) }}">confirm</a> your email.
</body>
</html>