<!DOCTYPE html>
<html>
<head>
    <title>New Post</title>
</head>
<body>
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->description }}</p>
    <hr>
    <p>Thank you for subscribing to {{ $post->website->site_name }}.</p>
</body>
</html>