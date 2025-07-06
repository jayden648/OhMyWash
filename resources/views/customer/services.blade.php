@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h1 class="h2">Layanan Cuci Sepatu</h1>
            <p class="lead">Pilih layanan yang sesuai dengan kebutuhan sepatu Anda</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="search" placeholder="Cari layanan...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-outline-primary filter-btn active" data-filter="all">
                    Semua
                </button>
                <button type="button" class="btn btn-outline-primary filter-btn" data-filter="basic">
                    Basic
                </button>
                <button type="button" class="btn btn-outline-primary filter-btn" data-filter="premium">
                    Premium
                </button>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="row" id="content-container">
        @foreach($services as $service)
            <div class="col-md-6 col-lg-4 mb-4 filterable-item loadable-item" data-service-type="{{ strtolower($service->category ?? 'basic') }}">
                <div class="card service-card h-100 shadow-sm">
                    @if($service->image)
    <img src="{{ asset('storage/' . $service->image) }}" 
         class="card-img-top"
         alt="{{ $service->name }}"
         style="height: 250px; object-fit: cover;">
@else
    <img src="{{ asset('images/placeholders/service-' . $loop->iteration . '.jpg') }}"
         class="card-img-top"
         alt="Placeholder {{ $service->name }}"
         style="height: 250px; object-fit: cover;">
@endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $service->name }}</h5>
                            @if($service->category)
                                <span class="badge bg-secondary">{{ ucfirst($service->category) }}</span>
                            @endif
                        </div>
                        
                        <p class="card-text flex-grow-1 text-muted">{{ $service->description }}</p>
                        
                        <div class="mt-auto">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Harga</small>
                                            <span class="h5 text-primary mb-0">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-info me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Durasi</small>
                                            <span>{{ $service->duration_hours }} jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <a href="{{ route('customer.order.create', $service) }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($services->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shoe-prints fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Belum Ada Layanan Tersedia</h3>
                    <p class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut</p>
                    <a href="{{ route('customer.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Load More Button -->
    @if($services->hasPages())
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-outline-primary" id="load-more" data-page="1">
                    <i class="fas fa-plus me-2"></i>Muat Lebih Banyak
                </button>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.service-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.filter-btn.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.badge {
    font-size: 0.7rem;
}
</style>
@endpush