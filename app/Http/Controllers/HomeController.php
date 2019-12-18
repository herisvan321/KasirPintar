<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,staff,owner');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $r)
    {
        $nama = '';
        $in = false;
        $up = false;
        $del = false;
        $status = '';
        if(auth()->guard('admin')->user()){
            $nama = auth()->guard('admin')->user()->name;
            $status = 'admin';
        }elseif(auth()->guard('staff')->user()){
            $nama = auth()->guard('staff')->user()->name;
            $status =  'staff';
        }elseif(auth()->guard('owner')->user()){
            $nama = auth()->guard('owner')->user()->name;
            $status =  'owner';
        }
        if(@$r->save){
            if(@count($r->save) == 1){
                $cek = Barang::orderBy('kode_barang', 'desc')->first();
                if(@count($cek) > 0)
                {
                    $pengambilan = explode('-', $cek->kode_barang);
                    $tambah = (int) $pengambilan[1] + 1;
                    $anggka = sprintf("%06s",$tambah);
                    $kode_barang = "BRG"."-".$anggka;
                }
                else{
                    $kode_barang = "BRG"."-"."000001";
                }
                $in = new Barang();
                $in->kode_barang = $kode_barang;
                $in->nama_barang = $r->nama_barang;
                $in->stok = $r->stok;
                $in->harga_jual = $r->harga_jual;
                $in->harga_beli = $r->harga_beli;
                $in->save();
            }
        }elseif(@$r->update){
            if(@count($r->update) == 1){
                $up = Barang::find($r->kode_barang);
                $up->nama_barang = $r->nama_barang;
                $up->stok = $r->stok;
                $up->harga_jual = $r->harga_jual;
                $up->harga_beli = $r->harga_beli;
                $up->update();
            }
        }elseif(@$r->delete){
            if(@count($r->delete) == 1){
                $del = Barang::find($r->kode_barang);
                $del->delete();
            }
        }
        if(@$r->save || $r->update || $r->delete){
            if($in || $up || $del){
                Session::flash('sukses', 'proses berhasil dilakukan');
            }else{
                Session::flash('gagal', 'proses gagal dilakukan');
            }
            return back();
        }
        $data = Barang::orderByDesc('kode_barang')->get();
         return view('home', compact(
            'nama',
            'data',
            'status'
         ));
    }
}
