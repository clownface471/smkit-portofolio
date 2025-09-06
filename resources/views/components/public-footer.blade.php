<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
              <a href="{{ route('home') }}" class="flex items-center">
                  <x-application-logo class="h-8 me-3" />
                  <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Portofolio Siswa</span>
              </a>
              <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                Platform untuk menampilkan talenta dan inovasi dari siswa-siswi berprestasi SMK-IT As-Syifa Boarding School.
              </p>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Tautan Cepat</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="{{ route('portofolio.gallery') }}" class="hover:underline">Galeri Karya</a>
                      </li>
                      <li>
                          <a href="https://smkit.assyifa.sch.id/" target="_blank" class="hover:underline">Website Sekolah</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Jurusan</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="{{ route('portofolio.gallery', ['jurusan' => 'RPL']) }}" class="hover:underline">RPL</a>
                      </li>
                      <li>
                          <a href="{{ route('portofolio.gallery', ['jurusan' => 'DKV']) }}" class="hover:underline">DKV</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Privacy Policy</a>
                      </li>
                      <li>
                          <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a href="https://smkit.assyifa.sch.id/" class="hover:underline">SMK-IT As-Syifa Boarding School™</a>. All Rights Reserved.
          </span>
      </div>
    </div>
</footer>
