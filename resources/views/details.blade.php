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
    <title>Feed Details</title>
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
<div class="container mt-5">
    <h2 class="mb-4">Feed Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Platform: {{ $data->platform ?? 'N/A' }}</h5>
            <p class="card-text"><strong>Format:</strong> {{ $data->format ?? 'N/A' }}</p>
            <p class="card-text"><strong>Text:</strong> {{ $data->caption ?? 'N/A' }}</p>
            <p class="card-text"><strong>URL:</strong> <a href="{{ $data->media_url }}" target="_blank">{{ $data->media_url }}</a></p>
            <p class="card-text"><strong>Scheduled Date:</strong> {{ $data->scheduled_date ?? 'No schedule' }}</p>
            <p class="card-text"><strong>Tags:</strong> {{ implode(', ', $data->tags ?? []) }}</p>
            <a href="{{ route('feedsync.history') }}" class="btn btn-secondary mt-3">Back to History</a>
        </div>
    </div>
</div>
</body>
</html>
