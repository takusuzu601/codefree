<div>
  <div class="bg-white shadow-lg rounded-lg p-6 mt-12">
    <div>
      <x-jet-label>
        数量
      </x-jet-label>
      <x-jet-input wire:model="name" type="text" placehol="Ingrese una talla" class="w-full"/>
      <x-jet-input-error for="name"/>
    </div>

    <div class="flex justify-end items-center mt-4">
      <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save">
        Agregar
      </x-jet-button>
    </div>
  </div>

  <ul class="mt-12 space-y-4">
    @foreach ($sizes as $size)
    <li class="bg-white shadow-lg rounded-lg p-6" wire:key="size-{{$size->id}}">
      <div class="flex items-center">
        <span class="text-xl font-medium">{{$size->name}}</span>
        <div class="ml-auto">
          <x-jet-button wire:click="edit({{$size->id}})" wire:loading.attr="disabled" wire:target="edit({{$size->id}})">
            <i class="fas fa-edit"></i>
            <span class="ml-2">編集</span>
          </x-jet-button>
          <x-jet-danger-button wire:click="$emit('deleteSize',{{$size->id}})">
            <i class="fas fa-trash"></i>  
              <span class="ml-2">削除</span>
          </x-jet-danger-button>
          
        </div>
      </div>

      @livewire('admin.color-size', ['size' => $size], key('color-size'.$size->id))

    </li>    
    @endforeach
    
  </ul>

  <x-jet-dialog-modal wire:model="open">
     <x-slot name="title">
       Editar talla
     </x-slot>
     <x-slot name="content">
       <x-jet-label>
        Talla
       </x-jet-label>
       <x-jet-input type="text" wire:model="name_edit" class="w-full"/>
       <x-jet-input-error for="name_edit"/>
    </x-slot>
    <x-slot name="footer">
       <x-jet-secondary-button wire:click="$set('open',false)">
         キャンセル
       </x-jet-secondary-button>
       <x-jet-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
         登録する
       </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>

  @push('script')
    <script>
      Livewire.on('deleteSize', sizeId=>{
        
        Swal.fire({
           title: 'Are you sure?',
           text: "You won't be able to revert this!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
           }).then((result) => {
           if (result.isConfirmed) {

             Livewire.emitTo('admin.size-product','delete',sizeId);
              Swal.fire(
                 'Deleted!',
                 'Your file has been deleted.',
                 'success'
              )
           }
           })
        })
    </script>
  @endpush

</div>
