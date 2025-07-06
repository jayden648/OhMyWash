<?php

namespace App\Http\Controllers\Customer;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        return view('customer.index', compact('services'));
    }

    public function services()
    {
        $services = Service::where('is_active', true)->paginate(9);
        return view('customer.services', compact('services'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('service')->latest()->paginate(9);
        return view('customer.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        // Pastikan customer hanya bisa melihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('customer.orders.show', compact('order'));
    }

    public function createOrder(Service $service)
    {
        return view('customer.orders.create', compact('service'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        Order::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'quantity' => $request->quantity,
            'total_amount' => $service->price * $request->quantity,
            'pickup_date' => $request->pickup_date,
            'pickup_address' => $request->pickup_address,
            'notes' => $request->notes,
            'order_number' => 'OMW-' . strtoupper(Str::random(8)),
        ]);

        return redirect()->route('customer.orders')->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}



