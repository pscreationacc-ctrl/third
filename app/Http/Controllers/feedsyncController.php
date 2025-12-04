<?php

namespace App\Http\Controllers;

use App\Models\FeedsyncModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class feedsyncController extends Controller
{
    public function showfrontend()
    {
        $data = FeedsyncModel::all();
        return view('socialPost', compact('data'));


    }

    public function test(){
        return view ('testing');
    }

    public function details($user_id){
    $data = FeedsyncModel::where('user_id', auth::id())->findOrFail($user_id);
    abort_if($data->user_id !== auth::id(), 403);
        return view ('details', compact('data'));
    }

    public function testing(){
        return view ('testing');
    }
    
public function delete($user_id)
{
    $data = FeedsyncModel::where('user_id', auth::id())->findOrFail($user_id);
    abort_if($data->user_id !== auth::id(), 403);
    $data = FeedsyncModel::findOrFail($user_id); 
    $data->delete();
    return redirect()->route('feedsync.history');
}

        public function history(request $request){
                    $data = FeedsyncModel::where('user_id', auth::id())->get();
        return view ('history', compact('data'));
    }

    public function savedata(Request $request)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'media_url' => 'required|url',
            'scheduled_date' => 'nullable|date',
            'platform' => 'required|in:facebook,instagram,tiktok',
            'format' => 'required|in:story,carousel,other',
            'tags' => 'array',
            'tags.*' => 'in:photolink,fbphotopost,fbfirstcomment,fbvideo,fbexclude,igphotopost,igvideo,igcarousel,postnow,fbstoryvideo,igstoryvideo,fbstoryphoto,igstoryphoto,tiktokstoryvideo,tiktokstoryphoto,tiktokcarousel,tiktokvideo', // validate against allowed tags
        ]);

        $data = new FeedsyncModel();
        $data->caption = $validated['caption'];
        $data->media_url = $validated['media_url'];
        $data->scheduled_date = $validated['scheduled_date'];
        $data->tags = $validated['tags'] ?? [];
        $data->platform = $validated['platform'];
        $data->format = $validated['format'];
        $data->user_id = Auth::id();
        $data->save();
        return redirect()->back();
    }
}
