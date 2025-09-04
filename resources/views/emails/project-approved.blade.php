<x-mail::message>
# Selamat, {{ $project->user->name }}!

Kabar gembira! Proyek portofolio Anda yang berjudul **"{{ $project->title }}"** telah direview dan disetujui oleh guru.

Proyek Anda kini sudah dipublikasikan di galeri dan dapat dilihat oleh semua orang. Ini adalah pencapaian yang luar biasa dan kami bangga dengan hasil kerja keras Anda.

<x-mail::button :url="route('portofolio.show', $project)">
Lihat Proyek Saya
</x-mail::button>

Teruslah berkarya dan ciptakan inovasi-inovasi selanjutnya!

Hormat kami,<br>
SMK-IT As-Syifa Boarding School
</x-mail::message>
