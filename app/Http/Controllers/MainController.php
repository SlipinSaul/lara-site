<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Основной контроллер
class MainController extends Controller
{
    public function index(ProductsFilterRequest $request) //Lab03 Метод главного контроллера для запроса из БД данных о товарах
    {
        $productsQuery = Product::with('category') ;
        if($request->filled('price_from')) { // Lab05 обработка get запроса с фильтрами по товарам и соответствующие  запросы к бд в зависимости от фильтров
            $productsQuery->where('price', '>=', $request->price_from);
        }
        if($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }
        foreach (['hit', 'new', 'recommend'] as $field) {
            if($request->has($field)) {
                $productsQuery->where($field, 1);
            }
        }
        $products = $productsQuery->paginate(6)->withQueryString();
        return view('index', compact('products'));
    }

    public function categories()
    {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }

    public function category($code)
    {
        $category=Category::query()->where('code',$code)->first();
        return view('category', compact('category'));
    }

    public function product($category, $productCode)
    {
        $product=Product::withTrashed()->where('code',$productCode)->first();
        return view('product', ['product' => $product]);
    }




}
