@extends('movr.layouts.app')

@section('content')
<section class="py-6 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-black">Laporan Pendapatan</h1>
                <p class="text-gray-600">Analisis statistik keuangan toko Anda</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase">Total Akumulasi</p>
                <p class="text-2xl font-bold text-accent-green">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-300 rounded-lg p-6 mb-8">
            <h2 class="text-lg font-bold text-black mb-4">Grafik Pertumbuhan Pendapatan</h2>
            <div style="height: 300px;">
                @if($revenueData->count() > 0)
                    <canvas id="revenueChart"></canvas>
                @else
                    <div class="flex items-center justify-center h-full bg-gray-50 rounded">
                        <p class="text-gray-500">Belum ada data pendapatan untuk ditampilkan</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-black">Catatan Transaksi Selesai</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 font-bold text-sm text-gray-700">ID Pesanan</th>
                            <th class="px-6 py-4 font-bold text-sm text-gray-700">Pelanggan</th>
                            <th class="px-6 py-4 font-bold text-sm text-gray-700">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-sm text-gray-700">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($incomeRecords as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">#{{ $record->midtrans_order_id ?? $record->id }}</td>
                            <td class="px-6 py-4 text-sm">{{ $record->user->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $record->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-accent-green">Rp {{ number_format($record->total_amount ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada transaksi selesai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($incomeRecords->count() > 0)
            <div class="p-4 border-t border-gray-200">
                {{ $incomeRecords->links() }}
            </div>
            @endif
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($revenueData->count() > 0)
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->pluck('month')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($revenueData->pluck('total')) !!},
                borderColor: '#10B981', // warna accent-green
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
    @endif
</script>
@endsection