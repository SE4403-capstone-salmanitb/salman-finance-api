use Illuminate\Http\Request;

class function showProfile(Request $request)
{
    $geolocationData = $request->geolocation;

    // Access geolocation attributes
    $ipAddress = $geolocationData['ip'];
    $country = $geolocationData['country'];
    $city = $geolocationData['city'];

    // Process the geolocation data
}
