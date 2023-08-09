<?php

namespace App\Http\Controllers;

use App\Models\BannerImage;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BannerImageController extends Controller
{

    private $perPage = 10;

    public function index(Request $request)
    {
        $BannerImage = BannerImage::all();
        return view('banner-image.index', compact('BannerImage'));
    }

    public function images_upload(Request $request)
    {
        $validateData = $request->validate([
            'file' => 'required|file|mimes:jpeg,png|max:2048',
        ]);

        $file = $request->file('file');

        $filename = time() . '.' . $file->getClientOriginalExtension();

        $fileType = $file->getClientOriginalExtension();
        $filePath = $file->move('banner', $filename);

        $BannerImage = new BannerImage([
            'file_name' => $filename,
            'file_type' => $fileType,
            'file_path' => $filePath,
        ]);

        $BannerImage->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function deleteImage(Request $request)
    {
        $imageId = $request->input('image_id');
        // Find the product image in the database
        $BannerImage = BannerImage::findOrFail($imageId);

        // Delete the associated uploaded file
        File::delete(asset('banner/'.$BannerImage->file_name));

        // Delete the product image from the database
        $BannerImage->delete();

        // Return a success response
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    // public function create(){
    //     return view('brands.create');
    // }

    // public function save(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'brand_name' => [
    //             'required',
    //             'string',
    //             Rule::unique('brands')->where(function ($query) {
    //                 $query->whereNull('deleted_at');
    //             }),
    //         ],
    //     ]);

    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }

    //     $brand = new Brand;
    //     $brand->brand_name = $request->input('brand_name');
    //     $saved = $brand->save();

    //     if ($saved) {
    //         return redirect()->route('brands.index')->with('success', 'Brand created successfully!');
    //     } else {
    //         return back()->with('error', 'Error creating brand');
    //     }
    // }

    // public function edit(Brand $brand){
    //     return view('brands.edit', ['brand' => $brand]);
    // }

    // public function update(Request $request, Brand $brand){
    //     $validateData = $request->validate([
    //         'brand_name' => [
    //             'required',
    //             'string',
    //             Rule::unique('brands')->where(function ($query) {
    //                 $query->whereNull('deleted_at');
    //             })->ignore($brand->id),
    //         ],
    //     ]);

    //     $brand = Brand::where('id', $brand->id);
    //     $brand->slug = "";
    //     $brand->update($validateData);

    //     return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    // }

    // public function delete(Brand $brand){
    //     return view('brands.delete', ['brand' => $brand]);
    // }

    // public function remove(Request $request, Brand $brand){
    //     $action_ = 'delete';
    //     if($action_ !== $request->input('action_text')){
    //         return redirect()->route('brands.index')->with('error', 'Delete brand failed due to wrong proceed text value');
    //     }

    //     $brand = Brand::find($request->input('brand'));
    //     $brand->delete();
    //     return redirect()->route('brands.index')->with('success', 'Brand deleted successfully!');
    // }
}
