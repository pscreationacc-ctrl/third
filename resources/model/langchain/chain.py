#!/usr/bin/env python3
import sys
import json
import os
import subprocess
from langchain_core.prompts import ChatPromptTemplate, MessagesPlaceholder
from langchain_core.output_parsers import StrOutputParser

# Use subprocess to call the existing working Python script
from langchain_core.runnables.history import RunnableWithMessageHistory
from langchain_core.chat_history import InMemoryChatMessageHistory
from langchain_core.runnables import RunnablePassthrough

class MistralSubprocessLLM:
    """Custom LLM that calls the existing Mistral Python script"""

    def __init__(self):
        self.mistral_script = os.path.join(os.path.dirname(__file__), "..", "mistral", "Modelfile.py")

    def __call__(self, input_text):
        """Call the Mistral script and return the response"""
        try:
            # Convert input_text to string if it's a prompt value
            if hasattr(input_text, 'to_string'):
                input_text = input_text.to_string()
            elif not isinstance(input_text, str):
                input_text = str(input_text)

            # Call the Python script as subprocess
            result = subprocess.run(
                [sys.executable, self.mistral_script],
                input=input_text,
                capture_output=True,
                text=True,
                check=True
            )
            # Parse the JSON response
            response_data = json.loads(result.stdout.strip())
            return response_data.get('reply', 'No response from model')
        except subprocess.CalledProcessError as e:
            return f"Error calling Mistral model: {e.stderr}"
        except json.JSONDecodeError:
            return "Error parsing model response"

def setup_langchain():
    """Initialize LangChain with conversation memory"""
    try:
        # Initialize our custom LLM wrapper
        llm = MistralSubprocessLLM()

        # Create prompt template with conversation history
        prompt = ChatPromptTemplate.from_messages([
            ("system", "You are a helpful AI assistant with memory of past conversations."),
            MessagesPlaceholder(variable_name="chat_history"),
            ("human", "{input}")
        ])

        # Create the conversation chain
        chain = prompt | llm | StrOutputParser()

        return chain

    except Exception as e:
        print(json.dumps({"error": f"Failed to initialize LangChain: {str(e)}"}))
        sys.exit(1)

def process_conversation(input_text, chat_history=None):
    """Process conversation using LangChain with memory"""
    try:
        chain = setup_langchain()

        # Set up memory
        chat_message_history = InMemoryChatMessageHistory()

        # Add chat history to memory if provided
        if chat_history:
            for message in chat_history:
                chat_message_history.add_user_message(message['user'])
                chat_message_history.add_ai_message(message['ai'])

        # Create chain with message history
        chain_with_history = RunnableWithMessageHistory(
            chain,
            lambda session_id: chat_message_history,
            input_messages_key="input",
            history_messages_key="chat_history",
        )

        # Prepare the input
        config = {"configurable": {"session_id": "conversation_1"}}

        # Get response from LangChain
        response = chain_with_history.invoke(
            {"input": input_text},
            config=config,
        )

        # Get updated chat history
        updated_history = []
        messages = chat_message_history.messages
        for i in range(0, len(messages), 2):
            if i+1 < len(messages):
                updated_history.append({
                    "user": messages[i].content,
                    "ai": messages[i+1].content
                })

        return {
            "response": response,
            "memory": updated_history
        }

    except Exception as e:
        return {"error": f"LangChain processing failed: {str(e)}"}

if __name__ == "__main__":
    # Read input from stdin
    input_data = sys.stdin.read().strip()
    try:
        data = json.loads(input_data)
        text = data.get('text', '')
        history = data.get('history', [])

        result = process_conversation(text, history)
        print(json.dumps(result))

    except json.JSONDecodeError:
        # Simple text input (backward compatibility)
        result = process_conversation(input_data)
        print(json.dumps(result))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
