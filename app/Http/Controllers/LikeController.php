<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request){
        $like= Like::select()->where([
            ['comment_id','=',$request->input('comment_id')],
            ['user_id', '=', Auth::user()->id]
        ])->first();
        if ($like && $like->type_like == $request->input('type_like')){
            Like::destroy($like->id);
        }
        else{
            $like = Like::updateOrCreate([
                ['comment_id','=',$request->input('comment_id')],
                ['user_id', '=', Auth::user()->id]
            ],[
                'comment_id'     => $request->input('comment_id'),
                'user_id' => Auth::user()->id,
                'type_like'    => $request->input('type_like'),
            ]);
        }
        return $like;
    }
}
