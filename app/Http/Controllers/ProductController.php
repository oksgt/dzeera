<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductColorOption;
use App\Models\ProductImage;
use App\Models\ProductSizeOption;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        return view($this->view_folder . '.index', compact('products', 'column', 'direction', 'counter', 'query'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view($this->view_folder . '.create', compact('brands'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|not_in:0',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|not_in:0',
        ], [
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
        if ($exist) {
            return back()->with('error', 'Product already exist')->withInput();
        }

        $product = new Product();
        $product->product_type  = $request->input('product_type');
        $product->brand_id      = $request->input('brand_id');
        $product->category_id   = $request->input('category_id');
        $product->product_sku   = $request->input('product_sku');
        $product->product_name  = $request->input('product_name');
        $product->product_desc  = $request->input('product_desc');
        $product->product_status = $request->input('product_status');
        $product->product_availability  = $request->input('product_availability');
        $saved = $product->save();

        if ($saved) {
            return view($this->view_folder . '.success', ['product' => $product]);
        } else {
            return back()->with('error', 'Error creating product');
        }
    }

    public function updateProduct(Request $request, Product $product)
    {
        try {
            $brand_id = $request->input('brand_id');
            $category_id = $request->input('category_id');
            $product_name = $request->input('product_name');
            $sku = $request->input('product_sku');
            $productId = $product->id;
            $rules = [
                'brand_id' => [
                    'required',
                    'not_in:0',
                ],
                'category_id' => [
                    'required',
                    'not_in:0',
                ],
                'product_name' => [
                    'required',
                    Rule::unique('products')
                        ->where('category_id', $category_id)
                        ->where('brand_id', $brand_id)
                        ->where(function ($query) use ($productId) {
                            if ($productId) {
                                $query->where('id', '!=', $productId);
                            }
                        }),
                ],
            ];

            $validateData = $request->validate($rules);

            $product = Product::where('id', $product->id);
            if ($product) {
                $updated = $product->update([
                    'product_type'  => $request->input('product_type'),
                    'brand_id'      => $request->input('brand_id'),
                    'category_id'   => $request->input('category_id'),
                    'product_sku'   => $request->input('product_sku'),
                    'product_name'  => $request->input('product_name'),
                    'product_desc'  => $request->input('product_desc'),
                    'product_status' => $request->input('product_status'),
                    'product_availability'  => $request->input('product_availability'),
                    'rating'         => $request->input('rating'),
                ]);
                if ($updated) {
                    return view($this->view_folder . '.success_update', ['product_name' => $request->input('product_name')]);
                } else {
                    return back()->with('error', 'Error updating product');
                }
            } else {
                return back()->with('error', 'Error updating product');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function test()
    {
        return view($this->view_folder . '.success');
    }

    public function detail(Product $product)
    {
        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $product->id)->first();

        $product_image = ProductImage::where('product_id', $product->id)
            ->where('is_thumbnail', 1)->first();

        $brands = Brand::all();
        return view($this->view_folder . '.detail', [
            'product' => $product,
            'action'  => 'edit',
            'brands'  => $brands,
            'product_image' => ($product_image) ? $product_image->image : null,
        ]);
    }

    public function delete(Product $product)
    {
        return view($this->view_folder . '.delete', ['product' => $product]);
    }

    public function remove(Request $request, Product $product)
    {
        $action_ = 'delete';
        if ($action_ !== $request->input('action_text')) {
            return redirect()->route('product.index')->with('error', 'Delete product failed due to wrong proceed text value');
        }

        $product = Product::find($request->input('product'));
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    public function variant(Request $request, Product $product)
    {
        $productId = $product->id;

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $productId)->first();

        $column = $request->input('sort', 'color_name');
        $direction = $request->input('dir', 'asc');
        $query = $request->input('q', '');

        $ProductOption = ProductOption::join('products as p', 'p.id', '=', 'product_options.product_id')
            ->join('product_color_options as pco', function ($join) {
                $join->on('pco.id', '=', 'product_options.color')
                    ->on('pco.product_id', '=', 'p.id');
            })
            ->join('product_size_options as pso', function ($join) {
                $join->on('pso.id', '=', 'product_options.size_opt_id')
                    ->on('pso.product_id', '=', 'p.id');
            })
            ->select('product_options.*', 'p.product_name', 'pso.size', 'pso.dimension', 'pco.color_name')

            ->orWhere(function ($qry) use ($query) {
                // $qry->where('categories.category_name', 'LIKE', "%$query%")
                // ->where('brands.brand_name', 'LIKE', "%$query%");

                $qry->where('p.product_name', 'LIKE', "%$query%")
                ->orWhere('pso.size', 'LIKE', "%$query%")
                ->orWhere('pco.color_name', 'LIKE', "%$query%");
            })
            ->where('product_options.product_id', $productId)
            ->whereNull('p.deleted_at')
            ->orderBy($column, $direction)
            ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $counter = ($page - 1) * $perPage + 1;

        return view($this->view_folder . '.variant', compact('ProductOption', 'product', 'column', 'direction', 'counter', 'query'));
    }

    public function variant_add(Product $product)
    {
        $productId = $product->id;

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $productId)->first();

        $ProductColorOption = ProductColorOption::join('products', 'products.id', '=', 'product_color_options.product_id')
            ->select('product_color_options.*', 'products.product_name')
            ->where('product_color_options.product_id', $productId)->get();

        $ProductSizeOption = ProductSizeOption::join('products', 'products.id', '=', 'product_size_options.product_id')
            ->select('product_size_options.*', 'products.product_name')
            ->where('product_size_options.product_id', $productId)->get();

        return view($this->view_folder . '.variant_add', [
            'product' => $product,
            'ProductColorOption' => $ProductColorOption,
            'ProductSizeOption'  => $ProductSizeOption
        ]);
    }

    public function variant_save(Request $request,  Product $product)
    {
        $validatedData = $request->validate([
            'color' => 'required|not_in:0',
            'size_opt_id' => 'required|not_in:0',
            'stock' => 'required|integer',
            'weight' => 'required|numeric',
            'base_price' => 'required',
            'disc' => 'required',
            'price' => 'required',
            'option_availability' => 'required',
        ]);

        if (!isset($validatedData)) {
            return back()->withInput();
        }

        $count = DB::table('product_options')
            ->where('product_id', $product->id)
            ->where('color', $validatedData['color'])
            ->where('size_opt_id', $validatedData['size_opt_id'])
            ->whereNull('deleted_at')
            ->count();

        if ($count > 0) {
            return back()->withInput()->with('error', 'This option is already exist.')->withErrors([
                'color' => 'Already exist',
                'size_opt_id' => 'Already exist',
            ]);;
        }

        $ProductOption = new ProductOption([
            'product_id' => $product->id,
            'color' => $validatedData['color'],
            'size_opt_id' => $validatedData['size_opt_id'],
            'stock' => $validatedData['stock'],
            'weight' => $validatedData['weight'],
            'base_price' => (int) str_replace(".", "", $validatedData['base_price']),
            'disc' => (int) str_replace(".", "", $validatedData['disc']),
            'price' => (int) str_replace(".", "", $validatedData['price']),
            'option_availability' => $validatedData['option_availability'],
        ]);

        $ProductOption->save();
        return redirect()->route('product.variant', ['product' => $product])->with('success', 'Product option saved successfully.');
    }

    public function variant_edit(Product $product, ProductOption $ProductOption)
    {

        $productId = $product->id;

        $ProductColorOption = ProductColorOption::join('products', 'products.id', '=', 'product_color_options.product_id')
            ->select('product_color_options.*', 'products.product_name')
            ->where('product_color_options.product_id', $productId)->get();

        $ProductSizeOption = ProductSizeOption::join('products', 'products.id', '=', 'product_size_options.product_id')
            ->select('product_size_options.*', 'products.product_name')
            ->where('product_size_options.product_id', $productId)->get();

        $ProductOption = ProductOption::where('id', $ProductOption->id)->first();

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $productId)->first();

        $ProductOption->base_price  = intval($ProductOption->base_price);
        $ProductOption->disc        = intval($ProductOption->disc);
        $ProductOption->price       = intval($ProductOption->price);

        return view($this->view_folder . '.variant_edit', [
            'product'            => $product,
            'ProductOption'      => $ProductOption,
            'ProductColorOption' => $ProductColorOption,
            'ProductSizeOption'  => $ProductSizeOption
        ]);


    }

    public function variant_update(Request $request, ProductOption $ProductOption)
    {

        $model = ProductOption::findOrFail($ProductOption->id);

        $requestData  = $request->all();
        $originalData = $model->toArray();

        $keysToRemove = ['_token', '_method'];
        foreach ($keysToRemove as $key) {
            unset($requestData[$key]);
        }

        $keysToRemove = ['id', 'created_at', 'updated_at', 'deleted_at'];
        foreach ($keysToRemove as $key) {
            unset($originalData[$key]);
        }

        $validator = Validator::make($requestData, [
            'color' => 'required|not_in:0',
            'size_opt_id' => 'required|not_in:0',
            'stock' => 'required|integer',
            'weight' => 'required|numeric',
            'base_price' => 'required',
            'disc' => 'required',
            'price' => 'required',
            'option_availability' => 'required',
        ]);

        $validator->sometimes('color', 'required|not_in:0,', function ($input) use ($originalData) {
            return $input['color'] !== $originalData['color'];
        });

        $validator->sometimes('size_opt_id', 'required|not_in:0', function ($input) use ($originalData) {
            return $input['size_opt_id'] !== $originalData['size_opt_id'];
        });

        $validator->sometimes('stock', 'required|integer', function ($input) use ($originalData) {
            return $input['stock'] !== $originalData['stock'];
        });

        $validator->sometimes('weight', 'required|numeric', function ($input) use ($originalData) {
            return $input['weight'] !== $originalData['weight'];
        });

        $validator->sometimes('base_price', 'required|numeric', function ($input) use ($originalData) {
            return $input['base_price'] !== $originalData['base_price'];
        });

        $validator->sometimes('disc', 'required|numeric', function ($input) use ($originalData) {
            return $input['disc'] !== $originalData['disc'];
        });

        $validator->sometimes('price', 'required|numeric', function ($input) use ($originalData) {
            return $input['price'] !== $originalData['price'];
        });

        $validator->sometimes('option_availability', 'required', function ($input) use ($originalData) {
            return $input['option_availability'] !== $originalData['option_availability'];
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($requestData == $originalData) {
            return redirect()->route('product.variant', ['product' => $ProductOption->product_id]);
        }

        if ($requestData['color'] == $originalData['color'] || $requestData['size_opt_id'] == $originalData['size_opt_id']) {
            $existing_data = ProductOption::where([
                'product_id'  => $ProductOption->product_id,
                'color'       => $ProductOption->color,
                'size_opt_id' => $ProductOption->size_opt_id,
            ])->first();

            if ($existing_data) {

                $errorMessages = 'A product option with the same size already exists.';

                if (!empty($errorMessages)) {
                    return redirect()->back()->withErrors([
                        'color' => ' ',
                        'size_opt_id' => ' ',
                    ])->withInput()->with('error', 'A product option with the same product and color already exists.');;
                }
            }
        }

        // update the model with the input data
        $model->fill($requestData);
        $model->save();
        return redirect()->route('product.variant', ['product' => $ProductOption->product_id])->with('success', 'Product option updated successfully.');
    }

    public function variant_delete(ProductOption $ProductOption)
    {
        $ProductOptionId = $ProductOption->id;

        $ProductOption = ProductOption::join('products as p', 'p.id', '=', 'product_options.product_id')
            ->join('product_color_options as pco', function ($join) {
                $join->on('pco.id', '=', 'product_options.color')
                    ->on('pco.product_id', '=', 'p.id');
            })
            ->join('product_size_options as pso', function ($join) {
                $join->on('pso.id', '=', 'product_options.size_opt_id')
                    ->on('pso.product_id', '=', 'p.id');
            })
            ->select('product_options.*', 'p.product_name', 'pso.size', 'pso.dimension', 'pco.color_name')
            ->where('product_options.id', $ProductOptionId)
            ->first();

        return view($this->view_folder . '.variant_delete', ['ProductOption' => $ProductOption]);
    }

    public function variant_remove(Request $request)
    {
        $action_ = 'delete';
        if ($action_ !== $request->input('action_text')) {
            return redirect()->back()->with('error', 'Delete variant option failed due to wrong proceed text value')->withInput($request->all());
        }

        $ProductOption = ProductOption::find($request->input('id'));
        $ProductOption->delete();

        return redirect()->route('product.variant', ['product' => $ProductOption->product_id])->with('success', 'Product option deleted successfully.');
    }

    public function options(Request $request, Product $product)
    {
        $productId = $product->id;
        // data product color
        $ProductColorOption = ProductColorOption::join('products', 'products.id', '=', 'product_color_options.product_id')
            ->select('product_color_options.*', 'products.product_name')
            ->where('product_color_options.product_id', $productId)->get();

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 100);
        $counter = ($page - 1) * $perPage + 1;

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $productId)->first();

        // data size option
        $ProductSizeOption = ProductSizeOption::join('products', 'products.id', '=', 'product_size_options.product_id')
            ->select('product_size_options.*', 'products.product_name')
            ->where('product_size_options.product_id', $productId)->get();

        $page_size = $request->input('page', 1);
        $perPage_size = $request->input('perPage', 100);
        $counter_size = ($page_size - 1) * $perPage_size + 1;
        return view($this->view_folder . '.options', compact('product', 'ProductColorOption', 'counter', 'ProductSizeOption', 'counter_size'));
    }

    public function colorCreate(Request $request, Product $product)
    {
        $product = Product::where('id', $product->id)->first();
        return view($this->view_folder . '.color_create', compact('product'));
    }

    public function colorSave(Request $request)
    {
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

    public function colorEdit(Product $product, ProductColorOption $ProductColorOption)
    {
        return view($this->view_folder . '.color_edit', ['product' => $product, 'ProductColorOption' => $ProductColorOption]);
    }

    public function colorDelete(Product $product, ProductColorOption $ProductColorOption)
    {
        return view($this->view_folder . '.color_delete', ['product' => $product, 'ProductColorOption' => $ProductColorOption]);
    }

    public function color_update(Request $request)
    {
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

    public function color_remove(Request $request)
    {
        $action_ = 'delete';
        if ($action_ !== $request->input('action_text')) {
            return redirect()->back()->with('error', 'Delete color failed due to wrong proceed text value');
        }

        $ProductColorOption = ProductColorOption::find($request->input('id'));
        $ProductColorOption->delete();

        return redirect()->route('product.options', ['product' => $request->input('product_id')])->with('success', 'Color name deleted successfully!');
    }

    public function sizeCreate(Request $request, Product $product)
    {
        $product = Product::where('id', $product->id)->first();
        return view($this->view_folder . '.size_create', compact('product'));
    }

    public function sizeSave(Request $request)
    {
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

    public function sizeEdit(Product $product, ProductSizeOption $ProductSizeOption)
    {
        return view(
            $this->view_folder . '.size_edit',
            ['product' => $product, 'ProductSizeOption' => $ProductSizeOption]
        );
    }

    public function sizeDelete(Product $product, ProductSizeOption $ProductSizeOption)
    {
        return view(
            $this->view_folder . '.size_delete',
            ['product' => $product, 'ProductSizeOption' => $ProductSizeOption]
        );
    }

    public function size_update(Request $request)
    {
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

    public function size_remove(Request $request)
    {
        $action_ = 'delete';
        if ($action_ !== $request->input('action_text')) {
            return redirect()->back()->with('error', 'Delete size failed due to wrong proceed text value');
        }

        $product_size_options = ProductSizeOption::find($request->input('id'));
        $product_size_options->delete();

        return redirect()->route(
            'product.options',
            ['product' => $request->input('product_id')]
        )->with('success', 'Size deleted successfully!');
    }

    public function images(Product $product)
    {
        $productId = $product->id;

        $product = Product::join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'brands.brand_name as brand_name', 'categories.category_name as category_name')
            ->where('products.id', $productId)->first();

        $product_image = ProductImage::where('product_id', $productId)->get();

        return view($this->view_folder . '.images', compact('product', 'product_image'));
    }


    public function images_upload(Request $request)
    {
        $validateData = $request->validate([
            'file' => 'required|file|mimes:jpeg,png|max:2048',
        ]);

        $file = $request->file('file');
        $product_id = $request->input('product_id');
        $is_thumbnail = $request->input('is_thumbnail') ?? false;

        $product = Product::find($product_id)->first();

        $filename = $product->slug . '_' . $product->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        $fileType = $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/img_product', $filename);

        $productImage = new ProductImage([
            'product_id' => $product_id,
            'file_name' => $filename,
            'file_type' => $fileType,
            'file_path' => $filePath,
        ]);

        $productImage->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function set_thumbnail(Request $request)
    {
        // Get the ID of the image to set as the thumbnail
        $imageId = $request->input('image_id');

        // Find the product image in the database
        $productImage = ProductImage::findOrFail($imageId);

        // Set the is_thumbnail column for the selected image to 1
        $productImage->is_thumbnail = 1;
        $productImage->save();

        // Set the is_thumbnail column for all other images of the product to 0
        ProductImage::where('product_id', $productImage->product_id)
            ->where('id', '<>', $productImage->id)
            ->update(['is_thumbnail' => 0]);

        // Return a success response
        return redirect()->back()->with('success', 'Set thumbnail success.');
    }

    public function deleteImage(Request $request)
    {
        $imageId = $request->input('image_id');
        // Find the product image in the database
        $productImage = ProductImage::findOrFail($imageId);

        // Delete the associated uploaded file
        File::delete(asset('storage/img_product/'.$productImage->file_name));

        // Delete the product image from the database
        $productImage->delete();

        // Return a success response
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
