<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class PostController extends Controller
{
    private function cleanDriveFilename(string $name): string
    {
        // Decode URL encoded characters (e.g. %20 -> space, etc)
        $decoded = urldecode($name);

        // Fix common Google Drive export substitutions:
        // Converts "Don_t" or "ain_t" patterns back to natural contractions
        $restored = preg_replace('/(\b[a-zA-Z]+)_(t|s|d|ll|ve|re|m)\b/i', '$1\'$2', $decoded);

        return trim($restored);
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|max:102400',
            'title' => 'nullable|string|max:255',
        ]);

        $file = $request->file('media');
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension === 'zip') {
            $zip = new ZipArchive;

            if ($zip->open($file->getRealPath()) === true) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm', 'mov'];
                $count = 0;

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $entryName = $zip->getNameIndex($i);

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

                            $rawFileName = pathinfo($entryName, PATHINFO_FILENAME);
                            $cleanTitle = $this->cleanDriveFilename($rawFileName);
                            $mediaType = in_array($fileExt, ['mp4', 'webm', 'mov']) ? 'video' : 'image';

                            Post::create([
                                'title' => $cleanTitle ?: 'Untitled Meme',
                                'media_path' => $storedPath,
                                'media_type' => $mediaType,
                            ]);

                            $count++;
                        }
                    }
                }

                $zip->close();

                return redirect('/dashboard')->with('success', "Batch import complete! {$count} memes added.");
            }

            return back()->withErrors(['media' => 'Unable to read this ZIP archive.']);
        }

        // Single file upload
        $path = $file->store('memes', 'public');
        $mediaType = in_array($extension, ['mp4', 'webm', 'mov']) ? 'video' : 'image';
        $title = $request->filled('title') 
            ? $request->title 
            : $this->cleanDriveFilename(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        Post::create([
            'title' => $title,
            'media_path' => $path,
            'media_type' => $mediaType,
        ]);

        return redirect('/dashboard')->with('success', 'Meme published successfully!');
    }

    public function batchDelete(Request $request)
    {
        $request->validate([
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id',
        ]);

        $posts = Post::whereIn('id', $request->post_ids)->get();

        foreach ($posts as $post) {
            Storage::disk('public')->delete($post->media_path);
            $post->delete();
        }

        return redirect('/dashboard')->with('success', count($posts) . ' meme(s) deleted successfully!');
    }
}