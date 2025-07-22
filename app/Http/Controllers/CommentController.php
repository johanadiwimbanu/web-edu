<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Material;

class CommentController extends Controller
{
    
    public function store(Request $request, Material $material)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $material->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}

