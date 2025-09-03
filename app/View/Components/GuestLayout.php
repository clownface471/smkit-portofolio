<?php

    namespace App\View\Components;

    use Illuminate\View\Component;
    use Illuminate\View\View;

    class GuestLayout extends Component
    {
        /**
         * Menentukan apakah layout harus lebar penuh.
         *
         * @var bool
         */
        public $fullWidth;

        /**
         * Buat instance komponen baru.
         */
        public function __construct($fullWidth = false)
        {
            $this->fullWidth = $fullWidth;
        }

        /**
         * Dapatkan view / konten yang merepresentasikan komponen.
         */
        public function render(): View
        {
            return view('layouts.guest');
        }
    }
    
