<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class BasketController extends Controller
{
    public function basket()
    {
        $order= (new Basket('products.category'))->getOrder();
        return view('basket', compact('order'));
    }

    public function basketPlace()
    {

        $basket = new Basket();
        $order= $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning', 'Товар не доступен для заказа в полном объеме');
            return redirect()->route('basket');
        }
        return view('order', compact('order'));
    }


    public function basketConfirm(Request $request)
    {

        $basket = new Basket();
        $order= $basket->getOrder();
        if (!$basket->countAvailable(true)) {
            session()->flash('warning', 'Товар не доступен для заказа в полном объеме');
            return redirect()->route('basket');
        }
        $email = Auth::check() ? Auth::user()->email : $request->email;
        if($order->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', 'Ваш заказ принят в обработку');
        }
        else {
            session()->flash('warning', 'Произошла ощибка');
        }
        Order::eraseOrderSum();
        return redirect()->route('index');
    }


    public function basketAdd(Product $product)
    {
        if($product->isAvailable()){
           $result = (new Basket(null, true))->addProduct($product);
           if($result){
               session()->flash('success', 'Добавлен товар '. $product->name);
           }
           else {
               session()->flash('warning', 'Товар '. $product->name . ' в большем количестве не доступен');
           }
        } else {
            session()->flash('warning', 'Товар закночился или недоступен');
            return redirect()->route('index');
        }
        return redirect()->route('basket');
    }

    public function basketRemove(Product $product)
    {
        return (new Basket())->removeProduct($product);
    }

}
