<?php

namespace App\Http\Controllers;

use App\Models\Brand;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'brand_name');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $brands = Brand::where('brand_name', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('brands.index', compact('brands', 'column', 'direction', 'counter', 'query'));
    }

    public function create(){
        return view('brands.create');
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'brand_name' => [
                'required',
                'string',
                Rule::unique('brands')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $brand = new Brand;
        $brand->brand_name = $request->input('brand_name');
        $saved = $brand->save();

        if ($saved) {
            return redirect()->route('brands.index')->with('success', 'Brand created successfully!');
        } else {
            return back()->with('error', 'Error creating brand');
        }
    }

    public function edit(Brand $brand){
        return view('brands.edit', ['brand' => $brand]);
    }

    public function update(Request $request, Brand $brand){
        $validateData = $request->validate([
            'brand_name' => [
                'required',
                'string',
                Rule::unique('brands')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
        ]);

        $brand = Brand::where('id', $brand->id);
        $brand->slug = "";
        $brand->update($validateData);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    }

    public function delete(Brand $brand){
        return view('brands.delete', ['brand' => $brand]);
    }

    public function remove(Request $request, Brand $brand){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('brands.index')->with('error', 'Delete brand failed due to wrong proceed text value');
        }

        $brand = Brand::find($request->input('brand'));
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully!');
    }
}
