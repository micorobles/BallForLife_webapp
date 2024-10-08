<?php

namespace App\Libraries;

class TokenHelper
{

    private static $secret = 'z@[weU79NMf<ya;?^vp+x."vrX-CSaz&wf4Y2q=[TSxt2V6")7?f,4<~[M%>DwBj*2EVX@cJm$,M#93TyNQDe48?<*hjp@at5Ku/';

    public function generateToken($userID)
    {

        $header = json_encode([
            'typ' => 'JWT',  // Token type
            'alg' => 'HS256' // Algo
        ]);

        $payload = json_encode([
            'user_id' => $userID,
            'iat' => time(),        // Issued at
            'exp' => time() + 3600, // Token expires in 1 hour
        ]);

        // Encode header and payload
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        // Create Signature Hash (Header + Payload + Secret Key)
        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        // Return the complete token
        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
    }

    public function validateToken($token) {

        // Split token into parts
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

        // Recalculate the signature
        $signature = $this->base64UrlEncode(hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, self::$secret, true));

        // Check if the provided signature matches the recalculated one
        return hash_equals($signature, $signatureEncoded);
    }

    public function decodeToken($token)
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);
        return $payload; // Returns decoded payload as an array
    }

    public function extractToken($authorizationHeader) {
        $parts = explode(' ', $authorizationHeader);
        if (count($parts) === 2 && strtoupper($parts[0]) === 'BEARER') {
            $token = $parts[1];
            return $token;
        } else {
            return 'Invalid authorization header format';
        }
    }

    // Helper functions to encode and decode base64 URL strings
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
