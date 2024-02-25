<!DOCTYPE html>
<html lang="en">

  <head>

    <style>
        #map {
            width: '100%';
            height: 400px;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>KOS 27</title>

    <!-- Bootstrap core CSS -->
    <link href="../ref_layouts/landingpage/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/owl.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
    <link href="{{ asset('template/admin/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    @stack('before-js')

<!--

TemplateMo 591 villa agency

https://templatemo.com/tm-591-villa-agency

-->
  </head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include("pages.landingpage.header")
    @yield('content');
    <div class="modal fade" id="modal-bayar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Informasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">No Kamar</label>
                        <div class="col-sm-9">
                            <input readonly id="form-kamar" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Tipe</label>
                        <div class="col-sm-9">
                            <input readonly id="form-iftipe" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Fasilitas</label>
                        <div class="col-sm-9">
                            <input readonly id="form-iffasilitas" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Tgl Kos</label>
                        <div class="col-sm-9">
                            <input readonly id="form-iftgl" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Periode Kos</label>
                        <div class="col-sm-9">
                            <input readonly id="form-ifdurasi" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Harga Kamar</label>
                        <div class="col-sm-9">
                            <input readonly id="form-ifhraga" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Total Biaya</label>
                        <div class="col-sm-9">
                            <input readonly id="form-ifbiaya" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Bank</label>
                        <div class="col-sm-9">
                            <select id="form-bank" style="width: 100%;">
                                <option value="">Pilih Bank</option>
                                <option value="bca">BCA (<b>063 123 7460</b> MAHFUDZ)</option>
                                <option value="mandiri">MANDIRI (<b>13200 2442 7867</b> MAHFUDZ)</option>
                                {{-- <option value="1">BNI</option>
                                <option value="1">BRI</option>
                                <option value="1">Mandiri</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row divva" style="display:none;">
                        <label class="col-sm-3 col-form-label">No VA</label>
                        <div class="col-sm-9">
                            <input id="form-va" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Bukti Transaksi (*)</label>
                        <div class="col-sm-9">
                            <form role="form" class="" id="formbayar" method="post" type="post" enctype="multipart/form-data">
                                <input id="form-bayar" name="formbayar" accept="image/*" type="file" class="form-control" >
                            </form>
                        </div>
                    </div>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="batalbooking()">Batalkan Booking</button>
                <button type="button" class="btn btn-primary" onclick="savebukti()">Simpan</button>
            </div>
            </div>
        </div>
    </div>
    @include('pages.landingpage.contact')
    <div class="col-lg-12">
        <div id="map">
          
        </div>
      </div>
    <footer>
        <div class="container">
            <div class="col-lg-12">
            {{-- <p>
                Jl. Sekeloa Tengah no.27, Coblong, Kota Bandung, Jawa Barat.
            </p> --}}
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="../ref_layouts/landingpage/vendor/jquery/jquery.min.js"></script>
    <script src="../ref_layouts/landingpage/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('template/admin/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="../ref_layouts/landingpage/assets/js/isotope.min.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/owl-carousel.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/counter.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/custom.js"></script>
    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
    <script src="{{ asset('template/admin/vendor/sweetalert2/dist/sweetalert2.min.js') }}" aria-hidden="true"></script>

    <script>
        
        $("#form-bank").change( function (e) {
            $("#form-va").val('');
            if($("#form-bank").val() != ''){
                $(".divva").hide();
                // $(".divva").show();
                const day = new Date();
                let y = day.getFullYear();
                let m = day.getMonth();
                let d = day.getDate();
                let h = day.getHours();
                let mt= day.getMinutes();
                let s = day.getSeconds();
                va = '0001'+y+''+m+''+d+''+h+''+mt+''+s;
                $("#form-va").val(va);
            }else{
                $(".divva").hide();
            }
        })
        showmpas()
        function showmpas(){
            var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
              '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
              'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
              mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
            grayscale   = L.tileLayer(mbUrl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}),
            streets     = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});
            Google      = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}',  {tileSize: 512, zoomOffset: -1,attribution: 'google'});

            googleSat   = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleTraffic = L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                minZoom: 2,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            });

            var myIcon = L.icon({
                iconUrl: 'https://img.freepik.com/premium-vector/red-map-pin…l-flat-vector-illustration_136875-3892.jpg?w=2000',
                iconSize: [70, 70],
            });

            latlng = [-6.889600, 107.619940];
            map = L.map('map',{
                layers: [googleSat],
                zoomControl:true, maxZoom:20, minZoom:3, zoomControl: true
            }).setView(latlng, 18);

            L.marker(latlng,{icon : myIcon}).addTo(map)
        } 
        var va = '';
        showpembayaran('');
        function showpembayaran(p) {
            
            
            $.ajax({
                url: window.location.origin + "/getva",
                type: "POST",
                dataType: "json",
                contentType: "application/json",
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function () {
                    // Swal.fire({
                    //     title: "Loading",
                    //     text: "Please wait...",
                    //     showConfirmButton: false, // Menyembunyikan tombol OK
                    // });
                },
                complete: function (response) {
                    
                },
                success: function (response) {
                    
                    if (response.data.length >=1) {
                        if(response.data[0].role_name == 'guest' && response.data[0].id){
                            $("#form-kamar").val(response.data[0].no_kamar);
                            $("#form-iftipe").val(response.data[0].tipe_kamar);
                            $("#form-iffasilitas").val(response.data[0].faskos);
                            $("#form-iftgl").val(response.data[0].tgl_awal);
                            $("#form-ifdurasi").val(response.data[0].jmlbulan);
                            $("#form-ifhraga").val(response.data[0].harga);
                            $("#form-ifbiaya").val(response.data[0].harga * response.data[0].jmlbulan);

                            swal("Perhatian !!", 'Lakukan Pembayaran dalam 1x24 jam atau otomatis tercancel ,anda sudah booking kamar sebelumnya , silahkan lakukan pembayaran atau batalkan pembayaran terlebih dahulu', "warning")
                            .then(function (e){
                                if(p){
                                    if(p == 'booking'){
                                        $("#modal-bayar").modal('show');
                                    }else{
                                        $("#modal-booking").modal('show');
                                    }
                                }else{
                                    $("#modal-bayar").modal('show');
                                }
                            });
                        }else{
                            if(p){
                                $("#modal-booking").modal('show');
                            }
                        }
                    }
                    
                }
            })
        }
        function batalbooking(){
            swal({
                title: "Apakah Yakin Untuk Membatalkan Booking ?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yakin",
                cancelButtonText: "Kembali",
                closeOnConfirm: !1,
                closeOnCancel: !1,
            }).then(function (e) {
                if (e.value) {
                    $.ajax({
                        url: baseURL + "/batalbooking",
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        complete: function () {
                        },
                        success: function (response) {
                            // Handle response sukses
                            if (response.code == 0) {
                                swal("Berhasil !", 'Booking telah dibatalkan', "success")
                                .then(function (e){
                                    location.reload() ;
                                });
                            } else {
                                sweetAlert("Oops...", response.message, "ERROR");
                            }
                        },
                        error: function (xhr, status, error) {
                            sweetAlert("Oops...", "ERROR", "ERROR");
                        },
                    });
                } else {
                    swal(
                        "Batal",
                        "Data tidak berubah",
                        "ERROR"
                    );
                }
            });
        }
        function savebukti() {
            
            if($("#form-va").val() == ''){
                swal('Opss','Silahkan Pilih Bank','warning');
                return false ;
            }
            if($("#form-bayar").val() == ''){
                swal('Opss','Bukti tidak boleh kosong','warning');
                return false ;
            }
            const formData    = new FormData(document.getElementById("formbayar"));
            formData.append('va',va);
            formData.append('bank',$("#form-bank").val());

            $.ajax({
                url: baseURL + "/SaveVa",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function () {
                    Swal.fire({
                        title: "Loading",
                        text: "Please wait...",
                    });
                },
                complete: function () {
                },
                success: function (response) {
                    // Handle response sukses
                    if (response.code == 0) {
                        swal("Berhasil !", 'Pembayaran Berhasil, Silahkan login ulang untuk melihat fitur-fitur penghuni', "success").then(function () {
                                
                            $.ajax({
                                url: baseURL + "/logout",
                                type: "POST",
                                headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                },
                                complete:function(){
                                    window.location.href = window.location.origin;
                                }
                            });
                        });
                        $("#modal-bayar").modal("hide");

                    } else {
                        swal("Oops...", 'Gagal simpan', "error");
                    }
                },
                error: function (xhr, status, error) {
                    swal("Oops...", "ERROR", "ERROR");
                },
            });
        }
    </script>
    @stack('after-script')

</body>
</html>