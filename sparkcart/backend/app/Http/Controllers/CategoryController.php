<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (! $category) {
            return redirect()->route('shop.index');
        }

        $searchQuery = $request->input('search');
        $query = Product::with('category')->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })->latest();

        if (! empty($searchQuery)) {
            $query->where(function ($sub) use ($searchQuery) {
                $sub->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        $products = $query->get();
        $searchProducts = Product::with('category')->get();
        $categories = Category::orderBy('name')->get();
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
            $cartCount += $item['quantity'];
        }

        return view('shop.category', compact(
            'products',
            'searchProducts',
            'categories',
            'cart',
            'cartTotal',
            'cartCount',
            'searchQuery'
        ))->with('selectedCategorySlug', $slug)
          ->with('selectedCategoryName', $category->name);
    }
}
