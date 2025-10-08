<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Surat Masuk</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalSurat }}</p>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $suratBulanIni }}</p>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Surat Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $suratHariIni }}</p>
                </div>
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Surat Masuk (7 Hari Terakhir)</h3>
            <div x-data="chart()" x-init="initChart()" @update-chart.window="updateChartData($event.detail.data)">
                <canvas id="suratChart" height="120"></canvas>
            </div>
        </div> --}}
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function chart() {
        return {
            chartInstance: null
            , initChart() {
                const ctx = document.getElementById('suratChart').getContext('2d');
                this.chartInstance = new Chart(ctx, {
                    type: 'line', // Jenis grafik
                    data: {
                        labels: [], // Akan diisi oleh Livewire
                        datasets: [{
                            label: 'Jumlah Surat Masuk'
                            , data: [], // Akan diisi oleh Livewire
                            backgroundColor: 'rgba(59, 130, 246, 0.2)'
                            , borderColor: 'rgba(59, 130, 246, 1)'
                            , borderWidth: 2
                            , tension: 0.3, // Membuat garis lebih melengkung
                            fill: true
                        , }]
                    }
                    , options: {
                        scales: {
                            y: {
                                beginAtZero: true
                                , ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
            , updateChartData(data) {
                if (this.chartInstance) {
                    this.chartInstance.data.labels = data.labels;
                    this.chartInstance.data.datasets[0].data = data.data;
                    this.chartInstance.update();
                }
            }
        }
    }

</script>
