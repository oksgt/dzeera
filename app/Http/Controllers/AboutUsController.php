<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Brand;
// use App\Models\VideoEmbed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AboutUsController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $selectedBrandId = $request->input('brand_id');
        $brands = Brand::all();
        $text = '';
        if ($selectedBrandId) {
            $aboutUs = AboutUs::where('brand_id', $selectedBrandId)->first();
            $text = $aboutUs->text;
        }
        return view('about-us.index', compact('brands', 'selectedBrandId', 'text'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'about-us-text' => 'required',
        ]);

        $brandId = $request->input('brand_id');
        $aboutUsText = $request->input('about-us-text');

        try {
            $aboutUs = DB::table('about_us')->updateOrInsert(
                ['brand_id' => $brandId],
                ['text' => $aboutUsText]
            );

            return redirect()->route('about-us.index')->with('success', 'About Us text saved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('about-us.index')->with('error', 'Failed to save About Us text. '.$e->getMessage());
        }
    }

    // public function add()
    // {
    //     $brand = Brand::all();
    //     return view('video-embed.add', compact('brand'));
    // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required',
    //         'url' => 'required|url',
    //         'is_active' => 'required|boolean',
    //         'brand_id' => 'required|not_in:default',
    //     ],[
    //         'brand_id.not_in' => "Please choose brand"
    //     ]);

    //     VideoEmbed::create($validatedData);

    //     return redirect()->route('video-embedded.index')->with('success', 'Video embedded successfully.');
    // }

    // public function detail(VideoEmbed $videoEmbed)
    // {
    //     $brand = Brand::all();
    //     $videoEmbed = VideoEmbed::findOrFail($videoEmbed->id);
    //     return view('video-embed.detail', compact('videoEmbed', 'brand'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required',
    //         'url' => 'required|url',
    //         'is_active' => 'required|boolean',
    //         'brand_id' => 'required|not_in:default',
    //     ],[
    //         'brand_id.not_in' => "Please choose brand"
    //     ]);

    //     $VideoEmbed = VideoEmbed::findOrFail($id);
    //     $VideoEmbed->update($validatedData);

    //     return redirect()->route('video-embedded.index')->with('success', 'Update video embedded successfully.');
    // }

    // public function delete(VideoEmbed $videoEmbed){
    //     return view('video-embed.delete', ['VideoEmbed' => $videoEmbed]);
    // }

    // public function remove(Request $request, VideoEmbed $VideoEmbed){
    //     $action_ = 'delete';
    //     if($action_ !== $request->input('action_text')){
    //         return redirect()->route('video-embedded.index')->with('error', 'Delete video embedded failed due to wrong proceed text value');
    //     }
    //     $VideoEmbed = VideoEmbed::find($request->input('videoEmbed'));
    //     $VideoEmbed->delete();
    //     return redirect()->route('video-embedded.index')->with('success', 'Video embedded deleted successfully!');
    // }
}
