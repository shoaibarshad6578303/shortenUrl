<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\UrlShortener;
use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\Support\Facades\Redirect;

class UrlShortenerController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.url')."/r/";
    }

    public function shorten(StoreShortUrlRequest $request)
    {

        $originalUrl = $request->input('url');
        $apiKey = config('app.google_safe_browser_key');
        $apiUrl = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=$apiKey";

        // Validate URL using Google Safe Browsing API
        $response = Http::post($apiUrl, [
            'client' => [
                'clientId' => config('app.google_client_id'),
                'clientVersion' => '1.0.0',
            ],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [['url' => $originalUrl]],
            ],
        ]);

        $data = $response->json();
        
        if (!empty($data['matches'])) {
            return response()->json(['error' => 'The provided URL is not safe. Please try another URL.'], 400);
        }

        // Check if the URL already has a short URL in database
        $url = UrlShortener::where('url', $this->baseUrl.$originalUrl)->first();
        if (!empty($url)) {
            return response()->json(['shortUrl' => $url->short_url]);
        }

        // Generate short URL
        $hash = substr(md5($originalUrl), 0, 6);
        $shortUrl = "$hash";
        

        // Save the short URL
        UrlShortener::create([
            'url' => $originalUrl,
            'short_url' => $shortUrl
        ]);

        return response()->json(['shortUrl' => $this->baseUrl.$shortUrl]);
    }

    public function redirect($hash)
    {
        $originalUrl = UrlShortener::where('short_url', $hash)->first();
        
        if (!$originalUrl) {
            abort(404);
        }

        return Redirect::away($originalUrl->url);
    }
}
