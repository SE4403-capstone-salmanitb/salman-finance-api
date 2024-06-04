namespace App\Services;

use GuzzleHttp\Client;

class GeolocationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('IP2LOCATION_API_KEY');
    }

    public function getGeolocation($ipAddress)
    {
        $response = $this->client->get("https://api.ip2location.io/?key={$this->apiKey}&ip={$ipAddress}&format=json");
        return json_decode($response->getBody(), true);
    }
}
