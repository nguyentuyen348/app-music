<?php

namespace App\Http\Controllers\API;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\Song_like;
use Mockery\Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

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
            $songLike = new Song_like();
            $songLike->song_id = $song->id;
            $songLike->user_id = 2;
            $songLike->status = SongConstant::UNLIKED;
            $songLike->save();
            DB::commit();
            $data = [
                'status' => 'success',
                'message' => 'Thêm bài hát thành công'
            ];
            return response()->json($data);
        } catch (JWTException $exception) {
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

    public function getSongById($id)
    {
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
        } catch (JWTException $exception) {
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
        $songs = DB::table('songs')->where('user_id', $id)->get();
        return response()->json($songs);
    }


    public function detailSong($id)
    {
        $song = Song::findOrFail($id);
        return response()->json($song);
    }

    public function getAll()
    {
        $songs = DB::table('songs')->get();
        return response()->json($songs);
    }

    public function getNewSongs()
    {
        $songs = DB::table('songs')
            ->join('song_like', 'songs.id', '=', 'song_like.song_id')
            ->groupBy('songs.id')
            ->orderByDesc('songs.id')->limit(5)->get();
        return response()->json($songs);
    }

    public function search($name)
    {
        $songs = Song::where('name', 'LIKE', '%' . $name . '%')->get();
        if ($songs) {
            return response()->json($songs);
        }
        $songs = [];
        return response()->json($songs);
    }

    public function delete($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return response()->json($song);
    }

    public function getSongManyListens()
    {
        $songs = DB::table('songs')
            ->join('song_like', 'songs.id', '=', 'song_like.song_id')
            ->groupBy('songs.id')
            ->orderByDesc('listens')->limit(5)->get();
        return response()->json($songs);
    }

    public function getSongManyLiked()
    {
        $songs = DB::table('songs')
            ->select("songs.*", "song_like.status", DB::raw("COUNT(song_id) as count_liked"))
            ->join('song_like', 'songs.id', '=', 'song_like.song_id')
            ->where('status', 1)
            ->groupBy('songs.id')
            ->orderByDesc('count_liked')->limit(5)->get();
        return response()->json($songs);
    }

    public function addLiked(Request $request)
    {
        $song = DB::table('song_like')->where('song_id', $request->song_id)->get();
        $check = true;
        for ($i = 0; $i < count($song); $i++) {
            if ($request->user_id == $song[$i]->user_id) {
                $check = false;
            }
        }
        if ($check) {
            $songLiked = new Song_like();
            $songLiked->song_id = $request->song_id;
            $songLiked->user_id = $request->user_id;
            $songLiked->status = SongConstant::LIKED;
            $songLiked->save();
            $data = [
                'message' => 'Đã thích',
                'check' => $check
            ];
            return response()->json($data);
        }
        $getId = DB::table('song_like')
            ->where('song_id', $request->song_id)
            ->where('user_id', $request->user_id)->get();
        $changeStatus = Song_like::find($getId[0]->id);
        if ($changeStatus->status == SongConstant::LIKED) {
            $changeStatus->status = SongConstant::UNLIKED;
            $changeStatus->save();
            $data = [
                'status' => 'unliked',
                'message' => 'Thích',
            ];
            return response()->json($data);
        } else {
            $changeStatus->status = SongConstant::LIKED;
            $changeStatus->save();
            $data = [
                'status' => 'liked',
                'message' => 'Đã thích',
            ];
            return response()->json($data);
        }
    }
}
