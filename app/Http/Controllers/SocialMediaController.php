<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SocialMediaController extends Controller
{
    public function index()
    {
        // $socialMedia = SocialMedia::all();
        // return view('social-media.index', compact('socialMedia'));
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
            'is_thumbnail' => 'required|boolean',
            'icon' => 'required',
        ]);

        SocialMedia::create($validatedData);

        return redirect()->route('social-media.index')->with('success', 'Social media added successfully.');
    }

    public function detail($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        return view('social-media.detail', compact('socialMedia'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'social_media' => 'required',
            'url' => 'required|url',
            'is_active' => 'required|boolean',
            'is_thumbnail' => 'required|boolean',
            'icon' => 'required',
        ]);

        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->update($validatedData);

        return redirect()->route('social-media.index')->with('success', 'Social media updated successfully.');
    }

    public function delete($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();

        return redirect()->route('social-media.index')->with('success', 'Social media deleted successfully.');
    }
}
