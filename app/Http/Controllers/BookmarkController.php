<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store($tweetId)
    {
        $tweet = Tweet::findOrFail($tweetId);
        Auth::user()->bookmarks()->syncWithoutDetaching([$tweet->id]);

        return back()->with('success', 'ブックマークしました');
    }

    public function destroy($tweetId)
    {
        $tweet = Tweet::findOrFail($tweetId);
        Auth::user()->bookmarks()->detach($tweet->id);

        return back()->with('success', 'ブックマークを解除しました');
    }

    public function index()
    {
        $bookmarks = Auth::user()
        ->bookmarks()
        ->with(['user']) //ツイートとその投稿者の情報も一緒に取得
        ->latest()             //最新のブックマーク順に
        ->get();

        return view('bookmarks.index', compact('bookmarks'));
    }
}

