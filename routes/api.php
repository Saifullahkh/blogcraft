use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Http\Request;

Route::get('/chatbot/articles', function (Request $request) {

    $search = $request->query('search', '');

    $posts = Post::query()
        ->where('status', 'published')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->limit(10)
        ->get(['title', 'slug', 'excerpt']);

    return response()->json([
        'success' => true,
        'articles' => $posts
    ]);
});