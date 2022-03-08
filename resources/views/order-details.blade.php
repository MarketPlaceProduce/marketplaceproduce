<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-end px-3 sm:px-0">
                <h1 class="text-4xl">Order {{ $order->id }}</h1>
                <div  class="bg-purple-500 bg-blue-500 bg-green-500"></div>
                <div class="order-status px-2 my-2 ml-2 rounded bg-{{ 
                    $order->status == 'pending' ? 'purple' : 
                    ($order->status == 'delivered' ? 'green' : 
                    'blue') }}-500 text-white">
                    {{ $order->status }}
                </div>
                <div class="ml-auto text-right">
                    <div class="text-lg">{{ $customer->name }}</div>
                    <div class="text-lg">{{ $customer->address }}</div>
                    <div class="text-sm text-slate-500">Estimated Delivery: {{ $order->deliver_at->format('m/d/Y') }}</div>
                </div>
            </div>
            <hr class="my-3 border-t-2" />
            <input type="hidden" name="customer" value="{{ $customer->id }}" />
            @foreach ($products as $product)
                <div class="product bg-white overflow-hidden shadow-sm sm:rounded-lg bg-white p-3 my-1 border-b border-gray-200 flex items-center">
                    <div>
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10" />
                    </div>
                    <div class="ml-2">
                        <div class="name ">
                        {{ $product->name }}
                        </div>
                        <div class="id text-slate-500 text-xs">
                        {{ $product->id }}
                        </div>
                    </div>
                    <div class="quantity ml-auto mr-2" data-id="{{ $product->id }}">
                    &times; {{ $product->pivot->quantity }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
