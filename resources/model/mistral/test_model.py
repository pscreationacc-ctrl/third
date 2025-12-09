import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from Modelfile import run_mistral_model

# Test the model
print("Testing Mistral model...")
result = run_mistral_model("Hello, how are you?")
print("Result:", result)
