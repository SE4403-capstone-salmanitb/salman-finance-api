namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GeolocationService;
use Illuminate\Support\Facades\DB;

class UpdateSessionLocations extends Command
{
    protected $signature = 'sessions:update-locations';
    protected $description = 'Update session locations using geolocation service';
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        parent::__construct();
        $this->geolocationService = $geolocationService;
    }

    public function handle()
    {
        $sessions = DB::table('sessions')->whereNull('location')->get();

        foreach ($sessions as $session) {
            $locationData = $this->geolocationService->getGeolocation($session->ip_address);

            if (isset($locationData['latitude']) && isset($locationData['longitude'])) {
                DB::table('sessions')
                    ->where('id', $session->id)
                    ->update([
                        'location' => DB::raw("ST_GeomFromText('POINT({$locationData['latitude']} {$locationData['longitude']})')")
                    ]);
            }
        }

        $this->info('Session locations updated successfully.');
    }
}