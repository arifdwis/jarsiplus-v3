<?php

/* Author : Noviyanto Rahmadi 
 * E-mail : novay@btekno.id
 * Copyright 2020 Borneo Teknomedia. */

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

if(!function_exists('me')) {
    function me() {
        $user = Auth::user();
        return $user;
    }
}

if(!function_exists('role_me')) {
    function role_me() {
        $role_id = Auth::user()->roles->first()->id;
        return $role_id;
    }
}


if(!function_exists('template')) {
    function template($temp) {
        return 'https://cdn.samarindakota.go.id/template/'.$temp;
    }
}

if(!function_exists('apiSmr')) {
    function apiSmr($endpoint,$method = null, $body = null)
    {
        $url = 'https://samarindakota.go.id/api/'.$endpoint;
        return apiClient($url,$method,$body);
    }
}

if(!function_exists('permohonan_files')) {
    function permohonan_files() {
        return [
            'pdf'  => 'pdf',
            'word' => 'word',
            'png'  => 'png',
            'mp4'  => 'mp4',
        ];
    }
}

if(!function_exists('apiClient')) {
    function apiClient($url, $method = null, $body = null, $token = null, $id_endpoint = null) {
        $client = new GuzzleHttp\Client();
        $timeout = 5;
        try {

            if($method == null) {
                $res = $client->request('GET', $url, [
                    'verify' => false,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'      => 'application/json',
                        'Authorization' => $token
                    ], 
                    [
                            'timeout' => $timeout, // Response timeout
                            'connect_timeout' => $timeout, // Connection timeout
                        ],
                        'json' => $body
                    ]);
            } else {
                switch ($method) {
                    case 'GET':
                    $res = $client->request('GET', $url, [
                        'verify' => false,
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept'      => 'application/json',
                            'Authorization' => $token
                        ],
                        [
                                    'timeout' => $timeout, // Response timeout
                                    'connect_timeout' => $timeout, // Connection timeout
                                ],
                                'json' => $body
                            ]);
                    break;
                    case 'POST':
                    $res = $client->post($url, [
                        'verify' => false,
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Accept'      => 'application/json',
                            'Authorization' => $token
                        ],
                        [
                                    'timeout' => $timeout, // Response timeout
                                    'connect_timeout' => $timeout, // Connection timeout
                                ],
                                'json' => $body
                            ]);
                    break;
                    case 'PUT':
                    $res = $client->put($url, [
                        'verify' => false,
                        'headers' => [
                            'Content-Type' => 'application/x-www-form-urlencoded',
                            'Accept'      => 'application/json',
                            'Authorization' => $token
                        ],
                        [
                                    'timeout' => $timeout, // Response timeout
                                    'connect_timeout' => $timeout, // Connection timeout
                                ],
                                'json' => $body
                            ]);
                    break;
                    default:
                    break;
                }
            }

            $code = $res->getStatusCode();
            if ($code == 200) {
                $data = json_decode($res->getBody(), true);
                return $data;
            }else{
                $data['messages'] = 'Terdapat kendala pada server yang dituju.';
                return response()->json($data);
            }


        } catch (ConnectException $e) {
            $code = 504;
            return response()->json($code);

        } catch (RequestException $e) {
            $res = $e->getResponse();
            $code = 500;
            return response()->json($code);

        }
        
        
    }
}

if (!function_exists('kode')) {
    function kode($length){
        $unique = substr(uniqid(rand(), true), $length, $length);
        return $unique;
    }
}

if (!function_exists('send_whatshapp')) {
    function send_whatshapp($number, $message)
    {
        $url = "https://gowa.samarindakota.go.id/send/message";
        $username = "admingowa";
        $password = "53v2fBqxsC8y";
        $number = preg_replace('/\D+/', '', (string) $number);

        if (strpos($number, '0') === 0) {
            $number = '62' . substr($number, 1);
        } elseif (strpos($number, '8') === 0) {
            $number = '62' . $number;
        }

        if (!preg_match('/^62[0-9]{8,15}$/', $number)) {
            return [
                'success' => false,
                'message' => 'Format nomor WhatsApp tidak valid. Gunakan nomor seluler Indonesia.',
            ];
        }

        try {
            $client = new \GuzzleHttp\Client([
                'verify' => false,
                'timeout' => 30,
                'http_errors' => false
            ]);

            $res = $client->get($url, [
                'auth' => [$username, $password],
                'query' => [
                    'number'  => $number,
                    'message' => $message
                ]
            ]);

            $statusCode = $res->getStatusCode();
            $body = (string) $res->getBody();
            $response = json_decode($body, true);

            if (!is_array($response)) {
                $response = [];
            }

            if ($statusCode < 200 || $statusCode >= 300) {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? whatsapp_gateway_http_error_message($statusCode),
                    'status_code' => $statusCode,
                    'data' => $body,
                ];
            }

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }
}

if (!function_exists('whatsapp_gateway_http_error_message')) {
    function whatsapp_gateway_http_error_message($statusCode)
    {
        if ((int) $statusCode === 526) {
            return 'Gateway WhatsApp tidak dapat diakses karena sertifikat SSL server asal tidak valid (Cloudflare 526).';
        }

        return 'HTTP Error: ' . $statusCode;
    }
}

if (!function_exists('send_group_whatsapp')) {
    function send_group_whatsapp($message, $number = "120363154457667659@g.us")
    {
        $url = "https://gowa.samarindakota.go.id/send/message";
        $username = "admingowa";
        $password = "53v2fBqxsC8y";
        
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => false,
                'timeout' => 30,
                'http_errors' => false
            ]);
            
            $res = $client->get($url, [
                'auth' => [$username, $password], 
                'query' => [
                    'number' => $number,
                    'message' => $message
                ]
            ]);
            
            $statusCode = $res->getStatusCode();
            $response = json_decode($res->getBody(), true);
            
            if ($statusCode != 200) {
                return [
                    'success' => false,
                    'message' => whatsapp_gateway_http_error_message($statusCode),
                    'data' => $response
                ];
            }
            
            return $response;
            
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return [
                'success' => false,
                'message' => 'Request Error: ' . $e->getMessage(),
                'code' => $e->getCode()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'General Error: ' . $e->getMessage(),
            ];
        }
    }
}

if (! function_exists('jp_isi')) {
    /**
     * Normalkan nilai tampilan.
     *
     * Banyak kolom lama diisi tanda hubung ("-") atau spasi sebagai penanda
     * kosong, sehingga filled() menganggapnya berisi dan UI menampilkan "-"
     * alih-alih penanda "Belum diisi". Fungsi ini mengembalikan null untuk
     * nilai-nilai semacam itu.
     *
     * @param  mixed  $value
     * @return string|null
     */
    function jp_isi($value)
    {
        if (is_array($value) || is_object($value)) {
            return null;
        }

        $value = trim((string) $value);

        if ($value === '' || in_array($value, ['-', '--', 'null', 'NULL', 'N/A', 'n/a'], true)) {
            return null;
        }

        return $value;
    }
}

if (! function_exists('sync_to_s3')) {
    /**
     * Sinkronisasikan berkas lokal ke AWS S3 tanpa menghapus berkas di aplikasi lokal.
     *
     * @param string $path
     * @return bool
     */
    function sync_to_s3($path)
    {
        if (empty($path)) {
            return false;
        }

        try {
            $fullPath = null;
            $s3Key = null;

            if (file_exists($path) && is_file($path)) {
                $fullPath = $path;
                if (str_contains($path, 'storage/app/public/')) {
                    $s3Key = substr($path, strpos($path, 'storage/app/public/') + strlen('storage/app/public/'));
                } elseif (str_contains($path, 'public_html/storage/')) {
                    $s3Key = 'storage/' . substr($path, strpos($path, 'public_html/storage/') + strlen('public_html/storage/'));
                } elseif (str_contains($path, 'public/storage/')) {
                    $s3Key = 'storage/' . substr($path, strpos($path, 'public/storage/') + strlen('public/storage/'));
                } else {
                    $s3Key = ltrim($path, '/');
                }
            } else {
                $s3Key = ltrim($path, '/');
                $cleanPath = ltrim(str_replace(['storage/', 'public/'], '', $path), '/');

                $candidates = [
                    storage_path('app/public/' . $cleanPath),
                    public_path('storage/' . $cleanPath),
                    base_path('public_html/storage/' . $cleanPath),
                    public_path($path),
                    base_path($path),
                ];

                foreach ($candidates as $candidate) {
                    if (file_exists($candidate) && is_file($candidate)) {
                        $fullPath = $candidate;
                        break;
                    }
                }
            }

            if (!$fullPath || !file_exists($fullPath) || !is_file($fullPath)) {
                return false;
            }

            $s3Key = ltrim(str_replace('//', '/', $s3Key), '/');

            $stream = fopen($fullPath, 'r+');
            if ($stream) {
                \Illuminate\Support\Facades\Storage::disk('s3')->put($s3Key, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
                return true;
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('S3 Sync Warning: ' . $e->getMessage(), ['path' => $path]);
        }

        return false;
    }
}

if (! function_exists('file_url')) {
    /**
     * Dapatkan URL berkas (fleksibel: mendukung S3 CloudFront & Storage Lokal).
     *
     * @param string|null $path
     * @param string $disk 'auto'|'s3'|'local'
     * @return string|null
     */
    function file_url($path, $disk = 'auto')
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');

        if ($disk === 's3' || env('FILESYSTEM_DRIVER') === 's3') {
            return env('AWS_URL', 'https://d3dyajxapape7i.cloudfront.net') . '/' . $cleanPath;
        }

        if (str_starts_with($cleanPath, 'storage/')) {
            return asset($cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }
}

if (! function_exists('s3_url')) {
    /**
     * Dapatkan URL berkas langsung dari AWS S3 CloudFront.
     *
     * @param string|null $path
     * @return string|null
     */
    function s3_url($path)
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');

        if (!str_starts_with($cleanPath, 'storage/') && !str_starts_with($cleanPath, 'sikerja/') && !str_starts_with($cleanPath, 'jarsiplus/')) {
            $cleanPath = 'storage/' . $cleanPath;
        }

        return env('AWS_URL', 'https://d3dyajxapape7i.cloudfront.net') . '/' . $cleanPath;
    }
}


