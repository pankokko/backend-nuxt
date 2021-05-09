<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{

    public function index(Request $requst)
    {

        $posts = Post::all();
        // return response()->json(["message" => "成功しました"]);

        return response()->json($posts);
    }
    
    public function show($id)
    {
        $post = Post::find($id);

        return response()->json($post);
    }
    

    public function create(Request $request)
    {
        clock()->info($request->all());

      $image = $request->file('image');

      // バケットの`myprefix`フォルダへアップロード
      $path = Storage::disk('s3')->putFile('album', $request->image, 'public');
      // アップロードした画像のフルパスを取得
      $image_path = Storage::disk('s3')->url($path);

        try {
            $post = Post::create([
                'comment' => $request->comment,
                'title' =>   $request->title,
                'image_path' => $image_path,
            ]);
        } catch (Exception $exception) {
            return response()->json($exception);
        }

        return response()->json($post);
    }

    public function test(Request $request)
    {
        clock()->info($request->all());

        //js側で設定したキーを指定
        $file = $request->file('file');
    }

    public function delete($id)
    {  
        clock()->info($id);

        try {
            Post::find($id)->delete();
            return response()->json(["message" => "削除しました"]);
        } catch (Exception $exception){
            return response()->json($exception);
        }

    }

}
