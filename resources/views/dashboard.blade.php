<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center px-3 sm:px-0">
                <h1 class="text-4xl">Orders</h1>
                @if($customer)
                    <a href="{{ route('create-order') }}" class="ml-auto">
                        <x-button>
                            {{ __('New Order') }}
                        </x-button>
                    </a>
                @else
                    <x-button class="ml-auto" disabled>
                            {{ __('New Order') }}
                    </x-button>
                @endif
            </div>
            <hr class="my-3 border-t-2" />
            @foreach ($orders as $order)
                <div class="order bg-white overflow-hidden shadow-sm sm:rounded-lg bg-white p-4 my-1 border-b border-gray-200 flex items-center">
                    <div class="order-id text-slate-500 text-sm">
                        {{ $order->id }}
                    </div>
                    <div class="order-customer ml-3 text-lg">
                        {{ $order->customer->name }}
                    </div>
                    <div class="ml-auto flex flex-col items-end text-right">
                        <div  class="bg-purple-500 bg-blue-500 bg-green-500"></div>
                        <div class="order-status px-2 rounded bg-{{ 
                            $order->status == 'pending' ? 'purple' : 
                            ($order->status == 'delivered' ? 'green' : 
                            'blue') }}-500 text-white">
                            {{ $order->status }}
                        </div>
                        <div class="order-deliver-at text-slate-500">
                            Estimated Delivery: {{ $order->deliver_at->format('m/d/Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
            @if (!$customer)
                <div class="p-4">
                    <p class="text-center text-muted">
                        {{ __('Thank you for your interest, your account will be reviewed by an administrator before being able to create online orders') }}
                    </p>
                </div>
            @endif
            @if ($customer && $orders->isEmpty())
                <div class="p-4">
                    <p class="text-center text-muted">
                        {{ __('Nothing here yet.') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
