<?php

namespace App\Services;

class WhatsAppService
{
    private string $instance;
    private string $token;

    public function __construct()
    {
        $this->instance = env('ULTRAMSG_INSTANCE', '');
        $this->token    = env('ULTRAMSG_TOKEN', '');
    }

    public function sendText(string $toPhone, string $message): bool
    {
        $phone = $this->normalizePhone($toPhone);

        if (empty($phone)) {
            log_message('error', '[WhatsApp] Invalid phone: ' . $toPhone);
            return false;
        }

        $url = "https://api.ultramsg.com/{$this->instance}/messages/chat";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_POSTFIELDS     => http_build_query([
                'token'    => $this->token,
                'to'       => $phone,
                'body'     => $message,
                'priority' => 10,
            ]),
            CURLOPT_TIMEOUT => 10,
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            log_message('error', '[WhatsApp] cURL error: ' . $curlError);
            return false;
        }

        $decoded = json_decode($response, true);

        if (isset($decoded['error'])) {
            log_message('error', '[WhatsApp] API error: ' . $response);
            return false;
        }

        log_message('info', '[WhatsApp] Sent to ' . $phone . ' | ' . $response);
        return true;
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        // +92XXXXXXXXXX
        if (str_starts_with($phone, '+92') && strlen($digits) === 12) {
            return '+' . $digits;
        }

        // 03XXXXXXXXX → +923XXXXXXXXX
        if (str_starts_with($digits, '0') && strlen($digits) === 11) {
            return '+92' . substr($digits, 1);
        }

        // 923XXXXXXXXX
        if (str_starts_with($digits, '92') && strlen($digits) === 12) {
            return '+' . $digits;
        }

        return '';
    }
}