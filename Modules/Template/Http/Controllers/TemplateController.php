<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TemplateController extends Controller
{
     /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->module = strtolower('Template');
        $this->entiti = strtolower('Home');

        view()->share([
            'title' => $this->title,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $sliders = class_exists(\Modules\Core\Entities\Slider::class)
            ? \Modules\Core\Entities\Slider::latest()->take(5)->get()
            : collect();

        $totalPermohonan = class_exists(\Modules\Formulir\Entities\Permohonan::class) ? \Modules\Formulir\Entities\Permohonan::count() : 0;
        $approvedPermohonan = class_exists(\Modules\Formulir\Entities\Permohonan::class) ? \Modules\Formulir\Entities\Permohonan::where('status', 1)->count() : 0;
        $processPermohonan = class_exists(\Modules\Formulir\Entities\Permohonan::class) ? \Modules\Formulir\Entities\Permohonan::where('status', 0)->count() : 0;
        $totalPemohon = class_exists(\Modules\Pemohon\Entities\Pemohon::class) ? \Modules\Pemohon\Entities\Pemohon::count() : 0;

        $stats = [
            'total' => $totalPermohonan,
            'approved' => $approvedPermohonan,
            'process' => $processPermohonan,
            'innovators' => $totalPemohon,
        ];

        $lamans = class_exists(\Modules\Core\Entities\Laman::class)
            ? \Modules\Core\Entities\Laman::where('status', 1)->latest()->take(6)->get()
            : collect();

        $inovasis = class_exists(\Modules\Formulir\Entities\Permohonan::class)
            ? \Modules\Formulir\Entities\Permohonan::with(['pemohon1', 'kategori'])->latest()->take(6)->get()
            : collect();

        $faqs = class_exists(\Modules\Faq\Entities\Faq::class)
            ? \Modules\Faq\Entities\Faq::take(5)->get()
            : collect();

        $events = class_exists(\Modules\Core\Entities\Event::class)
            ? \Modules\Core\Entities\Event::where('status', 1)->latest()->get()
            : collect();

        return view('template::index', compact('events', 'sliders', 'stats', 'lamans', 'inovasis', 'faqs'));
    }

    public function informasi(Request $request)
    {
        $sliders = class_exists(\Modules\Core\Entities\Slider::class)
            ? \Modules\Core\Entities\Slider::latest()->take(5)->get()
            : collect();

        $lamans = class_exists(\Modules\Core\Entities\Laman::class)
            ? \Modules\Core\Entities\Laman::latest()->paginate(9)
            : collect();

        return view('template::informasi', compact('sliders', 'lamans'));
    }

    /**
     * Status usulan yang boleh tampil di katalog publik.
     *
     * 0 = menunggu validasi, 9 = ditolak — keduanya sengaja dikecualikan agar
     * usulan yang belum/tidak lolos verifikasi tidak terpublikasi.
     *
     * @var array
     */
    public const STATUS_PUBLIK = [1, 2, 4];

    /**
     * Katalog inovasi untuk publik (tanpa login).
     * @return Renderable
     */
    public function inovasi(Request $request)
    {
        abort_unless(class_exists(\Modules\Formulir\Entities\Permohonan::class), 404);

        $query = \Modules\Formulir\Entities\Permohonan::with(['pemohon1', 'kategori'])
            ->whereIn('status', self::STATUS_PUBLIK);

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->keyword);
            $query->where(function ($q) use ($kw) {
                $q->where('label', 'like', "%{$kw}%")
                  ->orWhere('urusan_utama', 'like', "%{$kw}%")
                  ->orWhereHas('pemohon1', function ($sub) use ($kw) {
                      $sub->where('unit_kerja', 'like', "%{$kw}%");
                  });
            });
        }

        $data = $query->latest()->paginate(12)->appends($request->query());

        return view('template::inovasi.index', compact('data'));
    }

    /**
     * Detail inovasi untuk publik (tanpa login).
     *
     * Hanya menampilkan informasi inovasinya. Data pribadi inovator
     * (NIK, NIP, nomor telepon, email) sengaja tidak disertakan di sini —
     * itu hanya tersedia pada halaman terautentikasi.
     *
     * @return Renderable
     */
    public function inovasiShow($uuid)
    {
        abort_unless(class_exists(\Modules\Formulir\Entities\Permohonan::class), 404);

        $data = \Modules\Formulir\Entities\Permohonan::with(['pemohon1', 'kategori'])
            ->where('uuid', $uuid)
            ->whereIn('status', self::STATUS_PUBLIK)
            ->first();

        abort_if(!$data, 404);

        $lainnya = \Modules\Formulir\Entities\Permohonan::with(['pemohon1', 'kategori'])
            ->whereIn('status', self::STATUS_PUBLIK)
            ->where('id', '!=', $data->id)
            ->latest()
            ->take(3)
            ->get();

        return view('template::inovasi.show', compact('data', 'lainnya'));
    }

     /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function maintenance()
    {
        return view('template::maintenance');
    }


}
