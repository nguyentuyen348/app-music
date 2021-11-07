<?php

namespace App\Http\Controllers\API;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class PlaylistController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $playlist = new Playlist();
            $playlist->name = $request->name;
            $playlist->description = $request->description;
            $playlist->category_id = $request->category_id;
            $playlist->user_id = $request->user_id;
            $playlist->views = 0;
            $playlist->save();
            DB::commit();
            $data = [
                'status' => 'success',
                'message' => 'Thêm playlist thành công'
            ];
            return response()->json($data);
        } catch (JWTException $exception) {
            DB::rollBack();
            $data = [
                'status' => 'error',
                'message' => 'Thêm playlist thất bại'
            ];
            return response()->json($data);
        }
    }
}
