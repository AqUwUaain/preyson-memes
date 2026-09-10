<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,mov,zip|max:102400',
            'title' => 'nullable|string|max:255',
        ]);

        $file = $request->file('media');
        $extension = strtolower($file->getClientOriginalExtension());

        // Handle ZIP Uploads
        if ($extension === 'zip') {
            $zip = new ZipArchive;

            if ($zip->open($file->getRealPath()) === true) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'mov'];
                $count = 0;

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entryName = $zip->getNameIndex($i);

                    // Skip hidden system files and subfolders
                    if (str_starts_with($entryName, '__MACOSX/') || str_ends_with($entryName, '/') || str_starts_with(basename($entryName), '.')) {
                        continue;
                    }

                    $fileExt = strtolower(pathinfo($entryName, PATHINFO_EXTENSION));

                    if (in_array($fileExt, $allowedExtensions)) {
                        $stream = $zip->getStream($entryName);
                        if ($stream) {
                            $contents = stream_get_contents($stream);
                            fclose($stream);

                            $storedPath = 'memes/' . Str::random(40) . '.' . $fileExt;
                            Storage::disk('public')->put($storedPath, $contents);

                            // Exact filename without the extension
                            $exactFileName = pathinfo($entryName, PATHINFO_FILENAME);
                            $mediaType = in_array($fileExt, ['mp4', 'webm', 'mov']) ? 'video' : 'image';

                            Post::create([
                                'title' => $exactFileName,
                                'media_path' => $storedPath,
                                'media_type' => $mediaType,
                            ]);

                            $count++;
                        }
                    }
                }

                $zip->close();

                return redirect('/dashboard')->with('success', "Batch import complete! Added {$count} memes with exact file titles.");
            }

            return back()->withErrors(['media' => 'Unable to read this ZIP archive.']);
        }

        // Handle Single File Upload
        $path = $file->store('memes', 'public');
        $mediaType = in_array($extension, ['mp4', 'webm', 'mov']) ? 'video' : 'image';
        $title = $request->filled('title') 
            ? $request->title 
            : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        Post::create([
            'title' => $title,
            'media_path' => $path,
            'media_type' => $mediaType,
        ]);

        return redirect('/dashboard')->with('success', 'Meme published successfully!');
    }
}