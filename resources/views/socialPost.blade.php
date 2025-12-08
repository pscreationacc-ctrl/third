<style>
    form {
        max-width: 530px;
        margin: 60px auto 60px auto;
        padding: 60px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: Arial, sans-serif;

    }

    input[type="text"],
    input[type="date"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 50px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus {
        outline: none;
        border-color: #3a8ee6;
        background-color: #fff;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin-right: 10px;
        width: 30%;
    }

    .dropdown-label {
        display: block;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        color: #555;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

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

    .dropdown:hover .dropdown-content,
    .dropdown:focus-within .dropdown-content {
        display: block;
    }

    .dropdown-content {
        display: none;
        position: relative;
        top: 100%;
        min-width: 10px;
        left: 0;
        border: 1px solid #ccc;
        border-top: none;
        background-color: #fff;
        box-sizing: border-box;
        border-radius: 0 0 6px 6px;
        max-height: 150px;
        overflow-y: auto;
        z-index: 10000;
    }

    .dropdown-content div {
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .dropdown-content div.selected {
        outline: 2px solid #3a8ee6;
        background-color: #e6f0ff;
    }


    .dropdown-content div {
        padding: 10px 12px;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        transition: background-color 0.2s ease;
    }

    .dropdown-content div:hover {
        background-color: #e6f0ff;
    }

    .dropdown-content div.selected {
        background-color: #3a8ee6;
        color: white;
        font-weight: 600;
        outline: 2px solid #3a8ee6;
    }

    button[type="submit"] {

        background-color: #3a8ee6;
        color: white;
        border: none;
        padding: 12px 18px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        width: 30%;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #2c6dcc;
    }

    .alert.alert-danger {
        background-color: #ffe6e6;
        border: 1px solid #ff4d4d;
        color: #b30000;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert.alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    #previewArea {
        position: relative;
        overflow: hidden;
        min-height: 180px;
        padding: 18px;
        background: #f8f8f8;
        border-radius: 8px;
    }


    .preview-video-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        display: flex;
        color: red;
    }

    #previewArea {
        position: relative;
        background: var(--card-bg);
        color: transparent;
    }
</style>
@php
    $tags = [
        'photolink',
        'fbphotopost',
        'fbfirstcomment',
        'fbvideo',
        'fbexclude',
        'igphotopost',
        'igvideo',
        'igcarousel',
        'postnow',
        'fbstoryvideo',
        'igstoryvideo',
        'fbstoryphoto',
        'igstoryphoto',
        'tiktokstoryvideo',
        'tiktokstoryphoto',
        'tiktokcarousel',
        'tiktokvideo',
    ]; // predefined tags
    $userTags = $user->tags ?? [];
    $vUrl = asset('videos/coolvid.mp4');
@endphp
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>

    <form id="myForm"method="POST" action="{{ route('feedsync.save') }}">
        <div class="bgvideo">
            <video autoplay loop muted playsinline>
                <source src="{{ $vUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        @csrf
        <div>
            <div class="platform-buttons">

                <label>
                    <input type="hidden" id="selectedPlatform" name="platform" />
                </label>

                <label>
                    <input type="button" value="social" onclick="window.location='{{ route('feedsync.social') }}'" />
                </label>

                <label>
                    <input type="button" value="history" onclick="window.location='{{ route('feedsync.history') }}'" />
                </label>
            </div>

            <!-- Platform dropdowns -->
            <div class="dropdown" data-platform="facebook">
                <span class="dropdown-label">Facebook</span>
                <div class="dropdown-content">
                    <div data-value="story">Story</div>
                    <div data-value="carousel">Carousel</div>
                    <div data-value="other">other</div>
                </div>
            </div>


            <div class="dropdown" data-platform="instagram">
                <span class="dropdown-label">Instagram</span>
                <div class="dropdown-content">

                    <div data-value="story">Story</div>
                    <div data-value="carousel">Carousel</div>
                    <div data-value="other">other</div>
                </div>
            </div>

            <div class="dropdown" data-platform="tiktok">

                <span class="dropdown-label">TikTok</span>
                <div class="dropdown-content">
                    <div data-value="story">Story</div>
                    <div data-value="carousel">Carousel</div>
                    <div data-value="other">other</div>
                </div>
            </div>

            <input type="hidden" id="selectedFormat" name="format" />

            <!-- Preview area -->
            <div id="previewArea" style="text-align:center; color:white;">
                Please select a site and format
            </div>

            <button oncliclick="" type="submit">Submit</button>
        </div>
        @if ($errors->any())
            <div class="preview-video-bg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</body>

</html>

<style>
    #myForm {
        position: relative;
        overflow: hidden
    }

    #myForm>.bgvideo {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 0
    }

    #myForm>.bgvideo video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block
    }

    /* ensure all normal form content stays above the video */
    #myForm>*:not(.bgvideo) {
        position: relative;
        z-index: 1
    }
</style>

<script>
    const dropdowns = document.querySelectorAll('.dropdown');
    const previewArea = document.getElementById('previewArea');
    const selectedPlatformInput = document.getElementById('selectedPlatform');
    const selectedFormatInput = document.getElementById('selectedFormat');
    const form = document.getElementById('myForm');
    const messageDiv = document.getElementById('message');
    

    form.addEventListener('submit', function(e) {
        const text = this.elements['caption'].value;
        const platform = this.elements['platform'].value;
        const format = this.elements['format'].value;
        const url = this.elements['media_url'].value;
        const date = this.elements['scheduled_date'].value;
        const tagElements = this.elements['tags']; 
const tag = Array.from(tagElements.selectedOptions).map(opt => opt.value);

alert("data successfully posted \n" +
      "platform: " + platform + "\n" +
      "format: " + format + "\n" +
      "url: " + url + "\n" +
      "date: " + date + "\n" +
      "tags: " + tag.join(', '));
    });


    const codeSnippets = {
        facebook: {
            story: '<div class="facebook-story">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">facebook story</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width:100%; margin-bottom:15px;">\n' +
                '    <option value="photolink">Facebook Photo Link</option>\n' +
                '    <option value="postnow">Facebook Post Now</option>\n' +
                '    <option value="fbphotopost">Facebook Photo Post</option>\n' +
                '    <option value="fbfirstcomment">Facebook First Comment</option>\n' +
                '    <option value="fbvideo">Facebook Video</option>\n' +
                '    <option value="fbexclude">Facebook Exclude</option>\n' +
                '    <option value="fbstoryvideo">Facebook Story Video</option>\n' +
                '    <option value="fbstoryphoto">Facebook Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                '  <div style="color:white;">scheduled_date</div>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',

            carousel: '<div class="facebook-carousel">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">facebook carousel</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Facebook Photo Link</option>\n' +
                '    <option value="postnow">Facebook Post Now</option>\n' +
                '    <option value="fbphotopost">Facebook Photo Post</option>\n' +
                '    <option value="fbfirstcomment">Facebook First Comment</option>\n' +
                '    <option value="fbvideo">Facebook Video</option>\n' +
                '    <option value="fbexclude">Facebook Exclude</option>\n' +
                '    <option value="fbstoryvideo">Facebook Story Video</option>\n' +
                '    <option value="fbstoryphoto">Facebook Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',


            other: '<div class="facebook-other">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">facebook other</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Facebook Photo Link</option>\n' +
                '    <option value="postnow">Facebook Post Now</option>\n' +
                '    <option value="fbphotopost">Facebook Photo Post</option>\n' +
                '    <option value="fbfirstcomment">Facebook First Comment</option>\n' +
                '    <option value="fbvideo">Facebook Video</option>\n' +
                '    <option value="fbexclude">Facebook Exclude</option>\n' +
                '    <option value="fbstoryvideo">Facebook Story Video</option>\n' +
                '    <option value="fbstoryphoto">Facebook Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',
                
        },

        instagram: {
            story: '<div class="instagram-story">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">instagram story</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Instagram Photo Link</option>\n' +
                '    <option value="postnow">Instagram Post Now</option>\n' +
                '    <option value="igphotopost">Instagram Photo Post</option>\n' +
                '    <option value="igvideo">Instagram Video</option>\n' +
                '    <option value="igcarousel">Instagram Carousel</option>\n' +
                '    <option value="igstoryvideo">Instagram Story Video</option>\n' +
                '    <option value="igstoryphoto">Instagram Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',


            carousel: '<div class="instagram-carousel">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">instagram carousel</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Instagram Photo Link</option>\n' +
                '    <option value="postnow">Instagram Post Now</option>\n' +
                '    <option value="igphotopost">Instagram Photo Post</option>\n' +
                '    <option value="igvideo">Instagram Video</option>\n' +
                '    <option value="igcarousel">Instagram Carousel</option>\n' +
                '    <option value="igstoryvideo">Instagram Story Video</option>\n' +
                '    <option value="igstoryphoto">Instagram Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',

            other: '<div class="instagram-other">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">instagram other</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Instagram Photo Link</option>\n' +
                '    <option value="postnow">Instagram Post Now</option>\n' +
                '    <option value="igphotopost">Instagram Photo Post</option>\n' +
                '    <option value="igvideo">Instagram Video</option>\n' +
                '    <option value="igcarousel">Instagram Carousel</option>\n' +
                '    <option value="igstoryvideo">Instagram Story Video</option>\n' +
                '    <option value="igstoryphoto">Instagram Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',
        },


        tiktok: {
            story: '<div class="tiktok-story">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">Tiktok story</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Tiktok Photo Link</option>\n' +
                '    <option value="postnow">Tiktok post now</option>\n' +
                '    <option value="tiktokvideo">Tiktok Video</option>\n' +
                '    <option value="tiktokcarousel">Tiktok Carousel</option>\n' +
                '    <option value="tiktokstoryvideo">Tiktok Story Video</option>\n' +
                '    <option value="tiktokstoryphoto">Tiktok Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',

            carousel: '<div class="tiktok-carousel">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">Tiktok carousel</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Tiktok Photo Link</option>\n' +
                '    <option value="postnow">Tiktok post now</option>\n' +
                '    <option value="tiktokvideo">Tiktok Video</option>\n' +
                '    <option value="tiktokcarousel">Tiktok Carousel</option>\n' +
                '    <option value="tiktokstoryvideo">Tiktok Story Video</option>\n' +
                '    <option value="tiktokstoryphoto">Tiktok Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',

            other: '<div class="tiktok-other">\n' +
                '  <div style="text-align: center; font-weight: bold; color: white; margin-top:35px;">Tiktok other</div>\n' +
                '  <input type="text" name="media_url" placeholder="Enter URL" />\n' +
                '  <select name="tags[]" id="tags" multiple="multiple" style="width: 100%">\n' +
                '    <option value="photolink">Tiktok Photo Link</option>\n' +
                '    <option value="postnow">Tiktok post now</option>\n' +
                '    <option value="tiktokvideo">Tiktok Video</option>\n' +
                '    <option value="tiktokcarousel">Tiktok Carousel</option>\n' +
                '    <option value="tiktokstoryvideo">Tiktok Story Video</option>\n' +
                '    <option value="tiktokstoryphoto">Tiktok Story Photo</option>\n' +
                '  </select>\n' +
                '<textarea name="caption" placeholder="Enter text" rows="6" style="width:100%; padding:5px; font-size:16px; margin-top:25px; margin-bottom:25px;"></textarea>\n' +
                ' <input type="datetime-local" min="{{ date('Y-m-d') }}" name="scheduled_date" style="width:100%;  height:40; min="{{ date('Y-m-d') }}"" /></div>\n' +
                '</div>',
        }
    };
    // dropdown-content previewArea
dropdowns.forEach(dropdown => {
    const options= dropdown.querySelectorAll('.dropdown-content div');
    options.forEach(option => {
        option.addEventListener('click', () =>{

        const platform = dropdown.dataset.platform;
        const format = option.dataset.value;

        // Update the hidden input fields with selected values
        selectedPlatformInput.value = platform;
        selectedFormatInput.value = format;

        previewArea.innerHTML= codeSnippets[platform][format];
        });
    });
});

</script>


</script>
