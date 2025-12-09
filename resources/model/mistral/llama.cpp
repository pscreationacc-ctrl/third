import requests, sys, json

user_input = sys.stdin.read().strip()

resp = requests.post(
    "http://localhost:11434/api/generate",
    json={
        "model": "mistral-local",   # το μοντέλο που δημιούργησες με το Modelfile
        "prompt": user_input
    }
)

print(json.dumps(resp.json()))
