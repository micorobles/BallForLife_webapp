<?php

namespace App\Libraries;

class TokenHelper
{

    private static $secret = 'z@[weU79NMf<ya;?^vp+x."vrX-CSaz&wf4Y2q=[TSxt2V6")7?f,4<~[M%>DwBj*2EVX@cJm$,M#93TyNQDe48?<*hjp@at5Ku/';

    public function generateToken($userID, $userRole)
    {

        $header = json_encode([
            'typ' => 'JWT',  // Token type
            'alg' => 'HS256' // Algo
        ]);

        $payload = json_encode([
            'user_id' => $userID,
            'user_role' => $userRole,
            'iat' => time(),        // Issued at
            // 'exp' => time() + 3600, // Token expires in 1 hour
            'exp' => time() + 86400, // Token expires in 24hrs
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

    public function validateToken($token)
    {

        // Split token into parts
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

        // Recalculate the signature
        $signature = $this->base64UrlEncode(hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, self::$secret, true));

        // Check if the provided signature matches the recalculated one
        if (!hash_equals($signature, $signatureEncoded)) {
            return false;
        }

        // Decode payload to check expiration
        $payloadDecoded = $this->base64UrlDecode($payloadEncoded);

        $payload = json_decode($payloadDecoded, true);

        // Check for expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            error_log("Token expired. Expiry Time: " . $payload['exp'] . " Current Time: " . time());
            return false;
        }

        return true;
    }

    // Add the decodeToken function to extract the user_id
    public function decodeToken($token)
    {
        // Split the token into its parts
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $token);

        // Decode the payload
        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);

        // Return the user_id if it exists
        return [
            'id' => isset($payload['user_id']) ? $payload['user_id'] : null,
            'role' => isset($payload['user_role']) ? $payload['user_role'] : null,
        ];
    }

    // public function extractToken($authorizationHeader) {
    //     $parts = explode(' ', $authorizationHeader);
    //     if (count($parts) === 2 && strtoupper($parts[0]) === 'BEARER') {
    //         $token = $parts[1];
    //         return $token;
    //     } else {
    //         return 'Invalid authorization header format';
    //     }
    // }

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
