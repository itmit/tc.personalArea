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
            'news' => News::all()->sortByDesc('created_at')
            // 'news' => News::all()
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

            $news = News::create([
                'uuid' => Uuid::generate()->string,
                'head' => $request->input('head'),
                'body' => $request->input('body'),
                'picture' => $url,
            ]);

            try
            {
                $this->SendPush($news->head);
            }
            catch(Exception $e)
            { }

            return redirect()->route('auth.manager.news.index');
        }

        return redirect('/login');
    }

    /**
     * @param array $data
     * @return Validator
     */
    private function getValidator(array $data)
    {
        return Validator::make($data, [
            'head' => 'required|max:191',
            'body' => 'required|max:20000',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    }

    private function SendPush(int $title)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'to' => '/topics/All',
            "notification" => [
                "body" => "".$title."",
                "title" => "Новая новость",
                "sound"=> "default",
                "content_available" => true
            ],
            "data" => [
                "body" => "".$title."",
                "title" => "Новость",
                "sound"=> "default"
            ],
            "priority" => "high"
        );
        $fields = json_encode ( $fields );

        $headers = array (
            'Authorization: key=' . "AAAAcZkfTDU:APA91bGgoysHhtZfk272579GGadndryldrSN49MEIO3QGrgI1aKTYir62YbtVXHEaICk1-G1NIWq9DsmCwQGmcmnqqlXWltysqQRoXPoXEdkvz-1oiHS-cF54VSNsWOvut-I_0gBQgrx",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $fields);

        if(!curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }

        curl_close ($ch);
    }
}
