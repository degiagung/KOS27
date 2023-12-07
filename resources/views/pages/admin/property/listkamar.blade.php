@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header mt-2 flex-wrap d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">List Kamar</h4>
                        </div>
                        <ul class="nav nav-tabs dzm-tabs" id="myTab-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" id="add-btn" class="nav-link active btn-sgn">Add</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-list" class="datatables">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Kamar</th>
                                        <th>lantai</th>
                                        <th>Fasilitas</th>
                                        <th>Status</th>
                                        <th>Penghuni</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-data" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header headermodal">
                        <h5 class="modal-title">Data View</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <form method="post" id="formkamar" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="basic-form">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">no kamar</label>
                                <div class="col-sm-9">
                                    <input id="form-no" name="form-no" type="text" class="form-control" placeholder="No Kamar">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Lantai</label>
                                <div class="col-sm-9">
                                    <input id="form-lantai" name="form-lantai" type="number" class="form-control" placeholder="Lantai">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Tipe Kamar</label>
                                <div class="col-sm-9">
                                    <select id="form-tipe" name="form-tipe" class="select2">
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Harga Sewa</label>
                                <div class="col-sm-9">
                                    <input id="form-harga" name="form-harga" type="number" class="form-control" placeholder="Harga">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Fasilitas Dari Kos</label>
                                <div class="col-sm-9">
                                    <select class="select2" name="states[]" multiple="multiple" id="form-fasilitas" name="form-fasilitas"> 

                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Fasilitas Dari Penghuni</label>
                                <div class="col-sm-9">
                                    <select class="select2" name="states[]" multiple="multiple" id="form-fasilitas-penghuni" name="form-fasilitas">

                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Foto Sampul</label>
                                <div class="col-sm-9">
                                    <input id="form-sampul" name="form-sampul" accept="image/*" type="file" class="form-control" name="foto-sampul">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Foto Lainnya</label>
                                <div class="col-sm-9">
                                    {{-- <input id="form-lainnya" name="form-lainnya" type="penghuni" class="form-control" > --}}
                                    <input type="file" id="form-lainnya" accept="image/*" class="form-control" name="form-lainnya[]" multiple />

                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Penghuni</label>
                                <div class="col-sm-9">
                                    <select id="form-penghuni" name="form-penghuni" class="select2">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after-script')
    <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>        
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endpush