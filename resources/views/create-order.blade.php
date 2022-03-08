<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-end px-3 sm:px-0 flex-wrap">
                <h1 class="text-4xl">New Order</h1>
                <div class="ml-auto text-right">
                    <div class="text-lg">{{ $customer->name }}</div>
                    <div class="text-lg">{{ $customer->address }}</div>
                </div>
            </div>
            <hr class="my-3 border-t-2" />
            <div>
                <x-input
                    class="search w-full rounded-none sm:rounded"
                    type="search"
                    placeholder="Search" />
            </div>
            <div class="text-slate-500 text-center my-2">
                Protip: when search is selected, press <code>TAB</code> to move to the first product's quantity, then <code>SHIFT+TAB</code> to move back to the search bar
            </div>
            <form  method="POST" action="{{ route('create-order') }}">
            @csrf
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
                    <div class="price ml-auto mr-2" data-id="{{ $product->id }}">
                    ${{ number_format($product->source_price * ($product->pivot->markup ?? $product->default_markup), 2) }} &times;
                    </div>
                    <div>
                        <x-input 
                            class="quantity block w-[100px]"
                            type="text"
                            placeholder="0"
                            name="{{ $product->id }}"
                            value="{{ old($product->id) }}"
                            data-id="{{ $product->id }}" />
                    </div>
                    <div class="ml-2"> = </div>
                    <div class="total text-right min-w-[100px]" data-id="{{ $product->id }}">$0.00</div>
                </div>
            @endforeach
            <hr class="my-3 border-t-2" />
            <div class="my-1 flex flex-col items-end justify-end px-3 sm:px-0">
                <div class="ml-auto text-xl">Deliver At:</div>
                <x-input type="date" name="deliver_at" min="{{ date('Y-m-d') }}" />
                <div class="ml-auto text-xl mb-3">Estimated Total: <span id="total">$0.00</span></div>
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <x-button>
                        {{ __('Submit order') }}
                </x-button>
            </div>
            </form>
        </div>
        <script>
            (() => {
                const quantities = document.querySelectorAll('.quantity');

                quantities.forEach((quantityEl) => {
                    quantityEl.addEventListener('input', () => updateProductTotal(quantityEl));
                    updateProductTotal(quantityEl);
                });

                function updateProductTotal(quantityEl) {
                    const id = quantityEl.dataset.id;
                    const totalEl = document.querySelector(`[data-id="${id}"].total`);
                    const priceEl = document.querySelector(`[data-id="${id}"].price`);
                    if (!quantityEl.value.match(/^\d*$/)) {
                        quantityEl.value = quantityEl.value.replace(/[^\d]/g, '');
                    }
                    const quantity = parseInt(quantityEl.value) || 0;
                    const price = parseFloat(priceEl.innerText.replace('$', '')) || 0;
                    const total = quantity * price;
                    
                    totalEl.innerText = `$${total.toFixed(2)}`;
                    updateTotal();
                }

                function updateTotal() {
                    const total = document.querySelector('#total');
                    let totalValue = 0;

                    document.querySelectorAll('.total').forEach((total) => {
                        totalValue += parseFloat(total.innerText.replace('$', ''));
                    });

                    total.innerText = `$${totalValue.toFixed(2)}`;
                };
            })();

            (() => {
                const searchEl = document.querySelector('.search');

                searchEl.addEventListener('input', () => {
                    const search = searchEl.value;
                    const products = document.querySelectorAll('.product');

                    products.forEach((product) => {
                        const name = product.querySelector('.name').innerText;
                        const match = name.toLowerCase().includes(search.toLowerCase());

                        product.style.display = match ? 'flex' : 'none';
                    });
                });
            })();
        </script>
    </div>
</x-app-layout>
