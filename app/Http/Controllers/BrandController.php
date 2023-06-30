<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('brands.index', compact('brands'));
    }

    public function create(){
        return view('brands.create');
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:255|unique:brands',
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
            'brand_name' => 'required|string|max:255|unique:brands',
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
