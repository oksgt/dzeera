<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SocialMediaController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $column = $request->input('sort', 'social_media');
        $direction = $request->input('dir', 'asc');

        $query = $request->input('q', '');

        $socialMedia = SocialMedia::where('social_media', 'LIKE', "%$query%")
                    ->orderBy($column, $direction)
                    ->paginate($this->perPage);

        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', $this->perPage);
        $counter = ($page - 1) * $perPage + 1;

        return view('social-media.index', compact('socialMedia', 'column', 'direction', 'counter', 'query'));
    }

    public function add()
    {
        return view('social-media.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'social_media' => 'required',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'icon' => 'required',
        ]);

        SocialMedia::create($validatedData);

        return redirect()->route('social-media.index')->with('success', 'Social media added successfully.');
    }

    public function detail(SocialMedia $socialMedia)
    {
        $socialMedia = SocialMedia::findOrFail($socialMedia->id);
        return view('social-media.detail', compact('socialMedia'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'social_media' => 'required',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'icon' => 'required',
        ]);

        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->update($validatedData);

        return redirect()->route('social-media.index')->with('success', 'Social media updated successfully.');
    }

    public function delete(SocialMedia $socialMedia){
        return view('social-media.delete', ['socialMedia' => $socialMedia]);
    }

    public function remove(Request $request, SocialMedia $socialMedia){
        $action_ = 'delete';
        if($action_ !== $request->input('action_text')){
            return redirect()->route('social-media.index')->with('error', 'Delete social media failed due to wrong proceed text value');
        }
        $socialMedia = SocialMedia::find($request->input('socialMedia'));
        $socialMedia->delete();
        return redirect()->route('social-media.index')->with('success', 'Social media deleted successfully!');
    }
}
