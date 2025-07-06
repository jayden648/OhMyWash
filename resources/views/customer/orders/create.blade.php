@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Buat Pesanan Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        
                        <!-- Service Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
    @if($service->image)
    <img src="{{ asset('storage/' . $service->image) }}" 
         class="img-fluid rounded" 
         alt="{{ $service->name }}">
@else
    <img src="{{ asset('images/placeholders/service-' . (($service->id % 9) ?: 9) . '.jpg') }}"
         class="img-fluid rounded"
         alt="Placeholder {{ $service->name }}">
@endif
</div>
                            <div class="col-md-8">
                                <h5>{{ $service->name }}</h5>
                                <p class="text-muted">{{ $service->description }}</p>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Harga:</strong><br>
                                        <span class="h5 text-primary">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Durasi:</strong><br>
                                        <span class="text-muted">{{ $service->duration_hours }} jam</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Order Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Jumlah Sepatu</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pickup_date" class="form-label">Tanggal Pickup</label>
                                    <input type="date" class="form-control @error('pickup_date') is-invalid @enderror" 
                                           id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('pickup_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pickup_address" class="form-label">Alamat Pickup</label>
                            <textarea class="form-control @error('pickup_address') is-invalid @enderror" 
                                      id="pickup_address" name="pickup_address" rows="3" required>{{ old('pickup_address') }}</textarea>
                            @error('pickup_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Calculation -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <span>Harga per sepatu:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span id="unit-price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <span>Jumlah:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span id="total-quantity">1</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>Total:</strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary h5" id="total-price">Rp {{ number_format($service->price, 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('customer.services') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPrice = {{ $service->price }};
    
    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 1;
        const total = unitPrice * quantity;
        
        document.getElementById('total-quantity').textContent = quantity;
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    quantityInput.addEventListener('input', updateTotal);
});
</script>
@endpush