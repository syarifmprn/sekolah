<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="p-6 h-full">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Selamat datang <span class="text-blue-600">{{ Auth::user()->name }}</span> di Portal Sekolahku! 👋</h1>
            <p class="text-gray-500 mt-2 text-sm">Berikut adalah ringkasan statistik data portal sekolah Anda hari ini.</p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Berita</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalBerita) }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalGuru) }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Prestasi</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalPrestasi) }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pengumuman</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalPengumuman) }}</h3>
                </div>
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <!-- Chart 1: Berita Per Bulan (Line Chart) -->
            <div class="col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik Publikasi Berita (Tahun Ini)</h3>
                <div class="relative h-72">
                    <canvas id="beritaChart"></canvas>
                </div>
            </div>

            <!-- Chart 2: Komposisi Prestasi (Doughnut Chart) -->
            <div class="col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Komposisi Prestasi Berdasarkan Tingkat</h3>
                <div class="relative h-72 flex justify-center items-center">
                    @if(count($prestasiByTipe) > 0)
                        <canvas id="prestasiChart"></canvas>
                    @else
                        <p class="text-gray-400 italic">Belum ada data prestasi</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data Berita dari Controller
            const beritaData = @json(array_values($chartBerita));
            
            // Konfigurasi Line Chart (Berita)
            const ctxBerita = document.getElementById('beritaChart').getContext('2d');
            
            // Gradient Fill untuk Line Chart
            let gradient = ctxBerita.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)'); // blue-500
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            new Chart(ctxBerita, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Total Berita',
                        data: beritaData,
                        borderColor: '#3b82f6', // blue-500
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // membuat kurva melengkung (smooth)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [4, 4], color: '#f3f4f6' },
                            ticks: { precision: 0 } // membulatkan angka
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Data Prestasi dari Controller
            const rawPrestasi = @json($prestasiByTipe);
            if(Object.keys(rawPrestasi).length > 0) {
                const prestasiLabels = Object.keys(rawPrestasi);
                const prestasiData = Object.values(rawPrestasi);
                
                // Konfigurasi Doughnut Chart (Prestasi)
                const ctxPrestasi = document.getElementById('prestasiChart').getContext('2d');
                new Chart(ctxPrestasi, {
                    type: 'doughnut',
                    data: {
                        labels: prestasiLabels,
                        datasets: [{
                            data: prestasiData,
                            backgroundColor: [
                                '#3b82f6', // blue
                                '#10b981', // green
                                '#f59e0b', // yellow
                                '#8b5cf6', // purple
                                '#f43f5e'  // rose
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { usePointStyle: true, boxWidth: 8 }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
