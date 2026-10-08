<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $files = collect(Storage::disk('public')->allFiles())
            ->filter(fn (string $path) => preg_match('/\.(jpe?g|png|webp|gif|svg|ico)$/i', $path))
            ->map(fn (string $path) => [
                'path' => $path,
                'url' => asset('storage/'.ltrim(str_replace('\\', '/', $path), '/')),
                'size' => Storage::disk('public')->size($path),
                'updated' => Storage::disk('public')->lastModified($path),
            ])
            ->sortByDesc('updated')
            ->values();

        return view('admin.media.index', compact('files'));
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate(['path' => ['required', 'string']]);
        $path = $validated['path'];

        abort_if(Str::contains($path, ['..', '\\']), 422);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return back()->with('success', 'Media file deleted.');
    }
}
