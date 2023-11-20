<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    private function getYouTubeVideoTitle($videoUrl) {
        $videoId = '';
        
        // Extract video ID from URL
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $match)) {
            $videoId = $match[1];
        }
    
        if (!empty($videoId)) {
            $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoId&part=snippet&key=". env('YOUTUBE_API');
    
            $json = file_get_contents($apiUrl);
    
            if ($json) {
                $data = json_decode($json, true);
    
                // Extract video title
                if (isset($data['items'][0]['snippet']['title'])) {
                    return $data['items'][0]['snippet']['title'];
                } else {
                    return 'Title not found';
                }
            } else {
                return 'Unable to fetch data';
            }
        } else {
            return 'Invalid YouTube URL';
        }
    }

    public function trial(){
        // DB::insert('insert into contents (title, notes) values (?, ?)', ['Tes 1', 'Ini catatan untuk nomer 1']);
        // $data = DB::select('select * from contents');

        return $this->getYouTubeVideoTitle('https://www.youtube.com/watch?v=jt6C_Y4Gekg');
    }

    public function index()
    {
        return Content::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|max:255',
            'title' => 'max:255',
            'note' => 'max:255',
            // other validation rules
        ]);

        // echo $validatedData['address'];
        // print_r($validatedData);

        // Content::create([
        //     'address' => $validatedData['address'],
        //     'note' => $validatedData['note'],
        //     'title' => $validatedData['title']
        // ]);

        return Content::create($validatedData);

        // DB::insert('insert into contents (address, title, note) values (?, ?, ?)', [$validatedData['address'], 'tes', 'nothing']);

    }

    public function show(Content $content)
    {
        return $content;
    }

    public function edit(Content $content)
    {
        return $content;
    }

    public function update(Request $request, Content $content)
    {
        $content->update($request->all());
        return $content;
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return response()->json(['message' => 'content deleted successfully']);
    }
}
