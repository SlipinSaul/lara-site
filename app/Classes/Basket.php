<?php

namespace App\Classes;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\warning;

class Basket
{
    private $order;
    public function __construct($EagerLoad=null, $createOrder=false)
    {

        $orderId=session('orderId');

        if(is_null($orderId) && $createOrder){
            $data=[];
            if(Auth::check()){
                $data['user_id']=Auth::id();
            }
            $this->order= Order::query()->create($data);
            session(['orderId' => $this->order->id]);
        }
        else {
            if($EagerLoad){
                $this->order=Order::with($EagerLoad)->findOrFail($orderId);
            }
            else{
                $this->order= Order::query()->findOrFail($orderId);
            }
        }


    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getPivotRow($product)
    {
        return $this->order->products()->where('product_id',$product->id)->first()->pivot;
    }
    public function addProduct(Product $product)
    {
        if($this->order->products->contains($product->id)){
            if(($this->getPivotRow($product)->count + 1) > $product->count){
                return false;
            }
            $this->order->products()->updateExistingPivot($product->id, [
                'count' => DB::raw('count + 1')
            ]);
        }
        else {
            $this->order->products()->attach($product->id);
        }
        Order::changeFullSum($product->price);
        return true;
    }

    public function removeProduct(Product $product)
    {
        if($this->order->products->contains($product->id)){
            if($this->order->products()->where('product_id', $product->id)->wherePivot('count', '<', 2)->exists()){
                $this->order->products()->detach($product->id);
            }
            else {
                $this->order->products()->updateExistingPivot($product->id, [
                    'count' => DB::raw('count - 1')
                ]);
            }
            Order::changeFullSum(-($product->price));
            return redirect()->route('basket');
        } else {
            session()->flash('warning', "Товара нет в корзине");
            return redirect()->route('index');
        }
    }

    public function countAvailable($updateCount=false)
    {
        foreach($this->order->products as $orderProduct) {
           if($orderProduct->count < $this->getPivotRow($orderProduct)->count){
               return false;
           }
           if($updateCount){
               $orderProduct->count -= $this->getPivotRow($orderProduct)->count;
           }
        }
        if($updateCount){
            $this->order->products->map->save();
        }
        return true;
    }
}
