<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\VideoEmbed;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VideoEmbedController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'title');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $VideoEmbed = VideoEmbed::
                    join('brands', 'brands.id', '=', 'video_embeds.brand_id')
                    ->select('video_embeds.*', 'brands.brand_name')
                    ->where('title', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('video-embed.index', compact('VideoEmbed', 'column', 'direction', 'counter', 'query'));
    }

    public function add()
    {
        $brand = Brand::all();
        return view('video-embed.add', compact('brand'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'brand_id' => 'required|not_in:default',
        ],[
            'brand_id.not_in' => "Please choose brand"
        ]);

        VideoEmbed::create($validatedData);

        return redirect()->route('video-embedded.index')->with('success', 'Video embedded successfully.');
    }

    public function detail(VideoEmbed $videoEmbed)
    {
        $brand = Brand::all();
        $videoEmbed = VideoEmbed::findOrFail($videoEmbed->id);
        return view('video-embed.detail', compact('videoEmbed', 'brand'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'brand_id' => 'required|not_in:default',
        ],[
            'brand_id.not_in' => "Please choose brand"
        ]);

        $VideoEmbed = VideoEmbed::findOrFail($id);
        $VideoEmbed->update($validatedData);

        return redirect()->route('video-embedded.index')->with('success', 'Update video embedded successfully.');
    }

    public function delete(VideoEmbed $videoEmbed){
        return view('video-embed.delete', ['VideoEmbed' => $videoEmbed]);
    }

    public function remove(Request $request, VideoEmbed $VideoEmbed){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('video-embedded.index')->with('error', 'Delete video embedded failed due to wrong proceed text value');
        }
        $VideoEmbed = VideoEmbed::find($request->input('videoEmbed'));
        $VideoEmbed->delete();
        return redirect()->route('video-embedded.index')->with('success', 'Video embedded deleted successfully!');
    }
}
