
<style>
.platform-buttons {
        position: fixed;
        top: 15px;
        left: 480px;
    font-size: 20px;      
    padding: 0px 30px;    
    border-radius: 8px;   
        display: flex;
        z-index: 1000;
    }

.button-group button {
    background-color: white;       
    color: #333;                  
    border: 1px solid #ccc;       
    padding: 20px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s ease;
}

.button-group button:hover {
    background-color: #f0f0f0;     
    border-color: #999;             
}

    .platform-buttons input[type="button"]:hover {
        background-color: #2c6dcc;
        transform: translateY(-2px);
    }

    .platform-buttons input[type="button"]:active {
        background-color: #1e4f99;
        transform: translateY(0);
    }
.platform-buttons input[type="button"] {
    font-size: 18px;        
    padding: 10px 25px;     
    min-width: 330px;       
    min-height: 50px;       
    background-color: white;
    color: black;
    border: 2px solid gray;
    border-radius: 8px;
    cursor: pointer;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feed History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="platform-buttons">
      
    <label>
<input type="hidden" id="selectedPlatform" name="platform" />
    </label>

        <label>
        <input type="button" value="social" onclick="window.location='{{route('feedsync.social')}}'" /> 
    </label>

    <label>
        <input type="button" value="history" onclick="window.location='{{route('feedsync.history')}}'" />
    </label>
    </div>
<div style="margin-top: 120px;">
    <h2 style="margin-bottom: 40px; text-align: center;">Feed History</h2>

    @if($data->isEmpty())
        <div class="alert alert-info text-center">
            No feeds found.
        </div>
    @else
        <div class="row g-3">
            @foreach($data as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">
                                {{ ucfirst($item->platform) }} • {{ $item->format }}
                            </h5>
                            <p class="card-text">
                                {{ Str::limit($item->caption, 80) }}
                            </p>
                            <small class="text-muted mb-2">
                                {{ $item->scheduled_date ?? 'No schedule' }}
                            </small>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ $item->media_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    Open Link
                                </a>
                                <a href="{{ route('feedsync.details' ,$item->user_id) }}" class="btn btn-sm btn-info">
                                    Details
                                </a>
<form action="{{ route('feedsync.delete', $item->user_id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
