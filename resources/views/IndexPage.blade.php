<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 p-6 flex items-center justify-center h-screen">
    <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
        <div class="mb-4">
            <h1 class="text-grey-darkest">{{ config('app.name') }}</h1>
            <p class="text-grey-darker">
                This product includes GeoLite2 data created by MaxMind, available from
                <a class="text-blue-500 hover:text-blue-800" href="https://www.maxmind.com">https://www.maxmind.com</a> and 
                uses IP2Location.io <a class="text-blue-500 hover:text-blue-800" href="https://www.ip2location.io">IP geolocation</a> web service.
            </p>
        </div>
        <div class="mb-3">
            <label class="text-grey-darker block mb-2">Laravel Version</label>
            <p class="px-3 py-2 bg-grey-lighter text-grey-darker border rounded shadow">{{ $laravelVersion }}</p>
        </div>
        <div class="mb-3">
            <label class="text-grey-darker block mb-2">PHP Version</label>
            <p class="px-3 py-2 bg-grey-lighter text-grey-darker border rounded shadow">{{ $phpVersion }}</p>
        </div>
    </div>
</body>
</html>
