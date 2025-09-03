<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class DashboardController extends Controller
    {
        /**
         * Menampilkan dashboard yang sesuai dengan peran pengguna.
         */
        public function index(Request $request): View
        {
            // Untuk saat ini, kita hanya menampilkan view yang sama.
            // Logika untuk konten dinamis akan ada di dalam file Blade.
            return view('dashboard');
        }
    }