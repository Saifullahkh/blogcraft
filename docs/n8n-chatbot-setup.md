# n8n Blog Chatbot Setup

This project is already wired to send chat messages to a Laravel endpoint at `/chatbot/message`. Laravel forwards those messages to n8n.

## Import the workflow

1. Open n8n.
2. Go to Workflows > Import from file.
3. Import `docs/n8n-blog-chatbot-workflow.json`.
4. Set `OPENAI_API_KEY` in n8n variables or environment variables.
5. Activate the workflow.

## If using n8n Chat Trigger / AI Agent

If your workflow starts with **When chat message received** and then connects to an **AI Agent**, use the Chat Trigger node's production **Chat URL** as `N8N_CHATBOT_WEBHOOK_URL`.

In the Chat Trigger node:

1. Turn on **Make Chat Publicly Available**.
2. Use **Embedded Chat** mode if Laravel is providing the chat UI.
3. Add your Laravel site URL to **Allowed Origin (CORS)**, or use `*` while testing locally.
4. Set **Response Mode** to **When Last Node Finishes** unless you have a response node.
5. Publish/activate the workflow.

The Laravel app sends `action`, `sessionId`, `chatInput`, `message`, and `metadata` so it can work with both Chat Trigger and plain Webhook workflows.

If your AI Agent uses Google Gemini instead of OpenAI, check the Gemini credential/model node in n8n. `OPENAI_API_KEY` is only needed for the imported OpenAI workflow below.

## No Respond to Webhook node found

If n8n returns `No Respond to Webhook node found in the workflow`, your Webhook node is set to respond using a separate Respond to Webhook node.

Use one of these fixes:

1. Open the Webhook node and set **Respond** to **When Last Node Finishes**.
2. Or add **Respond to Webhook** after the final AI Agent/formatter node and return JSON like:

```json
{
  "reply": "={{ $json.output || $json.text || $json.message }}"
}
```

For the simplest Laravel chatbot flow, use:

```txt
Webhook -> AI Agent -> Respond to Webhook
```

or:

```txt
Webhook -> AI Agent
```

with Webhook **Respond** set to **When Last Node Finishes**.

## Laravel webhook URL

For local self-hosted n8n, use:

```env
N8N_CHATBOT_WEBHOOK_URL=http://localhost:5678/webhook/31740745-4c5f-4c1c-948a-80b08561a1a9
```

For n8n Cloud, replace it with the production webhook URL from the Webhook node. It should end with:

```txt
/webhook/31740745-4c5f-4c1c-948a-80b08561a1a9
```

After changing `.env`, run:

```bash
php artisan config:clear
```

## Test n8n directly

```bash
curl -X POST http://localhost:5678/webhook/31740745-4c5f-4c1c-948a-80b08561a1a9 \
  -H "Content-Type: application/json" \
  -d "{\"message\":\"Hello\",\"chat_id\":\"test\",\"page_url\":\"http://localhost:8000\"}"
```

Expected response:

```json
{
  "reply": "..."
}
```
