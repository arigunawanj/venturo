<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = '';
        return view('index', compact('tahun'));
    }

    public function store(Request $request)
    {
        $tahun = $request->tahun;
        $menu = Http::get('http://tes-web.landa.id/intermediate/menu');
        $transaksi = Http::get('http://tes-web.landa.id/intermediate/transaksi?tahun=' . $tahun);
        $hmenu = json_decode($menu);
        $htransaksi = json_decode($transaksi);
        $nilai = 0;

        if ($request->tahun) {
            // TOTAL KESELURUHAN
            foreach ($htransaksi as $hasil) {
                $nilai += $hasil->total;
            }

            // MENGAMBIL MENU TOTAL TIAP BULAN
            foreach ($hmenu as $item) {
                for ($i = 1; $i <= 12; $i++) {
                    setlocale(LC_ALL, 'id-ID', 'id_ID');
                    $bulann = strftime('%B', mktime(0, 0, 0, $i, 1));
                    $title[$item->menu][$i] = "Detail Penjualan $item->menu bulan $bulann";
                    $result[$item->menu][$i] = 0;
                }
            }

            // MENGHITUNG TOTAL MENU SETIAP BULAN
            foreach ($htransaksi as $data) {
                $bulan = date('n', strtotime($data->tanggal));
                $result[$data->menu][$bulan] += $data->total;
            }

            // MENGAMBIL JUMLAH TOTAL PERBULAN
            foreach ($htransaksi as $jml) {
                for ($i = 1; $i <= 12; $i++) {
                    $jumlah[$i] = 0;
                }
            }

            // MENGHITUNG JUMLAH TOTAL PERBULAN
            foreach ($htransaksi as $perbulan) {
                $dino = date('n', strtotime($perbulan->tanggal));
                $jumlah[$dino] += $perbulan->total;
            }

            
            // MENGAMBIL TOTAL TIAP MENU
            foreach ($hmenu as $permenu) {
                $jumlahmenu[$permenu->menu] = 0;
            }

            // MENGHITUNG TOTAL TIAP MENU
            foreach ($htransaksi as $jmltrans) {
                $jumlahmenu[$jmltrans->menu] += $jmltrans->total;
            }

            $data = [
                'a' => $hmenu,
                'b' => $htransaksi,
                'c' => $jumlahmenu,
                'd' => $jumlah,
                'e' => $result,
            ];

            return view('index', compact('tahun', 'hmenu', 'htransaksi', 'result', 'nilai', 'jumlah', 'jumlahmenu','data','title'));
        } else {
            return redirect('/');
        }
    }

    
}
