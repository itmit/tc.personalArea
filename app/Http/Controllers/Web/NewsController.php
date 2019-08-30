<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('news.news', [
            'title' => 'Новости рынка',
            'news' => News::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.createNews', [
            'title' => 'Добавить новость'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRole(['super-admin', 'manager'])) {
            $validator = $this->getValidator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.manager.news.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $path = $request->file('picture')->store('public/newsPictures');
            $url = Storage::url($path);

            News::create([
                'uuid' => Uuid::generate()->string,
                'head' => $request->input('head'),
                'body' => $request->input('body'),
                'picture' => $url,
            ]);

            return redirect()->route('auth.manager.news.index');
        }

        return redirect('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param array $data
     * @return Validator
     */
    private function getValidator(array $data)
    {
        return Validator::make($data, [
            'head' => 'required|max:50',
            'body' => 'required|max:20000',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    }
}
