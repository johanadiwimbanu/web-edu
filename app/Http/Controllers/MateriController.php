<?php

namespace App\Http\Controllers;

use App\Helpers\SupabaseUploader;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Material::where('status', 'approved')->latest()->paginate(10);
        return view('materi.index', compact('materi'));
    }

    public function show(Material $materi)
    {
        if (!Auth::check()) {
            abort(403, 'Silakan login untuk mengakses detail materi.');
        }

        return view('materi.show', compact('materi'));
    }
    
    public function myMaterials()
    {
        $materi = Material::where('user_id', auth()->id())
                    ->latest()
                    ->paginate(10);

        return view('materi.user', compact('materi'));
    }

    public function create()
    {
        return view('materi.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:article,pdf,video,audio,image',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,mp4,mp3,jpg,jpeg,png|max:20480',
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->type === 'article' ? $request->content : null,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ];

       if ($request->hasFile('file_path')) {
        $uploaded = SupabaseUploader::upload($request->file('file_path'));

        if (!$uploaded) {
            return back()->withErrors(['file_path' => 'Gagal upload file ke Supabase']);
        }

        $data['file_path'] = $uploaded;
    }

        Material::create($data);

        return redirect()->route('materi.user')->with('success', 'Materi berhasil diunggah dan sedang menunggu persetujuan admin.');
    }
}
