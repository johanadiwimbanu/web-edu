<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseUploader
{
    public static function upload($file): ?string
    {
        $bucket = config('services.supabase.bucket');
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();

        $response = Http::withHeaders([
            'apikey' => config('services.supabase.key'),
            'Authorization' => 'Bearer ' . config('services.supabase.key'),
        ])->attach(
            'file',
            file_get_contents($file->getRealPath()),
            $fileName
        )->post(config('services.supabase.url') . "/storage/v1/object/$bucket/$fileName");

        return $response->successful() ? "$bucket/$fileName" : null;
    }
}
