<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function sendMessage($message)
    {
        $botToken = Setting::where('key', 'telegram_bot_token')->value('value');
        $users = \App\Models\TelegramUser::all();

        if (empty($botToken) || $users->isEmpty()) {
            Log::warning('Telegram configuration or users are missing. Cannot send message.');
            return false;
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $success = false;

        foreach ($users as $user) {
            $chatId = trim($user->chat_id);
            if (empty($chatId)) continue;
            
            $receiverName = $user->name ?? 'Bapak/Ibu';
            $finalMessage = "Halo <b>{$receiverName}</b>,\n\n" . $message;
            
            try {
                $response = Http::post($url, [
                    'chat_id' => $chatId,
                    'text' => $finalMessage,
                    'parse_mode' => 'HTML',
                ]);

                if ($response->successful()) {
                    $success = true;
                } else {
                    Log::error("Telegram API Error for ID {$chatId}: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("Telegram Exception for ID {$chatId}: " . $e->getMessage());
            }
        }
        
        return $success;
    }
}
