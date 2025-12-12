<input id="msg" placeholder="Type something">
<button onclick="send()">Send</button>
<div id="res"></div>

<script>
async function send() {
    let msg = document.getElementById('msg').value;

    // Display user message
    const resDiv = document.getElementById('res');
    resDiv.innerHTML += `<div class="user-message"><strong>You:</strong> ${msg}</div>`;

fetch('/python', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
        message: msg,
        use_langchain: true,  // <-- This enables LangChain
        session_id: "your-session-id"
    })
})
.then(response => response.json())
.then(data => {
    console.log(data);
    // Display AI response
    resDiv.innerHTML += `<div class="ai-message"><strong>AI:</strong> ${data.response}</div>`;
    resDiv.innerHTML += `<div class="debug-info">Memory: ${JSON.stringify(data.memory)} | Method: ${data.method}</div>`;
});
}
</script>
