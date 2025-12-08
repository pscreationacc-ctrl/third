from transformers import pipeline
import sys
generator = pipeline('text-generation', model='EleutherAI/gpt-neo-125M')

user_input = sys.argv[1] if len(sys.argv) > 1 else ""
prompt = f"Answer this question clearly: {user_input}"
result = generator(prompt, max_length=50, do_sample=True)

print(result[0]['generated_text'])