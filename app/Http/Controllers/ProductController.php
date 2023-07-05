<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductController extends Controller
{
    private $view_folder = "products";
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'product_name');
        $direction = $request->input('dir', 'asc');
        $query = $request->input('q', '');
        $products = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                    ->join('categories', 'products.brand_id', '=', 'categories.id')
                    ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
                    ->where('category_name', 'LIKE', "%$query%")
                    ->orWhere('brand_name', 'LIKE', "%$query%")
                    ->orWhere('product_name', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view($this->view_folder.'.index', compact('products', 'column', 'direction', 'counter', 'query'));
    }

    public function create(){
        $brands = Brand::all();
        return view($this->view_folder.'.create', compact('brands'));
    }

    public function save(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|not_in:0',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|not_in:0',
        ],[
            'brand_id.not_in' => "Please choose brand",
            'category_id.not_in' => "Please choose category"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //check existing product name, brand and category
        $brand_id = $request->input('brand_id');
        $category_id = $request->input('category_id');
        $product_name = $request->input('product_name');
        $sku = $request->input('product_sku');
        $exist = Product::where(function ($query) use ($brand_id, $category_id, $product_name, $sku) {
            $query->where('brand_id', $brand_id)
                  ->where('category_id', $category_id)
                  ->where('product_name', $product_name)
                  ->where('deleted_at', null);
        })->exists();
        if($exist){
            return back()->with('error', 'Product already exist')->withInput();
        }


        $product = new Product();
        $product->product_type  = $request->input('product_type');
        $product->brand_id      = $request->input('brand_id');
        $product->category_id   = $request->input('category_id');
        $product->product_sku   = $request->input('product_sku');
        $product->product_name  = $request->input('product_name');
        $product->product_desc  = $request->input('product_desc');
        $product->product_status= $request->input('product_status');
        $product->product_availability  = $request->input('product_availability');
        $saved = $product->save();

        if ($saved) {
            // return redirect()->route('product.index')->with('success', 'Product created successfully!');
            return view($this->view_folder.'.success', ['product' => $product]);
        } else {
            return back()->with('error', 'Error creating product');
        }
    }

    public function test(){
        return view($this->view_folder.'.success');
    }

    public function detail(Product $product){
        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('categories', 'products.brand_id', '=', 'categories.id')
                ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
                ->where('products.id', $product->id)->first();

        return view($this->view_folder.'.detail', ['product' => $product]);
    }

}
