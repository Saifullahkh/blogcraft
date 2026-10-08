<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('posts')
            ->when($request->query('q'), fn ($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category(['status' => true])]);
    }

    public function store(CategoryRequest $request, ImageUploadService $images)
    {
        $data = $request->validated();
        $data['image'] = $images->replace(null, $request->file('image'), 'categories');

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category, ImageUploadService $images)
    {
        $data = $request->validated();
        $data['image'] = $images->replace($category->image, $request->file('image'), 'categories');
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category, ImageUploadService $images)
    {
        if ($category->posts()->exists()) {
            return back()->with('error', 'Move or delete posts before deleting this category.');
        }

        $images->delete($category->image);
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
