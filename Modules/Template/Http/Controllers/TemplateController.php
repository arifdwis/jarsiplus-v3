<?php

namespace Modules\Template\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Formulir\Entities\Permohonan;

class TemplateController extends Controller
{
    protected $title = 'Home';

    public function index(Request $request)
    {
        $permohonanCount = Permohonan::count();
        $prosesCount = Permohonan::where('status', 0)->count();
        $setujuCount = Permohonan::where('status', 1)->count();

        return Inertia::render('Welcome', [
            'permohonanCount' => $permohonanCount,
            'prosesCount' => $prosesCount,
            'setujuCount' => $setujuCount,
        ]);
    }

    public function informasi(Request $request)
    {
        return Inertia::render('Informasi/Index');
    }

    public function faq()
    {
        return Inertia::render('Faq/Index');
    }

    public function maintenance()
    {
        return Inertia::render('Maintenance');
    }
}
