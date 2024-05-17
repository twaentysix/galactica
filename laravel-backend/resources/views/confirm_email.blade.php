<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Email Confirmation</h1>
    @if ($confirmed)
    <p>Your email address has been successfully confirmed.</p>
    @else
    <p>Oops! It seems there was an issue confirming your email address.</p>
    @endif
</div>
</body>
</html>
