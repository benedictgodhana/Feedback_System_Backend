<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Your Feedback</title>
</head>
<body>
    <h1>Thank You for Your Feedback</h1>
    <p>Dear {{ $feedback->name }},</p>
    <p>Thank you for your feedback. We have received it and will review it shortly.</p>
    <p>Category: {{ $feedback->category->name }}</p>
    <p>Subcategory: {{ $feedback->subcategory->name }}</p>
    <p>Subject: {{ $feedback->subject }}</p>
    <p>Feedback: {{ $feedback->feedback }}</p>
</body>
</html>
