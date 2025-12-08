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

 public function generate(Request $request)
    {
        $prompt = $request->input('message');

        // Get the full path to the Python script
        $scriptPath = base_path('test_model.py');

        // Use the correct Python file name with full path and handle errors
        $command = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($prompt);
        $output = shell_exec($command . " 2>&1");
        $output = trim($output);  // αφαιρεί κενά / newlines

        // If output is empty, try alternative Python command
        if (empty($output)) {
            $command = "python " . escapeshellarg($scriptPath) . " " . escapeshellarg($prompt);
            $output = shell_exec($command . " 2>&1");
            $output = trim($output);
        }

        // Parse the JSON output from Python script
        $responseData = json_decode($output, true);

        if ($responseData && isset($responseData['reply'])) {
            return response()->json(['reply' => $responseData['reply']]);
        } else {
            // Fallback to raw output if JSON parsing fails
            return response()->json(['reply' => $output ?: "No response generated"]);
        }


    }

public function testview(){
return view('testing');
}

}
