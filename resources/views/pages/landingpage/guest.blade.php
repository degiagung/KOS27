@extends('pages.landingpage.layouts')
@section('content')

<div class="main-banner">
    <div class="owl-carousel owl-banner">
        <div class="item item-1">
        <div class="header-text">
            <span class="category">Coblong, <em>Kota Bandung, Jawa Barat.</em></span>
            <h2>Terbaik!<br>Booking Sebelum Keduluan Yang Lain</h2>
        </div>
        </div>
        <div class="item item-2">
        <div class="header-text">
            <span class="category">Coblong, <em>Kota Bandung, Jawa Barat.</em></span>
            <h2>Ternyaman!<br>Booking Sebelum Keduluan Yang Lain</h2>
        </div>
        </div>
        <div class="item item-3">
        <div class="header-text">
            <span class="category">Coblong, <em>Kota Bandung, Jawa Barat.</em></span>
            <h2>Teraman!<br>Booking Sebelum Keduluan Yang Lain</h2>
        </div>
        </div>
    </div>
    </div>

    <div class="featured section">
        <div class="container">
            <div class="row">
            <div class="col-lg-4">
                <div class="left-image">
                <img src="../ref_layouts/landingpage/assets/images/featured.jpg" alt="">
                {{-- <a href="property-details.html"><img src="../ref_layouts/landingpage/assets/images/featured-icon.png" alt="" style="max-width: 60px; padding: 0px;"></a> --}}
                </div>
            </div>
            <div class="col-lg-5">
                <div class="section-heading">
                <h6>| Featured</h6>
                <h2>Terbaik, Ternyaman &amp; Teraman</h2>
                </div>
                <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Visi Misi Perusahaan
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Visi Misi Perusahaan</strong> Perusahaan Kos Putri 27 Memiliki Visi dan Misi yang dapat meningkatkan
                        motivasi karyawan dalam bekerja serta mewujudkan tujuan dari perusahaan.  
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Visi
                    </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Visi </strong>Menjadikan pilihan utama dan terdepan dalam menyediakan tempat tinggal yang aman dan nyaman
                        bagi mahasiswi yang sedang menempuh pendidikan di Bandung
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Misi
                    </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Misi </strong> 
                        <ul>
                            <li>
                                1. Menyediakan lingkungan yang aman dan terawat agar para mahasiswi dapat fokus
                                pada pendidikan mereka tanpa khawatir akan keamanan tempat tinggal.
                            </li>
                            <li>
                                2. Menyediakan fasilitas dan layanan yang memenuhi standar kualitas tinggi. 
                            </li>
                            <li>
                                3. Menciptakan suasana yang welcoming dan mendukung bagi semua penghuni.
                            </li>
                            <li>
                                4. Menciptakan suasana harmonis diantara penghuni
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="info-table">
                <ul>
                    <li>
                    <img src="../ref_layouts/landingpage/assets/images/info-icon-01.png" alt="" style="max-width: 52px;">
                    <h4>30 Kamar<br><span>Total Kamar Keseluruhan</span></h4>
                    </li>
                    <li>
                    <img src="../ref_layouts/landingpage/assets/images/info-icon-02.png" alt="" style="max-width: 52px;">
                    <h4>Kontrak<br><span>Kontrak Siap diperpanjang</span></h4>
                    </li>
                    <li>
                    <img src="../ref_layouts/landingpage/assets/images/info-icon-03.png" alt="" style="max-width: 52px;">
                    <h4>Pembayaran Mudah<br><span>Pembayaran bisa melalui cash atau transfer</span></h4>
                    </li>
                    <li>
                    <img src="../ref_layouts/landingpage/assets/images/info-icon-04.png" alt="" style="max-width: 52px;">
                    <h4>Keamanan<br><span>24 Jam dilengkapi CCTV</span></h4>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </div>
    </div>

    {{-- <div class="video section">
        <div class="container">
            <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="section-heading text-center">
                <h6>| Video View</h6>
                <h2>Get Closer View & Different Feeling</h2>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="video-content">
        <div class="container">
            <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="video-frame">
                <img src="../ref_layouts/landingpage/assets/images/video-frame.jpg" alt="">
                <a href="https://youtube.com" target="_blank"><i class="fa fa-play"></i></a>
                </div>
            </div>
            </div>
        </div>
    </div> --}}

    <div class="fun-facts">
        <div class="container">
            <div class="row">
            <div class="col-lg-12">
                <div class="wrapper">
                <div class="row">
                    <div class="col-lg-4">
                    <div class="counter">
                        <h2 class="timer count-title count-number" data-to="2" data-speed="1000"></h2>
                        <p class="count-text ">Bangunan<br>Baru</p>
                    </div>
                    </div>
                    <div class="col-lg-4">
                    <div class="counter">
                        <h2 class="timer count-title count-number" data-to="12" data-speed="1000"></h2>
                        <p class="count-text ">Tahun<br>Berdiri</p>
                    </div>
                    </div>
                    <div class="col-lg-4">
                    <div class="counter">
                        <h2 class="timer count-title count-number" data-to="30 " data-speed="1000"></h2>
                        <p class="count-text ">Penghuni<br>Kos</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection