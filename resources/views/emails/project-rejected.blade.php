<x-mail::message>
# Pemberitahuan Revisi untuk Proyek Portofolio Anda

Halo {{ $project->user->name }},

Terima kasih telah mengirimkan proyek Anda yang berjudul **"{{ $project->title }}"** untuk direview. Setelah diperiksa, ada beberapa masukan dari guru agar proyek Anda menjadi lebih baik.

Status proyek Anda telah dikembalikan ke **Draft**. Berikut adalah alasan penolakan/catatan revisi dari guru:

<x-mail::panel>
{{ $project->rejection_reason }}
</x-mail::panel>

Silakan perbaiki proyek Anda sesuai dengan masukan di atas, lalu ajukan kembali untuk direview. Jangan ragu untuk bertanya kepada guru pembimbing jika ada yang kurang jelas.

Semangat terus, kami menantikan versi terbaik dari karya Anda!

<x-mail::button :url="route('projects.edit', $project)">
Perbaiki Proyek Sekarang
</x-mail::button>

Hormat kami,<br>
SMK-IT As-Syifa Boarding School
</x-mail::message>