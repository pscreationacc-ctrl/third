from transformers import pipeline
import sys
import json
generator = pipeline('text-generation', model='EleutherAI/gpt-neo-125M')

data = sys.stdin.read().strip()
user_input = data if data else ""
prompt = f"Answer this question clearly: {user_input}"
result = generator(prompt, max_length=50, do_sample=True)


print(json.dumps({"reply": result[0]["generated_text"]}))