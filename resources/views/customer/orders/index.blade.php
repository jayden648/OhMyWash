@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="h2">Pesanan Saya</h1>
            <p class="lead">Lihat status dan detail pesanan Anda</p>
        </div>
        <div class="col-lg-4">
            <div class="d-grid">
                <a href="{{ route('customer.services') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Buat Pesanan Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="search" placeholder="Cari nomor pesanan...">
            </div>
        </div>
        <div class="col-md-6">
            <select class="form-select status-filter" id="status-filter">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Dikonfirmasi</option>
                <option value="in_progress">Sedang Diproses</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="row" id="content-container">
        @forelse($orders as $order)
            <div class="col-md-6 col-lg-4 mb-4 filterable-item status-filterable loadable-item" 
                 data-status="{{ $order->status }}" data-order-id="{{ $order->id }}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <!-- Header with Order Number and Status -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-title mb-1">{{ $order->order_number }}</h6>
                                <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        
                        <!-- Service Info -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-shoe-prints text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Layanan</small>
                                    <strong>{{ $order->service->name }}</strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sort-numeric-up text-info me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Jumlah</small>
                                        <span>{{ $order->quantity }} sepatu</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-money-bill text-success me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Total</small>
                                        <span class="text-primary"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pickup Date -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-warning me-2"></i>
                                <div>
                                    <small class="text-muted d-block">Tanggal Pickup</small>
                                    <span>{{ $order->pickup_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar for Status -->
                        @if($order->status !== 'cancelled')
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Progress</small>
                                    <small class="text-muted">
                                        @switch($order->status)
                                            @case('pending') 25% @break
                                            @case('confirmed') 50% @break
                                            @case('in_progress') 75% @break
                                            @case('completed') 100% @break
                                            @default 0%
                                        @endswitch
                                    </small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar 
                                        @if($order->status === 'completed') bg-success
                                        @elseif($order->status === 'in_progress') bg-info
                                        @elseif($order->status === 'confirmed') bg-warning
                                        @else bg-secondary
                                        @endif"
                                        style="width: 
                                            @switch($order->status)
                                                @case('pending') 25% @break
                                                @case('confirmed') 50% @break
                                                @case('in_progress') 75% @break
                                                @case('completed') 100% @break
                                                @default 0%
                                            @endswitch">
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                            @if($order->status === 'pending')
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="cancelOrder('{{ $order->id }}')">
                                    <i class="fas fa-times me-2"></i>Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Belum Ada Pesanan</h3>
                    <p class="text-muted">Mulai pesan layanan cuci sepatu sekarang!</p>
                    <a href="{{ route('customer.services') }}" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Layanan
                    </a>
                </div>
            </div>
        @endforelse
    </div>