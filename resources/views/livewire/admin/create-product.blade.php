<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
   <h1 class="text-3xl text-center font-semibold mb-8">この情報を入力して製品を作成します</h1>

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
        <select name="" class="w-full form-control" wire:model="subcategory_id">
            <option value="" selected disabled>カテゴリーを選択してください</option>
            @foreach ($subcategories as $subcategory)
                <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
            @endforeach
        </select>

        <x-jet-input-error for="subcategory_id"/>
       </div>
   </div>

   {{-- Number --}}
   <div class="mb-4">
       <x-jet-label value="Nombre"/>
       <x-jet-input type="text" wire:model="name"  class="w-full" placeholder="numberを選択してください"/>
       <x-jet-input-error for="name"/>
   </div>
   {{-- Slug --}}
   <div class="mb-4">
    <x-jet-label value="Slug"/>
    <x-jet-input type="text" wire:model="slug" disabled class="w-full bg-trueGray-200" placeholder="Slugを選択してください"/>
    <x-jet-input-error for="slug"/>
　　</div>

    {{--Description --}}
    <div class="mb-4">
<div wire:ignore>
    <x-jet-label value="Description"/>
    <textarea name="" class="w-full form-control" id="" rows="4"
    wire:model="description"
    x-data
    x-init="ClassicEditor.create($refs.miEditor)
    .then(function(editor){
        editor.model.document.on('change:data',()=>{
            @this.set('description',editor.getData())
        })
    })
    .catch( error => {
        console.error( error );
    } );"
    x-ref="miEditor"></textarea>
</div>
        <x-jet-input-error for="description"/>
    </div>



    <div class="grid grid-cols-2 gap-6 mb-4">
        {{-- メーカー --}}
        <div>
            <x-jet-label value="メーカー"/>
            <select name="" id="" wire:model="brand_id" class="form-control w-full">
                <option value="" selected disabled >選択してください</option>
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
            <x-jet-input-error for="brand_id"/>
        </div>
 
        {{-- Precio --}}
        <div>
            <x-jet-label value="Precio"/>
            <x-jet-input 
            wire:model="price"
            type="number" class="w-full" step=".01"/>
            <x-jet-input-error for="price"/>
        </div>
    </div>

    {{$this->subcategory}}

@if ($subcategory_id)
    @if(!$this->subcategory->color && !$this->subcategory->size)
    <div>
        <x-jet-label value="Cantidad"/>
        <x-jet-input wire:model="quantity" type="number" class="w-full"/>
        <x-jet-input-error for="quantity"/>
    </div>
    @endif
@endif

<div class="flex">
    <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save" class="ml-auto">
        製品を作成する
    </x-jet-button>
</div>
</div>
