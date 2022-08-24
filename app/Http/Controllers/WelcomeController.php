<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $currentPage = request()->get('page',1);

        $postData = Cache::get('posts-' . $currentPage);

        if(!isset($postData)) {
            $postData = Cache::remember('posts-' . $currentPage, now()->addMinutes(5), function () {
                return DB::table('posts')->orderBy('publication_date', 'desc')->paginate(10);
            });
        }

        return view('welcome')->with('posts', $postData);
    }
}
