<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title') :: {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/lib/bootstrap/bootstrap.min.css">
</head>
<body>
	@yield('content')
</body>
</html>