#!/usr/bin/env python3
import sys
import os

print("Python version:", sys.version)
print("Current working directory:", os.getcwd())
print("Script directory:", os.path.dirname(os.path.abspath(__file__)))

# Test import
try:
    from ctransformers import AutoModelForCausalLM
    print("ctransformers imported successfully")
except ImportError as e:
    print("Import error:", e)

# Test model file existence
model_path = "mistral-7b-instruct-v0.2.Q4_K_M.gguf"
if os.path.exists(model_path):
    print("Model file exists:", model_path)
else:
    print("Model file NOT found:", model_path)

# Try to load model
try:
    llm = AutoModelForCausalLM.from_pretrained(
        model_path,
        model_type="mistral",
        max_new_tokens=50,
        temperature=0.7,
        context_length=2048
    )
    response = llm("Hello")
    print("Model response:", response)
except Exception as e:
    print("Model loading error:", str(e))
