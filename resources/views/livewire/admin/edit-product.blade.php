<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl text-center font-semibold mb-8">この情報を入力して製品を作成します</h1>

<div class="mb-4" wire:ignore >
    <form action="{{route('admin.products.files',$product)}}"
    method="POST"
    class="dropzone"
    id="my-awesome-dropzone"></form>
</div>

@if ($product->images->count())

<section class="bg-white shadow-xl rounded-lg p-6 mb-4">
    <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>

    <ul class="flex flex-wrap">
        @foreach ($product->images as $image)

            <li class="relative" wire:key="image-{{ $image->id }}">
                <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" alt="">
                <x-jet-danger-button class="absolute right-2 top-2"
                    wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                    wire:target="deleteImage({{ $image->id }})">
                    x
                </x-jet-danger-button>
            </li>

        @endforeach

    </ul>
</section>

@endif
    <div class="bg-white shadow-xl rounded-lg p-6">
        <div class="grid grid-cols-2 gap-6 mb-4">
            {{-- category --}}
            <div>
                <x-jet-label value="Categorias" />
                <select name="" class="w-full form-control" wire:model="category_id">
                    <option value="" selected disabled>カテゴリーを選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
     
                <x-jet-input-error for="category_id"/>
            </div>
     
            {{-- subcategory --}}
            <div>
             <x-jet-label value="Subcategorias" />
             <select name="" class="w-full form-control" wire:model="product.subcategory_id">
                 <option value="" selected disabled>カテゴリーを選択してください</option>
                 @foreach ($subcategories as $subcategory)
                     <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                 @endforeach
             </select>
     
             <x-jet-input-error for="product.subcategory_id"/>
            </div>
        </div>
     
        {{-- Number --}}
        <div class="mb-4">
            <x-jet-label value="Nombre"/>
            <x-jet-input type="text" wire:model="product.name"  class="w-full" placeholder="numberを選択してください"/>
            <x-jet-input-error for="product.name"/>
        </div>
        {{-- Slug --}}
        <div class="mb-4">
     
            <x-jet-label value="Nombre del Slug del producto" />
    
            <x-jet-input class="w-full bg-gray-200" 
                        wire:model="slug"
                        type="text" 
                        disabled   
                        placeholder="Ingrese el Slug del producto" />
            <x-jet-input-error for="slug" />
        </div>
     
         {{--Description --}}
         <div class="mb-4">
     <div wire:ignore>
         <x-jet-label value="Description"/>
         <textarea name="" class="w-full form-control" id="" rows="4"
         wire:model="product.description"
         x-data
         x-init="ClassicEditor.create($refs.miEditor)
         .then(function(editor){
             editor.model.document.on('change:data',()=>{
                 @this.set('product.description',editor.getData())
             })
         })
         .catch( error => {
             console.error( error );
         } );"
         x-ref="miEditor"></textarea>
     </div>
             <x-jet-input-error for="product.description"/>
         </div>
     
     
     
         <div class="grid grid-cols-2 gap-6 mb-4">
             {{-- メーカー --}}
             <div>
                 <x-jet-label value="メーカー"/>
                 <select name="" id="" wire:model="product.brand_id" class="form-control w-full">
                     <option value="" selected disabled >選択してください</option>
                     @foreach ($brands as $brand)
                         <option value="{{$brand->id}}">{{$brand->name}}</option>
                     @endforeach
                 </select>
                 <x-jet-input-error for="product.brand_id"/>
             </div>
      
             {{-- Precio --}}
             <div>
                 <x-jet-label value="Precio"/>
                 <x-jet-input 
                 wire:model="product.price"
                 type="number" class="w-full" step=".01"/>
                 <x-jet-input-error for="product.price"/>
             </div>
         </div>
    
        @if ($this->subcategory)
            @if(!$this->subcategory->color && !$this->subcategory->size)
            <div>
                <x-jet-label value="Cantidad"/>
                <x-jet-input wire:model="product.quantity" type="number" class="w-full"/>
                <x-jet-input-error for="product.quantity"/>
            </div>
            @endif
        @endif
     
    
     
     <div class="flex justify-end items-center mt-4">

        <x-jet-action-message class="mr-3" on="saved">
            更新しました
        </x-jet-action-message>

         <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save" >
             製品を更新する
         </x-jet-button>
     </div>
    </div>

@if ($this->subcategory)
    @if ($this->subcategory->size)    
        @livewire('admin.size-product',['product'=>$product],key('size-product-'.$product->id))  
    @elseif($this->subcategory->color)
        @livewire('admin.color-product',['product'=>$product],key('color-product-'.$product->id)) 
    @endif
@endif

@push('script')
<script>
    Dropzone.options.myAwesomeDropzone = {
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        dictDefaultMessage: "Arrastre una imagen al recuadro",
        acceptedFiles: 'image/*',
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        complete: function(file) {
            this.removeFile(file);
        },
        queuecomplete: function() {
            Livewire.emit('refreshProduct');
        }
    };
    </script>
@endpush
 </div>
 