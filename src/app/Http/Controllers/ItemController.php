<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;



class ItemController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->get('search');

        if ($search) {
            session(['search' => $search]);


            $items = Item::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $items = Item::all();
        }



        if ($request->query('page') === 'mylist') {
            $items = Item::whereHas('favorites', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

            return view('index', compact('items'))->with('page', 'mylist')->with('search', $search);
        }

            $favorites = auth()->check() ? auth()->user()->favorites : collect();

            return view('index', compact('items', 'favorites'))->with('page', 'all')->with('search', $search);
    }




    public function getDetail(Request $request, $item_id)
    {

        $search = $request->get('search');

        if ($search) {
            session(['search' => $search]);


            $items = Item::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $items = Item::all();
        }


        $item = Item::with('categories')->findOrFail($item_id);


        $isFavorite = $item->favorites()->where('user_id', Auth::id())->exists();
        $favoriteCount = $item->favorites()->count();

        $comments = Comment::with('user')->where('item_id', $item_id)->get();

        return view('detail', compact('item', 'isFavorite', 'favoriteCount', 'comments', 'items', 'search'));


    }







    public function getSell()
    {
        return view('sell');
    }



    public function postSell(ExhibitionRequest $request)
    {

        $item = Item::create([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
        'condition' => $request->input('condition'),
        'user_id' => auth()->id(),
        'image' => $this->uploadImage($request),
        ]);


        if ($request->has('category_id')) {
            $categoryIds = $request->input('category_id', []);
            $item->categories()->attach($categoryIds);
        }

        return redirect('/');

    }



    public function postComment(CommentRequest $request, $item_id)
    {
        $user_id = auth()->id();


        Comment::create([
        'user_id' => $user_id,
        'item_id' => $item_id,
        'comment' => $request->comment,
        ]);

        return redirect('/item/' . $item_id);
    }


    private function uploadImage($request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/items');
            return str_replace('public/', 'storage/', $path);
        }

        return null;
    }

    public function storeFavorite(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        $isFavorited = $item->favorites()->where('user_id', $user->id)->exists();


        if ($isFavorited) {

        $item->favorites()->detach($user->id);
        $status = "unliked";
    } else {

        $item->favorites()->attach($user->id);
        $status = "liked";
    }


        return response()->json([
            "status" => $status,
            "favorite_count" => $item->favorites()->count()
        ]);
    }


}
