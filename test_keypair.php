<?php

// Include the Composer autoload file
require 'vendor/autoload.php';

// Use the Keypair class from the Soneso\StellarSDK namespace
use Soneso\StellarSDK\Crypto\KeyPair;

// Create a new Keypair instance
try {
    $keyPair = Keypair::random();
    echo "Wallet Address: " . $keyPair->getAccountId() . PHP_EOL;
    echo "Secret Seed: " . $keyPair->getSecretSeed() . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
