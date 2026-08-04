<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchJuriData extends Command
{
    protected $signature = 'juri:fetch';
    protected $description = 'Fetch data penilaian juri';

    public function handle()
    {
        try {
            $endpoint = env('JURI_API_PENILAIAN_URL', 'https://juri-jarsiplus.samarindakota.go.id/api/penilaian-juri');
            $response = Http::get($endpoint);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('Data juri', $data);

                $this->info('Berhasil fetch data');
            } else {
                Log::error('Gagal fetch data', [
                    'status' => $response->status(),
                    'endpoint' => $endpoint,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error fetch juri: '.$e->getMessage());
        }
    }
}