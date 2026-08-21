<?php
namespace App\Http\Controllers;
use App\Models\Pengaduan;
class AdminPengaduanController extends Controller
{
    public function index()
    {
        abort_unless(in_array((int) role_me(), [1, 2, 3], true), 403);
        $items = Pengaduan::latest()->paginate(20);
        return view('pengaduan.admin', compact('items'));
    }
}
