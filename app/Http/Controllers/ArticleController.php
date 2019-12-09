<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $number_of_pages = ceil(Article::count() / 10);
        return view('article-cms', compact('number_of_pages'));
    }

    /**
     * Return list of articles for ajax.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $articles = DB::select(DB::raw('select id, name, slug from articles limit '. $request->page .' 10'));
        return $articles;
    }

    /**
     * Return detail of article for ajax.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $article = DB::select(DB::raw('select * from articles where id = '. $request->id));
        return json_encode($article);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article-add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('articles')->insert(
            [
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'body' => $request->body,
            'creator'    => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]
        );

        return redirect('article');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {   
        $comments = DB::select(DB::raw('select * from comments where article_id = '. $article->id));
        return view('article', compact('article', 'comments'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select(DB::raw('delete from articles where id = '. $id));
        DB::select(DB::raw('delete from comments where article_id = '. $id));
        return json_encode(true);
    }
}
