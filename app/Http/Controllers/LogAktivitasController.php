<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        return view('admin.log.index', [
            'logs' => LogAktivitas::with('user')->latest()->paginate(20),
        ]);
    }
}