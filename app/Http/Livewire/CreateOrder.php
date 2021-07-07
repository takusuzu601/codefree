<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{

    public $envio_type = 1;


    public $contact, $phone, $address, $reference, $shipping_cost = 0;

    public $departments, $cities = [], $districts = [];

    public $department_id = "", $city_id = "", $districts_id = "";

    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envio_type' => 'required'
    ];

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function updatedEnvioType($value)
    {
        //配送先住所のバリデーションをリセットしてる
        if ($value == 1) {
            $this->resetValidation(['department_id', 'city_id', 'districts_id', 'address', 'reference']);
        }
    }

    //都道府県選択後に市区町村が表示されるスクリプト
    public function updatedDepartmentId($value)
    {
        $this->cities = City::where('department_id', $value)->get();
        $this->reset(['city_id', 'districts_id']);
    }

    public function updatedCityId($value)
    {
        $city = City::find($value);

        $this->shipping_cost = $city->cost;

        $this->districts = District::where('city_id', $value)->get();

        $this->reset('districts_id');
    }

    public function create_order()
    {
        $rules = $this->rules;
        if ($this->envio_type == 2) {
            $rules['department_id'] = 'required';
            $rules['city_id'] = 'required';
            $rules['districts_id'] = 'required';
            $rules['address'] = 'required';
            $rules['reference'] = 'required';
        }

        $this->validate($rules);

        $order = new Order();

        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        $order->envio_type = $this->envio_type;
        $order->shipping_cost = $this->shipping_cost;
        $order->total = $this->shipping_cost + Cart::subtotal();
        $order->content = Cart::content();

        if ($this->envio_type == 2) {
            $order->shipping_cost = $this->shipping_cost;
            $order->department_id = $this->department_id;
            $order->city_id = $this->city_id;
            $order->districts_id = $this->districts_id;
            $order->address = $this->address;
            $order->reference = $this->reference;
        }

        $order->save();
        
        foreach(Cart::content() as $item){
            discount($item);
        }

        Cart::destroy();

        return redirect()->route('orders.paymant', $order);
    }
    public function render()
    {
        return view('livewire.create-order');
    }
}
