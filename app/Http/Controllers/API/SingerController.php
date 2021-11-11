<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Singer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Tymon\JWTAuth\Exceptions\JWTException;


class SingerController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
        $singer=new Singer();
        $singer->name=$request->name;
        $singer->gender=$request->gender;
        $singer->date_of_birth=$request->date_of_birth;
        $singer->story=$request->story;
        $singer->band=$request->band;
        $singer->information=$request->information;
        $singer->avatar=$request->avatar;
        $singer->save();
            DB::commit();
            $data = [
                'status' => 'success',
                'message' => 'Thêm bài hát thành công'
            ];
            return response()->json($data);
        } catch (JWTException $exception) {
            $data = [
                'status' => '500',
                'message' => 'Thêm bài hát thất bại'
            ];
            DB::rollBack();
            return response()->json($data);
        }
    }

    public function getAll()
    {
        $singers=Singer::all();
        return response()->json($singers);
    }


}
