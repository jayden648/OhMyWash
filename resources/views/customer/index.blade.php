@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="jumbotron bg-primary text-white p-5 rounded">
                <h1 class="display-4">Selamat Datang di OhMyWash</h1>
                <p class="lead">Layanan cuci sepatu terpercaya dengan kualitas terbaik. Sepatu kotor? Biar kami yang urusin!</p>
                <hr class="my-4">
                <p>Proses cepat, hasil maksimal, kepuasan terjamin.</p>
                <a class="btn btn-light btn-lg" href="{{ route('customer.services') }}" role="button">
                    <i class="fas fa-eye me-2"></i>Lihat Layanan
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Services -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h2 class="text-center mb-4">Layanan Unggulan</h2>
        </div>
        
        @foreach($services->take(10) as $service)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card service-card h-100">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}"
                             class="card-img-top service-card-img"
                             alt="{{ $service->name }}">
                    @else
                        <img src="{{ asset('images/placeholders/service-' . $loop->iteration . '.jpg') }}"
                             class="card-img-top service-card-img"
                             alt="{{ $service->name }}">
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                <small class="text-muted">{{ $service->duration_hours }} jam</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Why Choose Us -->
    <div class="row mb-5">
        <div class="col-lg-12">
            <h2 class="text-center mb-4">Mengapa Memilih Kami?</h2>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-clock fa-2x text-white"></i>
                </div>
                <h4>Proses Cepat</h4>
                <p class="text-muted">Pengerjaan dalam 12-24 jam sesuai jenis layanan yang dipilih.</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="text-center">
                <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-shield-alt fa-2x text-white"></i>
                </div>
                <h4>Kualitas Terjamin</h4>
                <p class="text-muted">Menggunakan bahan pembersih berkualitas tinggi dan teknik yang tepat.</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="text-center">
                <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-truck fa-2x text-white"></i>
                </div>
                <h4>Pickup & Delivery</h4>
                <p class="text-muted">Layanan antar jemput untuk kemudahan customer.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-light">
                <div class="card-body text-center p-5">
                    <h3>Siap Untuk Membersihkan Sepatu Anda?</h3>
                    <p class="lead">Pesan sekarang dan rasakan perbedaannya!</p>
                    <a href="{{ route('customer.services') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.service-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    /* Menambahkan overflow: hidden untuk memastikan gambar tidak keluar dari sudut card */
    overflow: hidden;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.service-card-img {
    height: 200px;
    object-fit: cover; /* Memastikan gambar mengisi area tanpa merusak aspek rasio */
}
</style>
@endpush