from transformers import pipeline
import sys
import json

try:
    generator = pipeline('text-generation', model='EleutherAI/gpt-neo-125M')
    user_input = sys.argv[1] if len(sys.argv) > 1 else ""
    prompt = f"Answer this question clearly: {user_input}"

    result = generator(prompt, max_length=50, do_sample=True)
    generated_text = result[0]['generated_text']

    # Return JSON format that can be easily parsed
    response = {
        "prompt": prompt,
        "reply": generated_text
    }

    print(json.dumps(response))

except Exception as e:
    # Return error in JSON format
    error_response = {
        "error": str(e),
        "reply": "An error occurred while processing your request."
    }
    print(json.dumps(error_response))
