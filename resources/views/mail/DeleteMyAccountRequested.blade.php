<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion Request</title>
    <!-- with UNPKG CDN (option 1) -->
    <script src="https://unpkg.com/tailwindcss-cdn@3.4.3/tailwindcss.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="bg-white rounded shadow p-6 mx-auto" style="max-width: 500px;">
        <h2 class="text-xl font-bold mb-4">Hello {{ $name }},</h2>
        <p class="mb-4">We have received a request to delete your account. If you made this request, please verify by clicking the button below.</p>
        <a href="{{ $verificationLink }}" class="inline-block bg-blue-500 text-white text-sm font-semibold rounded px-4 py-2">Verify Request</a>
        <p class="mt-4">Or you can copy and paste this link into your browser:</p>
        <p class="text-sm text-gray-600">{{ $verificationLink }}</p>
        <p class="mt-4">If you did not request to delete your account, please ignore this email.</p></br>
        <p class="mt-4">Best Wishes,</p>
        <p>{{ config('app.name') }}</p>
    </div>
</body>
</html>
