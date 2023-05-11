<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount;

    protected $listeners = ['CartAddedUpdated'=>'checkCartCount'];
    public function checkCartCount()
    {
        if(Auth::check())
        {
            return $this->cartCount = cart::where('user_id',auth()->user()->id)->count();
        }
    }

    public function render()
    {
        $this->cartCount = $this->checkCartCount();
        return view('livewire.frontend.cart.cart-count',[
            'cartCount'=>$this->cartCount
        ]);
    }
}
