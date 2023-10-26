<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ModalPopup;
use App\Models\VideoEmbed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ModalController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {

        $data = DB::select('select * from app_modal_popup amp where name = "home"');
        return view('modal-popup.index', compact('data'));
    }

    public function add()
    {
        $brand = Brand::all();
        return view('modal-popup.add', compact('brand'));
    }

    public function updateModalPopup(Request $request)
    {
        $is_active = $request->input('is_active');
        $modal_text = $request->input('info_mesasge');

        $id = $request->input('id');

        DB::table('app_modal_popup')
            ->where('id', $id) // Assuming the record you want to update has an ID of 1
            ->update([
                'show' => $is_active,
                'modal_text' => $modal_text,
            ]);

        return redirect()->back()->with('success', 'Data updated successfully');
    }

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
