<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAPORAN PENJUALAN PERTAHUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    {{-- Kartu --}}
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">Ari Gunawan Jatmiko - Laporan Penjualan Tahunan Per Menu</div>
            <div class="card-body">
                <form action="{{ url('data') }}" method="post">
                    @csrf
                    <div class="d-flex">
                        <select class="form-select" name="tahun" style="width: 20%">
                            <option selected disabled>Pilih Tahun</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                        <button type="submit" class="btn btn-primary ms-3">Tampilkan</button>
                    </div>
                </form>
                <div class="container">
                    <hr>
                    @isset($tahun)
                        <div class="table-responsive">
                            <table class="table" id="penjualan">
                                <thead>
                                    <tr class="table-dark">
                                        <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">
                                            Menu</th>
                                        <th colspan="12" style="text-align: center;">Periode Pada {{ $tahun }}</th>
                                        <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total
                                        </th>
                                    </tr>
                                    <tr class="table-dark">
                                        <th style="text-align: center;width: 75px;">Jan</th>
                                        <th style="text-align: center;width: 75px;">Feb</th>
                                        <th style="text-align: center;width: 75px;">Mar</th>
                                        <th style="text-align: center;width: 75px;">Apr</th>
                                        <th style="text-align: center;width: 75px;">Mei</th>
                                        <th style="text-align: center;width: 75px;">Jun</th>
                                        <th style="text-align: center;width: 75px;">Jul</th>
                                        <th style="text-align: center;width: 75px;">Ags</th>
                                        <th style="text-align: center;width: 75px;">Sep</th>
                                        <th style="text-align: center;width: 75px;">Okt</th>
                                        <th style="text-align: center;width: 75px;">Nov</th>
                                        <th style="text-align: center;width: 75px;">Des</th>
                                    </tr>
                                </thead>
                                <tbody>

{{-- =========================================================MAKANAN========================================================== --}}
                                    <tr>
                                        <td class="table-warning" id="kategori" colspan="14"><b>Makanan</b></td>
                                    </tr>

                                    {{-- ISI DATA HARGA MAKANAN SETIAP BULAN --}}

                                    {{-- Variabel Penampung kolom tabel atau id tabel --}}
                                    @php
                                        $id = 0;
                                    @endphp

                                    {{-- Menampilkan isi Data Menu --}}
                                    @foreach ($hmenu as $item)

                                    {{-- Jika Kategorinya Makanan --}}
                                        @if ($item->kategori == 'makanan')
                                            <tr>
                                                <td>{{ $item->menu }}</td>
                                                
                                                {{-- PENGULANGAN 1-12 untuk mengambil Value tanggal --}}
                                                @for ($i = 1; $i <= 12; $i++)

                                                {{-- Perulangan kolom tabel untuk memberi ID pada tiap kolom --}}
                                                    @php
                                                        $id++;
                                                    @endphp

                                                {{-- Jika transaksi bulanan tidak ada--}}
                                                    @if ($result[$item->menu][$i] == 0)
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#makanan{{ $id }}">-</td>
                                                    @else
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#makanan{{ $id }}">
                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</td>
                                                    @endif

                                                    {{-- MODAL DETAIL MAKANAN --}}
                                                    <div class="modal fade" id="makanan{{ $id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Detail Total Bulanan {{ $item->menu }}</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3 class="text-center">Rincian Pesanan Bulan</h3>

                                                                    {{-- Mengambil isi data transaksi --}}
                                                                    @foreach ($htransaksi as $rincian)

                                                                    {{-- Translate Tanggal ke angka dari 1-12 --}}
                                                                        @php
                                                                            $z = date('n', strtotime($rincian->tanggal));
                                                                        @endphp

                                                                        {{-- Jika Translate tanggal sesuai dengan looping dan item menu sama dengan transaksi menu --}}
                                                                        @if ($z == $i && $item->menu == $rincian->menu)
                                                                            Tanggal Transaksi : {{ $rincian->tanggal }}<br>
                                                                            Total Transaksi :
                                                                            {{ number_format($rincian->total, 0, ',', '.') }}<br><br>
                                                                        @endif

                                                                    @endforeach
                                                                    <hr>
                                                                    <h6>Harga Total :
                                                                        <span class="badge bg-primary">Rp
                                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor

                                                {{-- Menghitung jumlah seluruh menu --}}
                                                @php
                                                    $n = count([$item->menu]);
                                                @endphp

                                                {{-- Memberi batasan agar tidak terjadi looping --}}
                                                @for ($i = 1; $i <= $n; $i++)
                                                
                                                {{-- digunakan untuk mendeklarasi id kolom --}}
                                                    @php
                                                        $id++;
                                                    @endphp

                                                    <td class="fw-bold" data-bs-toggle="modal"
                                                        data-bs-target="#totalmakanan{{ $id }}">
                                                        {{ number_format($jumlahmenu[$item->menu], 0, ',', '.') }}
                                                    </td>

                                                @endfor
                                            </tr>

                                            <!-- Modal TOTAL-->
                                            <div class="modal fade" id="totalmakanan{{ $id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Total
                                                                Penjualan Menu {{ $item->menu }} Tahunan
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            {{-- Sebagai Variabel Penampung --}}
                                                            @php
                                                                $a = 0;
                                                            @endphp

                                                            <h4 class="text-center">Rincian Transaksi Perbulan</h4>

                                                            {{-- Mengambil seluruh data dari hasil pehitungan Total Menu perbulan --}}
                                                            @foreach ($result[$item->menu] as $totals)
                                                            
                                                            {{-- Memberi ID kolom pada tabel --}}
                                                                @php
                                                                    $a++
                                                                @endphp    

                                                            {{-- Jika kategorinya makanan --}}
                                                            @if ($item->kategori == 'makanan')
                                                                    {{ date('F', mktime(0, 0, 0, $a, 1)) }} : 
                                                                    {{ number_format($totals, 0, ',', '.') }}<br>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

{{-- ======================================================== MINUMAN ============================================================ --}}
                                            {{-- ISI DATA HARGA MINUMAN SETIAP BULAN --}}
                                    <tr>
                                        <td class="table-warning" id="kategori" colspan="14"><b>Minuman</b></td>
                                    </tr>

                                    {{-- Variabel Penampung ID Kolom --}}
                                    @php
                                        $op = 0;
                                    @endphp

                                    {{-- Mengambil data dari menu --}}
                                    @foreach ($hmenu as $item)

                                    {{-- Jika Kategorinya Minuman --}}
                                        @if ($item->kategori == 'minuman')
                                            <tr>
                                                <td>{{ $item->menu }}</td>

                                                {{-- Mengambil Nilai Bulan dari 1-12 --}}
                                                @for ($i = 1; $i <= 12; $i++)

                                                {{-- Memberi ID pada kolom tabel --}}
                                                    @php
                                                        $op++;
                                                    @endphp

                                                    {{-- Jika transaksi menu kosong --}}
                                                    @if ($result[$item->menu][$i] == 0)
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#minuman{{ $op }}">-</td>
                                                    @else
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#minuman{{ $op }}">
                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</td>
                                                    @endif


                                                    {{-- MODAL DETAIL --}}
                                                    <div class="modal fade" id="minuman{{ $op }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Detail Total {{ $item->menu }}</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h3 class="text-center">Rincian Pesanan Bulan</h3>

                                                                    {{-- Menampilkan Seluruh Data Transaksi --}}
                                                                    @foreach ($htransaksi as $deta)

                                                                    {{-- Membuat Variabel sebagai translate tanggal ke angka --}}
                                                                        @php
                                                                            $z = date('n', strtotime($deta->tanggal));
                                                                        @endphp

                                                                        {{-- Jika tanggal yang ditranslate sama dengan looping dan menu json sama dengan menu transaksi json --}}
                                                                        @if ($z == $i && $item->menu == $deta->menu)
                                                                            {{ $deta->tanggal }} : Rp
                                                                            {{ number_format($deta->total, 0, ',', '.') }}<br>
                                                                        @endif

                                                                    @endforeach
                                                                    <hr>
                                                                    <h6>Harga Total :
                                                                        <span class="badge bg-primary">Rp
                                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                                
                                                {{-- Menghitung jumlah seluruh menu --}}
                                                @php
                                                    $n = count([$item->menu]);
                                                @endphp

                                                {{-- Memberi batasan agar tidak terjadi looping --}}
                                                @for ($i = 1; $i <= $n; $i++)
                                                
                                                {{-- digunakan untuk mendeklarasi id kolom --}}
                                                    @php
                                                        $op++;
                                                    @endphp

                                                <td class="fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#totalminuman{{ $op }}">
                                                    {{ number_format($jumlahmenu[$item->menu], 0, ',', '.') }}
                                                </td>
                                                @endfor
                                            </tr>

                                            <!-- Modal TOTAL-->
                                            <div class="modal fade" id="totalminuman{{ $op }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Total
                                                                    Penjualan Menu {{ $item->menu }} Tahunan
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            {{-- Sebagai Variabel Penampung --}}
                                                            @php
                                                                $p = 0;
                                                            @endphp

                                                            <h4 class="text-center">Rincian Transaksi Perbulan</h4>

                                                            {{-- Mengambil seluruh data dari hasil pehitungan Total Menu perbulan --}}
                                                            @foreach ($result[$item->menu] as $hasils)
                                                            
                                                            {{-- Memberi ID kolom pada tabel --}}
                                                                @php
                                                                    $p++
                                                                @endphp    

                                                            {{-- Jika kategorinya minuman --}}
                                                            @if ($item->kategori == 'minuman')
                                                                    {{ date('F', mktime(0, 0, 0, $p, 1)) }} : 
                                                                    {{ number_format($hasils, 0, ',', '.') }}<br>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <td class="fw-bold">Total</td>

                                        {{-- Pengulangan untuk mengambil nilai bulan --}}
                                        @for ($i = 1; $i <= 12; $i++)
                                            <td class="fw-bold">{{ number_format($jumlah[$i], 0, ',', '.') }}</td>
                                        @endfor

                                        {{-- Hasil Total --}}
                                        <td class="fw-bold">{{ number_format($nilai, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                Ari Gunawan Jatmiko &copy; 2022
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="{{ asset('menu.js') }}"></script>
</body>

</html>
