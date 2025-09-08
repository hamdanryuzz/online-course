<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        body { text-align: center; font-family: sans-serif; padding: 50px; }
        h1 { font-size: 48px; color: #4CAF50; }
        p { font-size: 24px; }
    </style>
</head>
<body>
    <h1>Certificate of Completion</h1>
    <p>This is to certify that</p>
    <h2>{{ $user->name }}</h2>
    <p>has successfully completed the course</p>
    <h3>{{ $course->name }}</h3>
    <p>with a score of {{ $score }}%</p>
    <p>Date: {{ date('d M Y') }}</p>
</body>
</html>
