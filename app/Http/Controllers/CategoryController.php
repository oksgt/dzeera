<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $view_folder = "categories";
    private $perPage = 10;
    private $row_index = 0;

    public function index(Request $request){
        $column    = $request->input('sort', 'brand_name');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $category = Category::join('brands', 'categories.brand_id', '=', 'brands.id')
                    ->select('categories.*', 'brands.brand_name as brand_name')
                    ->orWhere(function ($qry) use ($query) {
                        $qry->where('categories.category_name', 'LIKE', "%$query%")
                        ->where('brands.brand_name', 'LIKE', "%$query%");
                    })
                    ->whereNull('brands.deleted_at')
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view($this->view_folder.'.index', compact('category', 'column', 'direction', 'counter', 'query'));
    }

    public function create(){
        $brands = Brand::all();
        return view($this->view_folder.'.create', compact('brands'));
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|not_in:default',
            'category_name' => 'required|string|max:255',
            'highlight' => 'required',
            'file' => 'file|mimes:jpeg,png|max:2048',
        ],[
            'brand_id.not_in' => "Please choose brand"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $filePath = $file->move('images/category/', $filename);

        $category = new Category;
        $category->brand_id      = $request->input('brand_id');
        $category->category_name = $request->input('category_name');
        $category->image         = $filename;
        $saved = $category->save();

        if ($saved) {
            return redirect()->route('category.index')->with('success', 'Category created successfully!');
        } else {
            return back()->with('error', 'Error creating category');
        }
    }

    public function edit(Category $category){
        $brands = Brand::all();
        return view($this->view_folder.'.edit', ['brands' => $brands, 'category' => $category]);
    }

    public function update(Request $request, Category $category){
        // dd($request);
        $validateData = $request->validate([
            'brand_id' => 'required|not_in:default',
            'category_name' => 'required|string|max:255',
            'highlight' => 'required',
        ],[
            'brand_id.not_in' => "Please choose brand"
        ]);

        $category = Category::where('id', $category->id);
        if(!empty($request->file('file'))){
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->move('images/category/', $filename);
            $validateData['image'] = $filename;
        }
        $category->update($validateData);

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function delete(Category $category){
        $brands = Brand::where('id', $category->brand_id)->first();
        return view($this->view_folder.'.delete', ['brand' => $brands, 'category' => $category]);
    }

    public function remove(Request $request, Category $category){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('category.index')->with('error', 'Delete category failed due to wrong proceed text value');
        }

        $category = Category::find($request->input('category'));
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }

    public function listByBrand($brand_id){
        $category = Category::where('brand_id', $brand_id)->get();
        return response()->json($category);
    }

}
