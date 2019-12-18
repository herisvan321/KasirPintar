@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(Session::has('sukses'))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{ Session::get('sukses')}}
                    </div>

                    @elseif(Session::has('gagal'))
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      {{ Session::get('gagal')}}
                    </div>
                    @endif
                    <h2>Selamat Datang <u>{{ $nama }}</u></h2>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('/home') }}" method="post">
                            @csrf
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Enter Nama Barang" required="required">
                            <label>Stok Barang</label>
                            <input type="number" name="stok" class="form-control" placeholder="Enter Stok Barang" required="required">
                            <label>Harga Jual Barang</label>
                            <input type="number" name="harga_jual" class="form-control" placeholder="Enter harga jual Barang" required="required">
                            <label>Harga Beli Barang</label>
                            <input type="number" name="harga_beli" class="form-control" placeholder="Enter harga beli Barang" required="required">
                            <br>
                            <input type="submit" name="save" class="btn btn-primary" value="Save">
                            </form>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok Barang</th>
                            @if($status == 'owner')
                            <th>Harga Jual</th>
                            <th>Harga Bali</th>
                            @elseif($status == 'admin')
                            <th>Harga Jual</th>
                            @endif
                            <th></th>
                        </tr>
                        @foreach($data as $dat)
                        <tr>
                            <td>{{ $dat->kode_barang }}</td>
                            <td>{{ $dat->nama_barang }}</td>
                            <td>{{ $dat->stok }}</td>
                            @if($status == 'owner')
                            <td>{{ number_format($dat->harga_jual,0,',','.') }}</td>
                            <td>{{ number_format($dat->harga_beli,0,',','.') }}</td>
                            @elseif($status == 'admin')
                            <td>{{ number_format($dat->harga_jual,0,',','.') }}</td>
                            @endif
                            <td>
                                <a href="#" class="btn btn-info" data-remote="false" data-toggle="modal" data-target="#myEdit{{ $dat->kode_barang }}">Edit</a>
                                <a href="#" class="btn btn-danger" data-remote="false" data-toggle="modal" data-target="#myHapus{{ $dat->kode_barang }}">Remove</a>

                                 <div class="modal" id="myEdit{{ $dat->kode_barang }}">
                          <div class="modal-dialog">
                            <form action="{{ url('/home') }}" method="post">
                                @csrf @method('put')
                            <div class="modal-content">

                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Edit {{ $dat->kode_barang }}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <!-- Modal body -->
                              <div class="modal-body">
                               <input type="hidden" name="kode_barang" value="{{ $dat->kode_barang }}">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Enter Nama Barang" required="required" value="{{ $dat->nama_barang }}">
                                <label>Stok Barang</label>
                                <input type="number" name="stok" class="form-control" placeholder="Enter Stok Barang" required="required" value="{{ $dat->stok }}">
                                <label>Harga Jual Barang</label>
                                <input type="number" name="harga_jual" class="form-control" placeholder="Enter harga jual Barang" required="required" value="{{ $dat->harga_jual }}">
                                <label>Harga Beli Barang</label>
                                <input type="number" name="harga_beli" class="form-control" placeholder="Enter harga beli Barang" required="required" value="{{ $dat->harga_beli }}">
                              </div>

                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="submit" name="update" value="Update" class="btn btn-info">
                              </div>

                            </div>
                        </form>
                          </div>
                        </div>


                        <div class="modal" id="myHapus{{ $dat->kode_barang }}">
                          <div class="modal-dialog">
                            <form action="{{ url('/home') }}" method="post">
                            <div class="modal-content">

                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title">Hapus {{ $dat->kode_barang }}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>

                              <!-- Modal body -->
                              <div class="modal-body">
                                 @csrf @method('delete')
                                <h2>Apakah Anda ingin menghapus data ini???</h2>
                                <input type="hidden" name="kode_barang" value="{{ $dat->kode_barang }}">
                              </div>

                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                              </div>

                            </div>
                          </form>
                          </div>
                        </div>
                            </td>
                        </tr>
                        
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
