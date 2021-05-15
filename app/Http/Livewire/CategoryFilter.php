<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends Component
{
    use WithPagination;

    public $category, $subcategoria, $marca;

    public $view = "grid";

    public function limpiar()
    {
        $this->reset(['subcategoria', 'marca']);
    }
    public function render()
    {
        // $products = $this->category->products()->where('status', 2)->paginate(20);

        $productsQuery = Product::query()->WhereHas('subcategory.category', function (Builder $query) {
            $query->where('id', $this->category->id);
        });
        if ($this->subcategoria) {
            $productsQuery = $productsQuery->WhereHas('subcategory', function (Builder $query) {
                $query->where('name', $this->subcategoria);
            });
        }
        if ($this->marca) {
            $productsQuery = $productsQuery->WhereHas('brand', function (Builder $query) {
                $query->where('name', $this->marca);
            });
        }

        $products = $productsQuery->paginate(20);

        return view('livewire.category-filter', compact('products'));
    }
}
