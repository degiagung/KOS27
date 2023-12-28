@extends('pages.landingpage.layouts')
@section('content')

<div class="section properties">
  <div class="container">
    <ul class="properties-filter">
      <li>
        <a class="is_active" href="#!" data-filter="*">Tampilkan Semua</a>
      </li>
      <li>
        <a class="is_active" href="#!" data-filter=""></a>
      </li>
      <li>
        <a href="#!" data-filter=".adv"></a>
      </li>
    </ul>
    <div class="row properties-box">
      <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 adv">
        <div class="item">
          <a href="{{ URL::to('details/34') }}"><img src="../ref_layouts/landingpage/assets/images/property-01.jpg" alt=""></a>
          <span class="category">Luxury Villa</span>
          <h6>$2.264.000</h6>
          <h4><a href="{{ URL::to('details/34') }}">18 Old Street Miami, OR 97219</a></h4>
          <ul>
            <li>Bedrooms: <span>8</span></li>
            <li>Bathrooms: <span>8</span></li>
            <li>Area: <span>545m2</span></li>
            <li>Floor: <span>3</span></li>
            <li>Parking: <span>6 spots</span></li>
          </ul>
          <div class="main-button">
            <a href="{{ URL::to('details/34') }}">Schedule a visit</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 str">
        <div class="item">
          <a href="{{ URL::to('details/34') }}"><img src="../ref_layouts/landingpage/assets/images/property-02.jpg" alt=""></a>
          <span class="category">Luxury Villa</span>
          <h6>$1.180.000</h6>
          <h4><a href="{{ URL::to('details/34') }}">54 New Street Florida, OR 27001</a></h4>
          <ul>
            <li>Bedrooms: <span>6</span></li>
            <li>Bathrooms: <span>5</span></li>
            <li>Area: <span>450m2</span></li>
            <li>Floor: <span>3</span></li>
            <li>Parking: <span>8 spots</span></li>
          </ul>
          <div class="main-button">
            <a href="{{ URL::to('details/34') }}">Schedule a visit</a>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="row">
      <div class="col-lg-12">
        <ul class="pagination">
          <li><a href="#">1</a></li>
          <li><a class="is_active" href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">>></a></li>
        </ul>
      </div>
    </div> --}}
  </div>
</div>
@endsection