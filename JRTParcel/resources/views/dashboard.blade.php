<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-gray-900">
                <div class="grid grid-cols-2 -mx-3">
                    <div class="w-full pr-5 mb-6 md:mb-0 ">
                        <div class="grid grid-cols-2 bg-custom-image center items-center justify-center w-full text-center text-xl font-bold border border-cyan-500 rounded-3xl bg-cyan-500 h-32 ">
                            <h1 class="text-white text-2xl pb-4 font-bold">Total Karyawan</h1>
                            <p class="text-white text-2xl pb-4 font-bold">{{$karyawanCount}}</p>
                        </div>
                    </div>
                    <div class="w-full pl-5 mb-6 md:mb-0">
                        <div class="grid grid-cols-2 bg-custom-image-2 center items-center justify-center w-full text-center text-xl font-bold borderborder-red-500 rounded-3xl bg-red-500 h-32">
                        <h1 class="text-black text-2xl pb-4 font-bold">Total Resi</h1>
                        <p class="text-black text-2xl pb-4 font-bold">{{$resis}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="grid grid-cols-2 gap-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center items-center w-full bg-white overflow-hidden shadow-sm sm:rounded-lg center">
                
                    
                        <div class="w-full py-4 px-7 mb-6 md:mb-0">
                            <div class="center justify-center w-full text-center">
                                <h1 class="text-red-500 text-2xl pb-4 font-bold">Resi Terbaru</h1>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Kode Resi</th>
                                        <th>Berat Barang</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resi as $r)
                                        @if(Auth::user()->role == 'karyawan')
                                            @if($r->karyawan->id == Auth::user()->karyawan->id)
                                                <tr>
                                                    <td>{{ $r->kodeResi }}</td>
                                                    <td>{{ $r->barangs->sum('berat') }}</td>
                                                    <td>{{ number_format($r->harga, 2, ',', '.') }}</td>
                                                    <td>{{$r->status}}</td>
                                                </tr>
                                            @endif
                                        @endif
                                        @if(Auth::user()->role == 'admin')
                                            <tr>
                                                <td>{{ $r->kodeResi }}</td>
                                                <td>{{ $r->barangs->sum('berat') }}</td>
                                                <td>{{ number_format($r->harga, 2, ',', '.') }}</td>
                                                <td>{{$r->status}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center text-blue-500 text-2xl font-bold pb-4">
                                @if(Auth::user()->role == 'karyawan' && $resi->count() > 0)
                                    Total Harga: {{ 'Rp ' . number_format($resi->where('karyawan_id', Auth::user()->karyawan->id)->sum('harga'), 2, ',', '.') }}
                                @endif
                                @if(Auth::user()->role == 'admin')
                                    Total Harga: {{ 'Rp ' . number_format($resi->sum('harga'), 2, ',', '.'}}
                                @endif
                            </div>
                            {{ $resi->links() }}
                        </div>
                    
            </div>
            <div class="flex justify-center items-center w-full mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <canvas class="p-5" id="hargaChart"></canvas>               
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Include the Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include the Chart.js Data Labels plugin -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Add the script to create the chart -->
<script>
window.onload = function() {
    console.log(Chart);

    var resiGroupedByStatus = @json($all_resi->groupBy('status'));
    var labels = Object.keys(resiGroupedByStatus);
    var data = labels.map(function (key) {
        return resiGroupedByStatus[key].length;
    });

    console.log(labels.length);
    console.log(data);

    var ctx = document.getElementById('hargaChart').getContext('2d');
    var hargaChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Status',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(0, 206, 86, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(0, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    formatter: (value, context) => {
                        let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#000',
                    anchor: 'center',
                    align: 'center'
                },
                legend: {
                    position: 'right',
                    align:'start',
                    labels: {
                        boxWidth: 20,
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
};
</script>
