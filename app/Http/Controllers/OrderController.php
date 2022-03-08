<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Mail\OrderCreatedAdmin;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = $request->user()->customers->where('active', 1)->first();
        
        return view('dashboard', [
            'customer' => $customer,
            'orders' => $customer ? $customer->orders->sortByDesc('id') : collect([]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customer = $request->user()->customers->where('active', 1)->first();

        if (! $customer) {
            return redirect()->route('dashboard');
        }

        return view('create-order', [
            'products' =>$customer->products,
            'customer' =>$customer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $products = $request->except(['_token', 'customer', 'deliver_at']);
        $request->validate([
            'customer' => ['required', 'string'],
            'deliver_at' => ['required', 'date'],
            '_token' => [
                function ($attribute, $value, $fail) use ($products) {
                    if (collect($products)->sum() <= 0) {
                        $fail('You must select at least one product.');
                    }
                },
            ],
        ]);

        $customerId = $request->input('customer');
        $deliverAt = $request->input('deliver_at');

        $order = Order::create([
            'customer_id' => $customerId,
            'deliver_at' => $deliverAt,
        ]);

        foreach ($products as $productId => $quantity) {
            if ($quantity > 0) {
                $order->products()->attach($productId, [
                    'quantity' => $quantity,
                ]);
            }
        }

        Mail::to($order->customer->contact_email)->send(new OrderCreated($order));
        Mail::to('admin@marketplaceproduce.com')->send(new OrderCreatedAdmin($order));

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (!$order) {
            return redirect()->route('dashboard');
        }

        return view('order-details', [
            'order' => $order,
            'customer' => $order->customer,
            'products' => $order->products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
