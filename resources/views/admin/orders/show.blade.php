@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Detail Order #{{ $order->order_number ?? $order->id }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Layanan:</strong> {{ $order->service->name }}</p>
            <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            <p><strong>Tanggal Jemput:</strong> {{ $order->pickup_date ? $order->pickup_date->format('d/m/Y') : '-' }}</p>
            <p><strong>Alamat Jemput:</strong> {{ $order->pickup_address }}</p>
            <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Catatan:</strong> {{ $order->notes ?? '-' }}</p>
        </div>
    </div>

    @if($order->orderItems && $order->orderItems->count())
        <h5>Item Pesanan</h5>
        <ul class="list-group mb-4">
            @foreach($order->orderItems as $item)
                <li class="list-group-item">
                    {{ $item->name ?? '-' }} - {{ $item->quantity ?? 1 }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection