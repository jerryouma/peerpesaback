<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Soneso\StellarSDK\Crypto\KeyPair; // Stellar SDK
use Elliptic\EC;
use kornrunner\Keccak;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        // Middleware is now managed in the routes file
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        try {
            // Generate Stellar wallet
            $stellarKeyPair = KeyPair::random();
            $stellarWalletAddress = $stellarKeyPair->getAccountId();
            $stellarWalletSecret = $stellarKeyPair->getSecretSeed();
            Log::info('Generated Stellar Wallet Address: ' . $stellarWalletAddress);
            Log::info('Generated Stellar Wallet Secret: ' . $stellarWalletSecret);

            // Generate Ethereum wallet
            $ethereumAddress = $this->generateEthereumAddress();

            // Generate Celo wallet (same method as Ethereum since Celo is EVM-compatible)
            $celoAddress = $this->generateEthereumAddress();

            // Log Ethereum and Celo addresses
            Log::info('Generated Ethereum Wallet Address: ' . $ethereumAddress);
            Log::info('Generated Celo Wallet Address: ' . $celoAddress);

            // Create and return the new user with wallet addresses
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'stellar_wallet_address' => $stellarWalletAddress,
                'stellar_wallet_secret' => $stellarWalletSecret,
                'ethereum_wallet_address' => $ethereumAddress,
                'celo_wallet_address' => $celoAddress,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return null; // or handle the error as needed
        }
    }

    // Generate Ethereum wallet address
    private function generateEthereumAddress()
    {
        try {
            $ec = new EC('secp256k1');
            $keyPair = $ec->genKeyPair();
            $publicKey = $keyPair->getPublic(false, 'hex');
            $address = '0x' . substr(Keccak::hash(substr(hex2bin($publicKey), 1), 256), 24);
            return $address;
        } catch (\Exception $e) {
            Log::error('Exception in Ethereum address generation: ' . $e->getMessage());
            return null;
        }
    }
}
