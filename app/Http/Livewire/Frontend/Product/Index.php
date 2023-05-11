<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $products, $category, $quantityCount = 1;

    public function mount($products, $category)
    {
        $this->products = $products;
        $this->category = $category;
    }

    public function decrementQuantity(){
        if($this->quantityCount > 1) {
            $this->quantityCount--;
        }
    }

    public function incrementQuantity(){
        $this->quantityCount++;

    }

    public function addToCart(int $productId){
       if(Auth::check())
       {
           Cart::create([
               'user_id'=>auth()->user()->id,
               'product_id'=>$productId,
               'quantity' => $this->quantityCount
           ]);
           $this->emit('CartAddedUpdated');
            return redirect()->back()->with('message','ADDED');
       }
       else{
           session()->flash('message','Please login first');
           $this->dispatchBrowserEvent('message',[
               'text'=>'Please Login to add cart',
               'type'=>'info',
               'status'=> 401
           ]);
       }
    }

    public function render()
    {

        return view('livewire.frontend.product.index',[
            'products'=>$this->products,
            'category'=>$this->category
        ]);
    }
}
