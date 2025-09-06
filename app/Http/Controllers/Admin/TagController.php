<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tag::with('category')->latest();
        $category = null;

        if ($request->has('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $tags = $query->paginate(15)->withQueryString();

        return view('admin.tags.index', compact('tags', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.tags.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'category_id' => 'required|exists:categories,id',
            'allowed_jurusan' => 'nullable|array',
            'allowed_jurusan.*' => 'in:RPL,TKJ,DKV', // Pastikan valuenya valid
        ]);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.tags.edit', compact('tag', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'category_id' => 'required|exists:categories,id',
            'allowed_jurusan' => 'nullable|array',
            'allowed_jurusan.*' => 'in:RPL,TKJ,DKV',
        ]);
        
        // Jika tidak ada jurusan yang dipilih, simpan sebagai null
        $validated['allowed_jurusan'] = $request->has('allowed_jurusan') ? $validated['allowed_jurusan'] : null;

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Optional: Add a check if the tag is associated with any projects
        if ($tag->projects()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus tag yang masih digunakan oleh proyek.');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}

