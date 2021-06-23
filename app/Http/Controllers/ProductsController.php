<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }
    
    public function cart()
    {
        return view('cart');
    }
    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
    public function remove(Request $request)
    {
      
        if($request->id) {
            $cart = session()->get('cart');
            
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
   
    public function addToCart($id)
    {
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->photo
                    ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function add_product_page()
    {
        return view('register');
    }
    public function addproduct(Request $request)
    {
        // dd($request);

        $image = $request->file('photo');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath,$name);

        
         Product::create([
            'name'=>$request->get('name'),
            'description'=>$request->get('description'),
            'price'=>$request->get('price'),
            'photo'=>$name
            // 'photo'=>$destinationPath
        
        ]);

        
    
    //     $imageName = time().'.'.$request->photo->extension();  
     
    //     $request->photo->storeAs('image', $imageName);
        
    //     $member = new Product();
    //     $member ->name=$request->name;
    //     $member ->description=$request->description;
    //     $member ->photo=$request->$imageName;
    //     $member ->price=$request->price;
    //     $member ->save();
    //    echo "Product Added successfully";

    // $image = $request->file('image');
    // $name = time().'.'.$image->getClientOriginalExtension();
    // $destinationPath = public_path('/images');
    // $image->move($destinationPath,$name);
    // $member = new Product();
    // $member ->name=$request->name;
    //     $member ->description=$request->description;
    //     $member->photo = $timestamp;
    //     $member ->price=$request->price;
    //     $member ->save();
    // // return redirect()->back();
    // echo "Product Added successfully";
        
      
    }
    
}
