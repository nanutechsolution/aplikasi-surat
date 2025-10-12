<div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-xl shadow-lg flex items-center justify-between transform transition hover:scale-105">
                <div>
                    <p class="text-sm font-medium opacity-80">Total Surat Masuk</p>
                    <p class="text-3xl font-bold">{{ $totalSurat }}</p>
                </div>
                <div class="bg-white bg-opacity-30 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-xl shadow-lg flex items-center justify-between transform transition hover:scale-105">
                <div>
                    <p class="text-sm font-medium opacity-80">Surat Bulan Ini</p>
                    <p class="text-3xl font-bold">{{ $suratBulanIni }}</p>
                </div>
                <div class="bg-white bg-opacity-30 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-xl shadow-lg flex items-center justify-between transform transition hover:scale-105">
                <div>
                    <p class="text-sm font-medium opacity-80">Surat Hari Ini</p>
                    <p class="text-3xl font-bold">{{ $suratHariIni }}</p>
                </div>
                <div class="bg-white bg-opacity-30 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="mt-10 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Tren Surat Masuk (7 Hari Terakhir)</h3>
            <div x-data="chart({{ json_encode($chartData) }})">
                <canvas id="suratChart" height="120"></canvas>
            </div>

        </div>
    </div>
</div>
<script>
    function chart(chartData) {
        return {
            chartInstance: null,

            init() {
                const ctx = document.getElementById('suratChart').getContext('2d');
                this.chartInstance = new Chart(ctx, {
                    type: 'line'
                    , data: {
                        labels: chartData.labels
                        , datasets: [{
                            label: 'Jumlah Surat Masuk'
                            , data: chartData.data
                            , backgroundColor: 'rgba(59, 130, 246, 0.2)'
                            , borderColor: 'rgba(59, 130, 246, 1)'
                            , borderWidth: 2
                            , tension: 0.3
                            , fill: true
                            , pointBackgroundColor: 'rgba(59, 130, 246, 1)'
                            , pointBorderColor: '#fff'
                            , pointHoverRadius: 6
                        }]
                    }
                    , options: {
                        responsive: true
                        , plugins: {
                            legend: {
                                display: true
                            }
                        }
                        , scales: {
                            y: {
                                beginAtZero: true
                                , ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            },

            // panggil init setelah Alpine mount
            $nextTick() {
                this.init();
            }
        }
    }

</script>
