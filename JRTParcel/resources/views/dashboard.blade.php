<x-app-layout>
    <div class="px-16 pt-5 ">
        <div class="grid grid-cols-3 gap-6 ">
            <div class="w-full mb-6 md:mb-0 ">
                <div class="grid grid-cols-2 color-1 center items-center justify-center w-full text-center text-xl font-bold rounded-3xl bg-sky-500 h-24 ">                   
                
                <h1 class="text-white text-2xl font-bold">Hello, {{ Auth::user()->name }}</h1>
                <p></p>
                </div>
            </div>
            <div class="w-full mb-6 md:mb-0">
                <div class="grid grid-cols-2 center color-2 items-center justify-center w-full text-center text-xl font-bold borderborder-red-500 rounded-3xl bg-pink-500 h-24">
                    <h1 class="text-white text-2xl font-bold">Total Paket</h1>
                    <p class="text-white text-2xl font-bold">{{$resis}}</p>
                </div>
            </div>
            <div class="w-full mb-6 md:mb-0">
                <div class="grid grid-cols-2 color-3 center items-center justify-center w-full text-center text-xl font-bold borderborder-red-500 rounded-3xl bg-green-500 h-24">
                    <h1 class="text-white text-2xl font-bold">Total Karyawan</h1>
                    <p class="text-white text-2xl font-bold">{{$karyawanCount}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 px-7">
        <div class="grid grid-cols-3 sm:px-6 lg:px-8" style="min-height: 60vh; max-height: 70vh"> <!-- coba bikin responsive -->
            <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg center px-5">
                <div class="border-double">
                    <div class="center justify-center text-center ">
                        <h1 class="text-500 text-xl font-bold pt-5 pb-5 ">Histori Paket</h1>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No. Resi</th>
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
                                <td>{{ $r->barangs->sum('berat') }} Kg</td>
                                <td>{{ number_format($r->harga, 2, ',', '.') }}</td>
                                <td>{{$r->status}}</td>
                            </tr>
                            @endif
                            @endif
                            @if(Auth::user()->role == 'admin')
                            <tr>
                                <td>{{ $r->kodeResi }}</td>
                                <td>{{ $r->barangs->sum('berat') }} Kg</td>
                                <td>{{ number_format($r->harga, 2, ',', '.') }}</td>
                                <td>{{$r->status}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- <div class="relative text-center text-500 text-xl font-bold pb-4">
                        @if(Auth::user()->role == 'karyawan' && $resi->count() > 0)
                        Total Harga: {{ 'Rp ' . number_format($resi->where('karyawan_id', Auth::user()->karyawan->id)->sum('harga'), 2, ',', '.') }}
                        @endif
                        @if(Auth::user()->role == 'admin')
                        Total Harga: {{ 'Rp ' . number_format($resi->sum('harga'), 2, ',', '.') }}
                        @endif
                    </div> -->
                    <div class="flex justify-center ">
                        {{ $resi->links() }}
                    </div>
                    <div class="pb-5"></div>
                </div>
            </div>
            <div class="grid grid-rows-2 sm:rounded-lg ml-5 min-h-full" >
                <div class="flex-row justify-center px-5 w-full mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg mr-3">
                    <h1 class="text-500 text-xl font-bold pt-5 pb-5 text-center">Status Paket</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>St. No</th>
                                <th>Status</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $statusCounts = [
                                'Menunggu Pengiriman' => 0,
                                'Sedang Dikirim' => 0,
                                'Sudah Sampai' => 0
                            ];
                            
                            foreach ($all_resi as $rs) {
                                if (isset($statusCounts[$rs->status])) {
                                    $statusCounts[$rs->status]++;
                                }
                            }
                        @endphp
                        <tr>
                            <td>1</td>
                            <td>Menunggu Pengiriman</td>
                            <td class="text-center">{{ $statusCounts['Menunggu Pengiriman'] }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Sedang Dikirim</td>
                            <td class="text-center">{{ $statusCounts['Sedang Dikirim'] }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Sudah Sampai</td>
                            <td class="text-center">{{ $statusCounts['Sudah Sampai'] }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="flex w-full mt-5 h-40 mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg mr-3 ">
                    <div class="flex-row justify-center px-5 w-full mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg ">    
                        <h1 class="text-500 text-xl font-bold pt-2 pb-2 text-center">Catatan Karyawan</h1>
                        <form method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea id="daily_report" name="daily_report" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex-column sm:rounded-lg ml-5">
                <div class="flex-row w-full min-h-full mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg mr-10">
                    <h1 class="pt-5 text-500 text-xl pl-10 font-bold ">Aktivitas Harian</h1>
                    <canvas class="w-full pt-3 ml-32" id="hargaChart"></canvas>
                </div>
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

        var resiGroupedByStatus = @json($all_resi -> groupBy('status'));
        var labels = Object.keys(resiGroupedByStatus);
        var data = labels.map(function(key) {
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
                        align: 'start',
                        labels: {
                            boxWidth: 20,
                            paddingTop: 15,
                            usePointStyle: true
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    };
</script>