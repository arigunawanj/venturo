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
        return view('index');
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

            
            foreach($hmenu as $rinc){
                for ($i=1; $i <= 12; $i++) { 
                    $isian[$i] = 0;
                }
            }

            foreach ($htransaksi as $det) {
                $har = date('n', strtotime($det->tanggal));
                $isian[$har] = $det->total;
            }


            return view('index', compact('tahun', 'hmenu', 'htransaksi', 'result', 'nilai', 'jumlah', 'jumlahmenu', 'isian'));
        } else {
            return redirect('/');
        }
    }

    
}
