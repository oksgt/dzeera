<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductColorOption;
use App\Models\ProductSizeOption;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Validation\Rule;

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
                    ->join('categories', 'products.category_id', '=', 'categories.id')
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
            return view($this->view_folder.'.success', ['product' => $product]);
        } else {
            return back()->with('error', 'Error creating product');
        }
    }

    public function updateProduct(Request $request, Product $product){
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

        $product = Product::where('id', $product->id);
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
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
                ->where('products.id', $product->id)->first();
        $brands = Brand::all();
        return view($this->view_folder.'.detail', [
            'product' => $product,
            'action'  => 'edit',
            'brands'  => $brands
        ]);
    }

    public function variant(Product $product){
        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
        ->join('categories', 'products.brand_id', '=', 'categories.id')
        ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
        ->where('products.id', $product->id)->first();

        return view($this->view_folder.'.variant', [
            'product' => $product,
        ]);
    }

    public function options(Request $request, Product $product){

        // data product colot
        $ProductColorOption = ProductColorOption::join('products', 'products.id', '=', 'product_color_options.product_id')
        ->select('product_color_options.*', 'products.product_name')
        ->where('product_color_options.product_id', $product->id)->get();

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 100);
        $counter = ($page - 1) * $perPage + 1;

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
        ->join('categories', 'products.brand_id', '=', 'categories.id')
        ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
        ->where('products.id', $product->id)->first();

        // data size option
        $ProductSizeOption = ProductSizeOption::join('products', 'products.id', '=', 'product_size_options.product_id')
        ->select('product_size_options.*', 'products.product_name')
        ->where('product_size_options.product_id', $product->id)->get();

        $page_size = $request->input('page', 1);
        $perPage_size = $request->input('perPage', 100);
        $counter_size = ($page_size - 1) * $perPage_size + 1;

        return view($this->view_folder.'.options', compact('product', 'ProductColorOption', 'counter', 'ProductSizeOption', 'counter_size'));

    }

    public function colorCreate(Request $request, Product $product){
        $product = Product::where('id', $product->id)->first();
        return view($this->view_folder.'.color_create', compact('product'));
    }

    public function colorSave(Request $request){
        $product_id = $request->input('product_id');
        $validator = Validator::make($request->all(), [
            'color_name' => [
                'required',
                'string',
                Rule::unique('product_color_options')->where(function ($query) use ($product_id) {
                    $query->whereNull('deleted_at')->where('product_id', $product_id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = new ProductColorOption;
        $model->color_name = $request->input('color_name');
        $model->product_id = $request->input('product_id');
        $saved = $model->save();
        if ($saved) {
            return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Color option created successfully!');
        } else {
            return back()->with('error', 'Error color option brand');
        }
    }

    public function colorEdit(Product $product, ProductColorOption $ProductColorOption){
        return view($this->view_folder.'.color_edit', ['product' => $product, 'ProductColorOption' => $ProductColorOption]);
    }

    public function colorDelete(Product $product, ProductColorOption $ProductColorOption){
        return view($this->view_folder.'.color_delete', ['product' => $product, 'ProductColorOption' => $ProductColorOption]);
    }

    public function color_update(Request $request){
        $product_id = $request->input('product_id');
        $validateData = $request->validate([
            'color_name' => [
                'required',
                'string',
                Rule::unique('product_color_options')->where(function ($query) use ($product_id) {
                    $query->whereNull('deleted_at')->where('product_id', $product_id);
                }),
            ],
        ]);

        $model = ProductColorOption::where('id', $request->input('id'));
        $model->slug = "";
        $model->update($validateData);
        return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Color name updated successfully!');
    }

    public function color_remove(Request $request){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->back()->with('error', 'Delete color failed due to wrong proceed text value');
        }

        $ProductColorOption = ProductColorOption::find($request->input('id'));
        $ProductColorOption->delete();

        return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Color name deleted successfully!');
    }

    public function sizeCreate(Request $request, Product $product){
        $product = Product::where('id', $product->id)->first();
        return view($this->view_folder.'.size_create', compact('product'));
    }

    public function sizeSave(Request $request){
        $product_id = $request->input('product_id');
        $validator = Validator::make($request->all(), [
            'size' => [
                'required',
                'string',
                Rule::unique('product_size_options')->where(function ($query) use ($product_id) {
                    $query->whereNull('deleted_at')->where('product_id', $product_id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = new ProductSizeOption;
        $model->size = $request->input('size');
        $model->dimension = $request->input('dimension');
        $model->product_id = $request->input('product_id');
        $saved = $model->save();
        if ($saved) {
            return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Size option created successfully!');
        } else {
            return back()->with('error', 'Error size option brand');
        }
    }

    public function sizeEdit(Product $product, ProductSizeOption $ProductSizeOption){
        return view($this->view_folder.'.size_edit',
        ['product' => $product, 'ProductSizeOption' => $ProductSizeOption]);
    }

    public function sizeDelete(Product $product, ProductSizeOption $ProductSizeOption){
        return view($this->view_folder.'.size_delete',
        ['product' => $product, 'ProductSizeOption' => $ProductSizeOption]);
    }

    public function size_update(Request $request){
        $product_id = $request->input('product_id');
        $validateData = $request->validate([
            'size' => [
                'required',
                'string',
                Rule::unique('product_size_options')->where(function ($query) use ($product_id) {
                    $query->whereNull('deleted_at')->where('product_id', $product_id);
                }),
            ],
            'dimension' => []
        ]);
        $model = ProductSizeOption::where('id', $request->input('id'));
        $result = $model->update($validateData);
        return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Size option updated successfully!');
    }

    public function size_remove(Request $request){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->back()->with('error', 'Delete size failed due to wrong proceed text value');
        }

        $product_size_options = ProductSizeOption::find($request->input('id'));
        $product_size_options->delete();

        return redirect()->route('product.options',
         ['product' => $request->input('product_id')])->with('success', 'Size deleted successfully!');
    }
}
