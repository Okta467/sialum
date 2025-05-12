<?php

if (!function_exists('fileUpload')) {

    /**
     * Fetch JSON API
     * @param string $url
     * @param array $headers
     * @param string $method
     */
    function fetchApiJson($url, $headers = [], $method = 'GET', $payload = null) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Optional headers
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Optional POST, PUT, etc.
        if (strtoupper($method) != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
            if (!empty($payload)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                // Add JSON header automatically if sending data
                if (!in_array('Content-Type: application/json', $headers)) {
                    $headers[] = 'Content-Type: application/json';
                }
            }
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        // Decode JSON
        return json_decode($response, true);
    }
}
