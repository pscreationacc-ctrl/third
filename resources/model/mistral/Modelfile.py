import sys
import json
from pathlib import Path

def run_mistral_model(user_input):
    try:
        # Path to the GGUF model file - try multiple possible locations
        possible_paths = [
            Path("mistral-7b-instruct-v0.2.Q4_K_M.gguf"),  # When run from resources/model/mistral
            Path("resources/model/mistral/mistral-7b-instruct-v0.2.Q4_K_M.gguf"),  # When run from project root
            Path(__file__).parent / "mistral-7b-instruct-v0.2.Q4_K_M.gguf"  # Relative to this script
        ]

        # Find the first existing model file
        model_path = None
        for path in possible_paths:
            if path.exists():
                model_path = path
                break

        if model_path is None:
            return {"error": f"Model file not found. Tried: {[str(p) for p in possible_paths]}"}

        # Try to use ctransformers which supports GGUF files
        try:
            from ctransformers import AutoModelForCausalLM

            # Load the model
            llm = AutoModelForCausalLM.from_pretrained(
                str(model_path),
                model_type="mistral",
                max_new_tokens=300,
                temperature=0.7,
                context_length=2048
            )

            # Generate response
            response = llm(user_input)
            return {"reply": response}

        except ImportError:
            return {"error": "ctransformers not installed. Please install with: pip install ctransformers"}

    except Exception as e:
        return {"error": f"Failed to run model: {str(e)}"}

if __name__ == "__main__":
    user_input = sys.stdin.read().strip()
    result = run_mistral_model(user_input)
    print(json.dumps(result))
