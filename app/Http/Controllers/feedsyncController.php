<?php

namespace App\Http\Controllers;

use OpenAI;
use App\Models\FeedsyncModel;
use App\Models\ConversationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



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
                    $feedsyncData = FeedsyncModel::where('user_id', auth::id())->get();
                    $conversationHistory = ConversationHistory::where('user_id', auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view ('history', compact('feedsyncData', 'conversationHistory'));
    }

    public function getConversationHistory(Request $request)
    {
        $sessionId = $request->input('session_id');

        $query = ConversationHistory::where('user_id', auth::id());

        if ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        return response()->json([
            'history' => $query->orderBy('created_at', 'desc')->get()
        ]);
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


    // public function stream(Request $request)
    // {
    //     $client = OpenAI::client(env('OPENAI_API_KEY'));

    //     return response()->stream(function () use ($client) {
    //         $stream = $client->chat()->createStreamed([
    //             'model' => 'gpt-3.5-turbo',
    //             'messages' => [
    //                 ['role' => 'user', 'content' => 'Γράψε μια ιστορία 50 λέξεων.'],
    //             ],
    //             // προαιρετικά: 'stream_options' => [ 'include_usage' => true ],
    //         ]);

    //         foreach ($stream as $chunk) {
    //             // Κάθε chunk έχει νέο text
    //             echo $chunk->choices[0]->delta->content ?? '';
    //             ob_flush();
    //             flush();
    //         }
    //     }, 200, [
    //         'Content-Type' => 'text/event-stream',
    //         'Cache-Control' => 'no-cache',
    //         'X-Accel-Buffering' => 'no'
    //     ]);
    // }   

 public function ai(Request $request)
{
    $text = $request->input('message');
    $sessionId = $request->input('session_id', Str::uuid());
    $useLangChain = $request->input('use_langchain', false);

    if ($useLangChain) {
        return $this->processWithLangChain($text, $sessionId);
    } else {
        return $this->processWithMistral($text, $sessionId);
    }
}

protected function processWithLangChain($text, $sessionId)
{
    // Get conversation history for LangChain context
    $chatHistory = [];
    if (Auth::check()) {
        $previousConversations = ConversationHistory::where('user_id', Auth::id())
            ->where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->limit(10) // Get last 10 conversations for context
            ->get();

        foreach ($previousConversations as $conversation) {
            $chatHistory[] = [
                'user' => $conversation->question,
                'ai' => $conversation->response
            ];
        }
    }

    // Prepare input for LangChain
    $inputData = [
        'text' => $text,
        'history' => $chatHistory
    ];

    // Change to the LangChain directory
$command = "cd /d " . base_path('resources/model/langchain') . " && py -3.11 chain.py";


    $descriptorspec = [
        0 => ["pipe", "r"],  // stdin
        1 => ["pipe", "w"],  // stdout
        2 => ["pipe", "w"]   // stderr
    ];

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Write JSON input to the process
        fwrite($pipes[0], json_encode($inputData));
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
            return response()->json(['error' => 'LangChain execution failed: ' . $errors], 500);
        }

        try {
            $responseData = json_decode($output, true);

            // Save conversation history if user is authenticated
            if (Auth::check()) {
                ConversationHistory::create([
                    'user_id' => Auth::id(),
                    'question' => $text,
                    'response' => $responseData['response'] ?? 'No response',
                    'session_id' => $sessionId
                ]);
            }

            return response()->json([
                'response' => $responseData['response'] ?? 'No response',
                'memory' => $responseData['memory'] ?? [],
                'method' => 'langchain'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to parse LangChain response: ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Failed to start LangChain process'], 500);
    }
}

protected function processWithMistral($text, $sessionId)
{
    $context = '';

    // Get conversation history for context if user is authenticated
    if (Auth::check()) {
        $previousConversations = ConversationHistory::where('user_id', Auth::id())
            ->where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->limit(5) // Get last 5 conversations for context
            ->get();

        if ($previousConversations->isNotEmpty()) {
            $context = "Previous conversation context:\n";
            foreach ($previousConversations as $conversation) {
                $context .= "User: " . $conversation->question . "\n";
                $context .= "AI: " . $conversation->response . "\n";
            }
            $context .= "Current question: ";
        }
    }

    // Prepare the full input with context
    $fullInput = $context . $text;

    // Change to the correct directory where Modelfile.py is located
    $command = "cd /d " . base_path('resources/model/mistral') . " && python Modelfile.py";

    $descriptorspec = [
        0 => ["pipe", "r"],  // stdin
        1 => ["pipe", "w"],  // stdout
        2 => ["pipe", "w"]   // stderr
    ];

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Write input with context to the process
        fwrite($pipes[0], $fullInput);
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

        $responseData = json_decode($output, true);

        // Save conversation history if user is authenticated
        if (Auth::check()) {
            ConversationHistory::create([
                'user_id' => Auth::id(),
                'question' => $text,
                'response' => $responseData['response'] ?? $output,
                'session_id' => $sessionId
            ]);
        }

        return response()->json($responseData);
    } else {
        return response()->json(['error' => 'Failed to start model process'], 500);
    }
}


}
