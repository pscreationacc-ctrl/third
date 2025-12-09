<input id="msg" placeholder="Type something">
<button onclick="send()">Send</button>
<div id="res"></div>

<script>
async function send() {
    let msg = document.getElementById('msg').value;

    let res = await fetch('python', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({message: msg})
    });

    let data = await res.json();
    document.getElementById('res').innerText = data.reply;
}
</script>
