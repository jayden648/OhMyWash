@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Pesanan</h4>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informasi Pesanan</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td>No. Pesanan:</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pesan:</td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($order->estimated_completion)
                                    <tr>
                                        <td>Estimasi Selesai:</td>
                                        <td>{{ $order->estimated_completion->format('d M Y H:i') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Pickup</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Tanggal Pickup:</td>
                                    <td>{{ $order->pickup_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat:</td>
                                    <td>{{ $order->pickup_address }}</td>
                                </tr>
                                @if($order->notes)
                                    <tr>
                                        <td>Catatan:</td>
                                        <td>{{ $order->notes }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Service Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6>Detail Layanan</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    @if($order->service->image)
                                        <img src="{{ asset('storage/' . $order->service->image) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $order->service->name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 120px;">
                                            <i class="fas fa-shoe-prints fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $order->service->name }}</h5>
                                    <p class="text-muted">{{ $order->service->description }}</p>
                                    <div class="row">
                                        <div class="col-4">
                                            <small class="text-muted">Harga per sepatu:</small><br>
                                            <span>Rp {{ number_format($order->service->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Jumlah:</small><br>
                                            <span>{{ $order->quantity }} sepatu</span>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted">Total:</small><br>
                                            <span class="text-primary"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    @if($order->status !== 'pending')
                        <hr>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6>Status Pesanan</h6>
                                <div class="timeline">
                                    <div class="timeline-item {{ $order->status === 'pending' ? 'active' : 'completed' }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Pesanan Dibuat</h6>
                                            <p class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    @if(in_array($order->status, ['confirmed', 'in_progress', 'completed']))
                                        <div class="timeline-item {{ $order->status === 'confirmed' ? 'active' : 'completed' }}">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6>Pesanan Dikonfirmasi</h6>
                                                <p class="text-muted">{{ $order->updated_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if(in_array($order->status, ['in_progress', 'completed']))
                                        <div class="timeline-item {{ $order->status === 'in_progress' ? 'active' : 'completed' }}">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6>Sedang Dikerjakan</h6>
                                                <p class="text-muted">Sepatu sedang dalam proses pembersihan</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($order->status === 'completed')
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6>Pesanan Selesai</h6>
                                                <p class="text-muted">Sepatu siap untuk diambil</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('customer.orders') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        @if($order->status === 'pending')
                            <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 2px solid #fff;
}

.timeline-item.active .timeline-marker {
    background-color: #007bff;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745;
}

.timeline-content h6 {
    margin-bottom: 5px;
    color: #495057;
}

.timeline-content p {
    margin-bottom: 0;
    font-size: 0.9rem;
}
</style>
@endpush