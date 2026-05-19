<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->get();
        return view("admin.media.index", compact("media"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "image" => "required|image|mimes:jpg,jpeg,png,webp,gif|max:5120",
        ]);

        $file = $request->file("image");
        $filename = $file->getClientOriginalName();
        $storedName = Str::uuid() . "." . $file->getClientOriginalExtension();
        $path = $file->storeAs("media", $storedName, "public");
        $url = Storage::url($path);

        Media::create([
            "filename" => $filename,
            "stored_name" => $storedName,
            "url" => $url,
            "mime_type" => $file->getMimeType(),
            "size" => $file->getSize(),
        ]);

        return redirect()
            ->route("admin.media.index")
            ->with("success", "Image uploaded.");
    }

    public function destroy(Media $media)
    {
        Storage::disk("public")->delete("media/" . $media->stored_name);
        $media->delete();

        return redirect()
            ->route("admin.media.index")
            ->with("success", "Image deleted.");
    }
}
