<x-layouts.app>
    <!-- Hero Section -->
    <section class="hero py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Pemimpin dalam penggalangan dana online</h1>
                <p class="text-xl mb-8">Baik Anda individu atau organisasi, dapatkan bantuan yang Anda butuhkan dengan platform Bantoo! yang powerful.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('home') }}#cara-kerja" class="bg-transparent border-2 border-white px-6 py-3 rounded-full font-bold hover:bg-white hover:text-blue-600 transition">Cara kerjanya</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-3xl text-green-500 mr-3"></i>
                    <span class="font-medium">Keamanan & Kepercayaan</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-medal text-3xl text-yellow-500 mr-3"></i>
                    <span class="font-medium">Proteksi Terjamin</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-headset text-3xl text-blue-500 mr-3"></i>
                    <span class="font-medium">Dukungan Ahli 24/7</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Campaigns -->
    <section id="featured" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Penggalangan dana yang bisa Anda dukung</h2>
            <livewire:campaign.latest-campaign num="3"/>
            <div class="text-center mt-10">
              <a href="{{ route('campaign.show') }}" class="inline-block px-6 py-3 border-2 bg-green-600 text-white font-bold rounded-full hover:bg-green-500 transition">Lihat lebih banyak penggalangan dana</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="cara-kerja" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center">Cara Bantoo! bekerja</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center px-4">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-edit text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3">1. Mulai penggalangan dana Anda</h3>
                    <p class="text-gray-600">Mudah untuk memulai. Cukup ceritakan kisah Anda dan tetapkan tujuan.</p>
                </div>
                <div class="text-center px-4">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-share-alt text-3xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3">2. Bagikan dengan teman-teman</h3>
                    <p class="text-gray-600">Sebarkan berita melalui media sosial dan email.</p>
                </div>
                <div class="text-center px-4">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-md">
                        <i class="fas fa-hand-holding-usd text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3">3. Terima donasi</h3>
                    <p class="text-gray-600">Dapatkan dana langsung ke rekening bank Anda.</p>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('campaign.create') }}" class="load-more">Mulai penggalangan dana</a>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section id="kisah-sukses" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center">Kisah sukses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="campaign-card">
                    <div class="md:flex">
                        <div class="md:w-1/3">
                            <img src="/images/stocks/success01" alt="Success story" class="w-full h-full object-cover"/>
                        </div>
                        <div class="p-6 md:w-2/3">
                            <h3 class="font-bold text-xl mb-2">Terkumpul Rp1,7 miliar untuk operasi penyelamatan nyawa</h3>
                            <p class="text-gray-600 mb-4">"Terima kasih kepada Bantoo! dan kedermawanan 3.000 donatur, putri saya menerima perawatan yang dia butuhkan untuk bertahan hidup."</p>
                            <div class="flex items-center">
                                <img src="/images/stocks/woman" alt="User" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-medium">Jessica T.</p>
                                    <p class="text-sm text-gray-500">Penyelenggara penggalangan dana</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="campaign-card">
                    <div class="md:flex">
                        <div class="md:w-1/3">
                            <img src="/images/stocks/success02" alt="Success story" class="w-full h-full object-cover"/>
                        </div>
                        <div class="p-6 md:w-2/3">
                            <h3 class="font-bold text-xl mb-2">Membangun kembali pusat komunitas setelah kebakaran</h3>
                            <p class="text-gray-600 mb-4">"Komunitas kami bersatu dan mengumpulkan Rp1,2 miliar untuk membangun kembali pusat komunitas tercinta kami yang hancur dalam kebakaran."</p>
                            <div class="flex items-center">
                                <img src="/images/stocks/man" alt="User" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <p class="font-medium">Michael R.</p>
                                    <p class="text-sm text-gray-500">Direktur organisasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="hero py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap memulai penggalangan dana?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Bergabunglah dengan jutaan orang yang mengumpulkan uang untuk hal yang paling penting bagi mereka.</p>
            <a href="{{ route('campaign.create') }}" class="bg-transparent border-2 border-white px-6 py-3 rounded-full font-bold hover:bg-white hover:text-blue-600 transition">
                Mulai Penggalangan Dana
            </a>
        </div>
    </section>
</x-layouts.app>
