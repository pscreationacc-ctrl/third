<?php

namespace App\Http\Controllers;

use OpenAI;
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


    public function stream(Request $request)
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        return response()->stream(function () use ($client) {
            $stream = $client->chat()->createStreamed([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => 'Γράψε μια ιστορία 50 λέξεων.'],
                ],
                // προαιρετικά: 'stream_options' => [ 'include_usage' => true ],
            ]);

            foreach ($stream as $chunk) {
                // Κάθε chunk έχει νέο text
                echo $chunk->choices[0]->delta->content ?? '';
                ob_flush();
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no'
        ]);
    }

 public function ai(Request $request)
{
    $text = $request->input('message');

    // Change to the correct directory where Modelfile.py is located
    $command = "cd " . base_path('resources/model/mistral') . " && python Modelfile.py";

    $descriptorspec = [
        0 => ["pipe", "r"],  // stdin
        1 => ["pipe", "w"],  // stdout
        2 => ["pipe", "w"]   // stderr
    ];

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Write input to the process
        fwrite($pipes[0], $text);
        fclose($pipes[0]);

        // Read the output
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        // Read any errors
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        // Close the process
        proc_close($process);

        if (!empty($errors)) {
            return response()->json(['error' => 'Model execution failed: ' . $errors], 500);
        }

        return response()->json(json_decode($output, true));
    } else {
        return response()->json(['error' => 'Failed to start model process'], 500);
    }
}


public function testview(){
return view('python');
}

}
