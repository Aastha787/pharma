<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckoutShow extends Component
{
    public $carts, $totalProductAmount = 0;
    public $fullname, $email, $phone, $pincode, $address, $payment_mode= NULL, $payment_id=NULL;

    protected $listeners = [
        'validationForAll',
        'transactionEmit'=>'paidOnlineOrder'
    ];

    public function paidOnlineOrder($value)
    {
        $this->payment_id= $value;
        $this->payment_mode = 'Paid by Paypal';

        $codOrder = $this->placeOrder();
        if($codOrder){

            Cart::where('user_id',auth()->user()->id)->delete();
            $this->dispatchBrowserEvent('message',[
                'text'=> 'Order placed successfully',
                'type'=>'success',
                'status'=>200
            ]);
            return redirect()->to('Thankyou');
        }else{
            $this->dispatchBrowserEvent('message',[
                'text'=> 'Something went wrong',
                'type'=>'error',
                'status'=>500
            ]);
        }
    }

    public function validationForAll()
    {
        $this->validate();
    }

    public function rules()
    {
        return [
            'fullname'=> 'required|string|max:121',
            'email'=> 'required|email|max:121',
            'phone'=> 'required|string|max:10|min:10',
            'pincode'=> 'required|string|max:6|min:6',
            'address'=> 'required|string|max:500',
        ];
    }

    public function placeOrder()
    {
          $this->validate();
        $order = Order::create([
            'user_id'=>auth()->user()->id,
            'tracking_no'=>'pharm-'.Str::random(10),
            'fullname'=>$this->fullname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'pincode'=>$this->pincode,
            'address'=>$this->address,
            'status_message'=>'in progress',
            'payment_mode'=> $this->payment_mode,
            'payment_id'=>$this->payment_id,
        ]);

        foreach($this->carts as $cartItem) {
            $orderItems = Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->selling_price
            ]);
            if($cartItem->product_id !=NULL){
                $cartItem->product()->where('id',$cartItem->product_id)->decrement('quantity',$cartItem->quantity);
            }

        }

            return $order;
    }





    public function codOrder()
    {
        $this->payment_mode = 'cash on delivery';
        $codOrder = $this->placeOrder();
        if($codOrder){

            Cart::where('user_id',auth()->user()->id)->delete();
            $this->dispatchBrowserEvent('message',[
               'text'=> 'Order placed successfully',
               'type'=>'success',
               'status'=>200
            ]);
            return redirect()->to('Thankyou');
        }else{
            $this->dispatchBrowserEvent('message',[
                'text'=> 'Something went wrong',
                'type'=>'error',
                'status'=>500
            ]);
        }
    }

    public function totalProductAmount()
    {
        $this->totalProductAmount =0;
        $this->carts = Cart::where('user_id',auth()->user()->id)->get();
        foreach($this->carts as $cartItem)
        {
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;
    }

    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email =auth()->user()->email;
        $this->totalProductAmount=$this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show',[
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}