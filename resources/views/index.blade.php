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
                                    <tr>
                                        <td class="table-warning" id="kategori" colspan="14"><b>Makanan</b></td>
                                    </tr>

                                    {{-- ISI DATA HARGA MAKANAN SETIAP BULAN --}}
                                    @php
                                        $id = 0;
                                    @endphp
                                    @foreach ($hmenu as $item)
                                        @if ($item->kategori == 'makanan')
                                            <tr>
                                                <td>{{ $item->menu }}</td>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @php
                                                        $id++;
                                                    @endphp
                                                    @if ($result[$item->menu][$i] == 0)
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#makanan{{ $id }}">-</td>
                                                    @else
                                                        <td data-bs-toggle="modal"
                                                            data-bs-target="#makanan{{ $id }}">
                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</td>
                                                    @endif
                                                    {{-- MODAL DETAIL --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="makanan{{ $id }}" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Detail Harga Makanan</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Menu : {{ $item->menu }} <br>
                                                                    Harga Total : Rp
                                                                    {{ number_format($result[$item->menu][$i], 0, ',', '.') }}

                                                                    <hr>

                                                                    Rincian Pesanan Bulan : <br>
                                                                    @foreach ($htransaksi as $rincian)
                                                                    @php
                                                                        $z = date('n', strtotime($rincian->tanggal))
                                                                    @endphp
                                                                    
                                                                        @if ($z == $i && $item->menu == $rincian->menu)
                                                                            {{ $rincian->tanggal }} : {{ $rincian->total }}<br>
                                                                        
                                                                        @endif
                                                                    @endforeach
                                                                    <br>
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
                                                @endfor
                                                <td class="fw-bold">
                                                    {{ number_format($jumlahmenu[$item->menu], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr>
                                        <td class="table-warning" id="kategori" colspan="14"><b>Minuman</b></td>
                                    </tr>

                                    {{-- ISI DATA HARGA MINUMAN SETIAP BULAN --}}
                                    @foreach ($hmenu as $item)
                                        @if ($item->kategori == 'minuman')
                                            <tr>
                                                <td>{{ $item->menu }}</td>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @if ($result[$item->menu][$i] == 0)
                                                        <td data-bs-toggle="modal" data-bs-target="#minuman">-</td>
                                                    @else
                                                        <td data-bs-toggle="modal" data-bs-target="#minuman">
                                                            {{ number_format($result[$item->menu][$i], 0, ',', '.') }}</td>
                                                    @endif
                                                @endfor
                                                <td class="fw-bold">
                                                    {{ number_format($jumlahmenu[$item->menu], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <td class="fw-bold">Total</td>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <td class="fw-bold">{{ number_format($jumlah[$i], 0, ',', '.') }}</td>
                                        @endfor
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
