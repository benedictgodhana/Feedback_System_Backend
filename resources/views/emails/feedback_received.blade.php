<!DOCTYPE html>
<html>
<head>
    <title>New Feedback Received</title>
</head>
<body>
    <h1>New Feedback Received</h1>
    <p>Category: {{ $feedback->category->name }}</p>
    <p>Subcategory: {{ $feedback->subcategory->name }}</p>
    <p>Subject: {{ $feedback->subject }}</p>
    <p>Feedback: {{ $feedback->feedback }}</p>
</body>
</html>
