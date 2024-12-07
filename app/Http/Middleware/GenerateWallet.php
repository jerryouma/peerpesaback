<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use Closure;
class GenerateWallet
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user && !$user->wallet_address) {
            $client = new Client(['base_uri' => 'https://api.yellowcard.io']);
            $response = $client->post('/createWallet', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('YELLOWCARD_API_KEY'),
                ],
            ]);
            $walletData = json_decode($response->getBody(), true);
            $user->wallet_address = $walletData['address'];
            $user->save();
        }
        return $next($request);
    }
}
