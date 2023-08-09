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

}
