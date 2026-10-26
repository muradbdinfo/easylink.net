<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /** Image upload endpoint for the rich text (TinyMCE) editor. */
    public function image(Request $request): JsonResponse
    {
        $request->validate(['file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120']);

        $path = $request->file('file')->store('editor', 'public');

        return response()->json(['location' => Storage::disk('public')->url($path)]);
    }
}
