<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SongController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $song = new Song();
            $song->name = $request->name;
            $song->description = $request->description;
            $song->file_mp3 = $request->file_mp3;
            $song->image = $request->image;
            $song->author = $request->author;
            $song->album = $request->album;
            $song->category_id = $request->category_id;
            $song->user_id = $request->user_id;
            $song->listens = 0;
            $song->save();
            DB::commit();
            $data = [
                'status' => 'success',
                'message' => 'Thêm bài hát thành công'
            ];
            return response()->json($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $data = [
                'status' => 'error',
                'message' => 'Thêm bài hát thất bại'
            ];
            return response()->json($data);
        }
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getSongById($id){
        $song = auth()->user()->songs()->findOrFail($id);
        return response()->json($song);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $song = Song::findOrFail($id);
            $song->name = $request->name;
            $song->description = $request->description;
            $song->file_mp3 = $request->file_mp3;
            $song->image = $request->image;
            $song->author = $request->author;
            $song->album = $request->album;
            $song->category_id = $request->category_id;
            $song->save();
            DB::commit();
            $data = [
                'status' => 'success',
                'message' => 'Sửa bài hát thành công'
            ];
            return response()->json($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $data = [
                'status' => 'error',
                'message' => 'Sửa bài hát thất bại'
            ];
            return response()->json($data);
        }
    }

    public function getMySongs($id)
    {
        $songs = DB::table('songs')->where('user_id',$id)->get();
        return response()->json($songs);
    }


    public function detailSong($id)
    {
            $song=Song::findOrFail($id);
            return response()->json($song);
    }

    public function getAll()
    {
        $songs= DB::table('songs')->get();
        return response()->json($songs);
    }

    public function getNewSongs()
    {
        $songs = DB::table('songs')->orderByDesc('id')->limit(5)->get();
        return response()->json($songs);
    }

    public function search($name)
    {
        $empty=[];
        $songs = Song::where('name', 'LIKE', '%'. $name. '%')->get();
        if($songs){
            return response()->json($songs);
        }
        else
        {
            return response()->json($empty);
        }
    }

    public function delete($id)
    {
        $song= Song::findOrFail($id);
        $song->delete();
        return response()->json($song);
    }
}
