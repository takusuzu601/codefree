<div class="container py-8 grid grid-cols-5 gap-6">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <x-jet-label value="連絡先" />
                <x-jet-input class="w-full" type="text" wire:model.defer="contact"
                    placeholder="Ingrese el nombre de la persona que recibira el producto" />
                <x-jet-input-error for="contact" />
            </div>

            <div>
                <x-jet-label value="電話番号" />
                <x-jet-input class="w-full" type="text" wire:model.defer="phone"
                    placeholder="Ingrese el nombre de la persona que recibira el producto" />
                <x-jet-input-error for="phone" />
            </div>
        </div>



        <div x-data="{envio_type:@entangle('envio_type')}">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">配送</p>
            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600" id="">
                <span class="ml-2 text-gray-700">
                    店舗受け取り(calle Falsa 123)
                </span><span class="font-semibold text-gray-700 ml-auto">
                    Gratis
                </span>
            </label>

            <div class="bg-white rounded-lg shadow">
                <label class="px-6 py-4 flex items-center">
                    <input x-model="envio_type" type="radio" value="2" name="envio_type" class="text-gray-600" id="">
                    <span class="ml-2 text-gray-700">
                        配送先住所
                    </span>
                </label>
                <div class="px-6 pb-6 grid grid-cols-2 gap-6 hidden" :class="{'hidden':envio_type!=2}">
                    {{-- Departament --}}
                    <div>
                        <x-jet-label value="Departamento" />
                        <select class="form-control w-full" wire:model="department_id">
                            <option value="" disabled selected>departmentを選択してください</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>

                        <x-jet-input-error for="department_id" />

                    </div>

                    {{-- Ciudades --}}
                    <div>
                        <x-jet-label value="Ciudad" />
                        <select class="form-control w-full" wire:model="city_id">
                            <option value="" disabled selected>cityを選択してください</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="city_id" />
                    </div>


                    {{-- Distrito --}}
                    <div>
                        <x-jet-label value="Distrito" />
                        <select class="form-control w-full" wire:model="districts_id">
                            <option value="" disabled selected>districtを選択してください</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="districts_id" />

                    </div>

                    <div>
                        <x-jet-label value="Direccion" />
                        <x-jet-input class="w-full" wire:model="address" type="text" />
                        <x-jet-input-error for="address" />
                    </div>
                    <div class="col-span-2">
                        <x-jet-label value="Referencia" />
                        <x-jet-input class="w-full" wire:model="reference" type="text" />
                        <x-jet-input-error for="reference" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <x-jet-button wire:loading.attr="disabled" wire:target="create_order" class="mt-6 mb-4"
                wire:click="create_order">
                支払い画面へ
            </x-jet-button>
            <hr>
            <p class="text-sm text-gray-700 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam ex
                illo
                repellendus
                laboriosam,
                cupiditate nulla <a href="" class="text-orange-700">プライバシーポリシー</a></p>
        </div>
    </div>
    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">

                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p>Cant:{{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="px-2">-Color:{{ __($item->options['color']) }}</p>
                                @endisset

                                @isset($item->options['size'])
                                    <p class="px-2">{{ $item->options['size'] }}</p>
                                @endisset
                            </div>
                            <p>USD:{{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-crnter text-gray-700">
                            No tiene agregado ningun item en el carrito22
                        </p>
                    </li>
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">
            <div class="text-gray-700">
                <p class="flex justify-between items-center">Subtotal
                    <span class="font-semibold">{{ Cart::subtotal() }}USD</span>
                </p>
                <p class="flex justify-between items-center">Envio
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Grati
                        @else
                            {{ $shipping_cost }}USD
                        @endif
                    </span>
                </p>
                <hr class="mt-4 mb-3">
                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total</span>
                    <span class="font-semibold">
                        @if ($envio_type == 1)
                            {{ Cart::subtotal() }}USD
                        @else
                            {{ Cart::subtotal() + $shipping_cost }}USD
                        @endif
                    </span>
                </p>
            </div>
        </div>

    </div>
</div>
