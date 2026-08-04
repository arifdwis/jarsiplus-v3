<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Formulir\Entities\Permohonan;

class PenjurianController extends Controller
{
    /**
     * Ambil daftar permohonan lengkap beserta pemohon, kategori, lokasi,
     * data dukung (file), indikator, dan parameter penilaian.
     * Filter opsional: status, tahun, q (cari label/kode).
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $tahun = $request->query('tahun');
        $search = $request->query('q');

        $query = Permohonan::with([
            'pemohon1',
            'pemohon2',
            'kategori',
            'provinsi',
            'kota',
            'permohonan', // relasi file pendukung dari Core\Entities\File
            'inovasis' => function ($q) {
                $q->with(['indikators', 'parameters', 'files']);
            },
        ])->orderByDesc('created_at');

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($tahun !== null) {
            $query->where('tahun', $tahun);
        }

        if ($search) {
            $query->where(function ($qq) use ($search) {
                $qq->where('label', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        $mapTahapan = [
            1 => 'Inisiatif',
            2 => 'Uji Coba',
            3 => 'Penerapan',
        ];

        $mapInisiator = [
            1 => 'Kepala Daerah',
            2 => 'Anggota DPRD',
            3 => 'OPD',
            4 => 'ASN',
            5 => 'Masyarakat',
        ];

        $mapJenis = [
            1 => 'Digital',
            2 => 'Non Digital',
        ];

        $data = $query->get()->map(function ($row) use ($mapTahapan, $mapInisiator, $mapJenis) {
            $rowArr = $row->toArray();

            $pemohon1 = $row->pemohon1;
            $pemohon2 = $row->pemohon2;

            $pemohonBiodata = function ($p) {
                if (!$p) return null;
                return [
                    'name' => $p->name,
                    'email' => $p->email,
                    'phone' => $p->phone,
                    'jabatan' => $p->jabatan,
                    'unit_kerja' => $p->unit_kerja,
                    'nip' => $p->nip,
                    'nik' => $p->nik,
                    'address' => $p->address,
                    'kota' => $p->kota,
                    'kota_id' => $p->kota_id,
                    'gender' => $p->gender,
                    'date_birth' => $p->date_birth,
                    'foto' => $p->foto,
                ];
            };

            return array_merge($rowArr, [
                // Ringkas: field label langsung
                'tahapan_label' => $mapTahapan[$row->tahapan] ?? null,
                'inisiator_label' => $mapInisiator[$row->inisiator] ?? null,
                'jenis_label' => $mapJenis[$row->jenis] ?? null,
                'kategori_label' => optional($row->kategori)->label,

                // Biodata pemohon (personal/corporate) agar tidak ambigu
                'pemohon_utama' => $pemohonBiodata($pemohon1),
                'pemohon_pendamping' => $pemohonBiodata($pemohon2),

                'tahapan_detail' => [
                    'value' => (int) $row->tahapan,
                    'label' => $mapTahapan[$row->tahapan] ?? null,
                ],
                'inisiator_detail' => [
                    'value' => (int) $row->inisiator,
                    'label' => $mapInisiator[$row->inisiator] ?? null,
                ],
                'jenis_detail' => [
                    'value' => (int) $row->jenis,
                    'label' => $mapJenis[$row->jenis] ?? null,
                ],
                'kategori_detail' => [
                    'id' => $row->id_kategori,
                    'label' => optional($row->kategori)->label,
                ],
            ]);
        });

        // Meta diagnostik untuk memastikan koneksi DB dan isi tabel
        $totalRows = DB::table('permohonan')->count();
        $modelCount = Permohonan::count();
        $dbName = DB::connection()->getDatabaseName();

        $appliedFilters = array_filter([
            'status' => $status,
            'tahun' => $tahun,
            'q' => $search,
        ], function ($v) {
            return $v !== null && $v !== '';
        });

        return response()->json([
            'success' => true,
            'message' => 'Data permohonan inovasi berhasil diambil',
            'data' => $data,
            'meta' => [
                'filtered_count' => $data->count(),
                'total_rows' => $totalRows,
                'model_count' => $modelCount,
                'db_name' => $dbName,
                'applied_filters' => $appliedFilters,
                'lookups' => [
                    'tahapan' => $mapTahapan,
                    'inisiator' => $mapInisiator,
                    'jenis' => $mapJenis,
                ],
            ],
        ]);
    }
}
