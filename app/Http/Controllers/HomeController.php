<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;
use App\Models\post;
use App\Models\images;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date=now();
        $filter=100;
        if(Session::get('filter')){
            $filter = session('filter');
        }
        $post=post::with('images')
        ->where('created_at', '>=', Carbon::parse($date)->subDays($filter))
        ->paginate(6);
        // dd($post);
        return view('home',compact('post'));
    }
    public function addpost()
    {
        return view('post');
    }
    public function storepost(Request $request){
        // dd($request);
        $user_id = auth()->user()->id;
        $postId = post::insertGetId([
            'descripton' => $request->description,
            'title' => $request->title,
            'user_id'=>$user_id,
            'created_at'=>now(),
            
        ]);
        if ($request->has('images')) {
            foreach($request->images as $images){
                $filename = uniqid() . '.' . $images->getClientOriginalExtension();
                $images->move('images/', $filename);
                images::insert([
                    'post_id' => $postId,
                    'image' => $filename,
                ]);
            }
        }
        return true;

       
    }
    public function deletepost(Request $request){
        $postId = post::find($request->id)->delete();
        // dd($postId);
        images::where('post_id',$request->id)->delete();
        return true;

    }

    public function filterpost(Request $request){
        // dd($request);
        Session::put('filter', $request->filter);
        return true;

    }
    public function editpost(Request $request,$id){
        $post=post::with('images')->where('postblog.id',$id)->first();
        return view('editpost',compact('post'));
    }
    public function deleteimage(Request $request){
        // dd($request);
        $images=images::find($request->id)->delete();
        return true;

    }
    public function updatepost(Request $request){
        // dd($request);
        $user_id = auth()->user()->id;
        $postId = post::where('id',$request->postid)->update([
            'descripton' => $request->description,
            'title' => $request->title,
            'user_id'=>$user_id,
            'updated_at'=>now(),
            
        ]);
        if ($request->has('images')) {
            foreach($request->images as $images){
                $filename = uniqid() . '.' . $images->getClientOriginalExtension();
                $images->move('images/', $filename);
                images::insert([
                    'post_id' =>$request->postid,
                    'image' => $filename,
                ]);
            }
        }
        return true;
    }
    
}
