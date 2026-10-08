<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $webhookUrl = config('services.n8n.chatbot_url');
        $webhookMethod = strtoupper(config('services.n8n.chatbot_method', 'POST'));

        if (! $webhookUrl) {
            return response()->json([
                'reply' => 'Chatbot backend abhi configure nahi hua.',
            ], 503);
        }

        $payload = [
            'chat_id' => session()->getId(),
            'sessionId' => session()->getId(),
            'action' => 'sendMessage',
            'message' => $request->message,
            'chatInput' => $request->message,
            'page_url' => url()->previous(),
            'metadata' => [
                'page_url' => url()->previous(),
            ],
        ];

        try {
            $pendingRequest = Http::timeout(20)->acceptJson();
            $response = $webhookMethod === 'GET'
                ? $pendingRequest->get($webhookUrl, $payload)
                : $pendingRequest->post($webhookUrl, $payload);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'reply' => 'n8n chatbot se connect nahi ho saka. n8n workflow active hai ya nahi check karein.',
            ], 502);
        }

        if ($response->failed()) {
            $n8nMessage = $response->json('hint') ?: $response->json('message');

            if ($n8nMessage && str_contains(strtolower($n8nMessage), 'workflow must be active')) {
                return response()->json([
                    'reply' => 'n8n workflow abhi active/published nahi hai. n8n editor ke top-right se workflow publish/activate karein, phir chatbot dobara test karein.',
                ], 502);
            }

            if ($n8nMessage && str_contains(strtolower($n8nMessage), 'no respond to webhook node found')) {
                return response()->json([
                    'reply' => 'n8n Webhook node response ka wait kar raha hai, lekin workflow mein Respond to Webhook node nahi mila. Webhook node ka Respond setting "When Last Node Finishes" kar dein, ya AI Agent ke baad Respond to Webhook node add karein.',
                ], 502);
            }

            return response()->json([
                'reply' => $n8nMessage
                    ? 'n8n error: '.$n8nMessage
                    : 'n8n workflow response nahi de raha. Webhook URL, workflow activation, aur AI credential check karein.',
            ], 502);
        }

        $responseData = $response->json();
        $firstItem = is_array($responseData) && array_is_list($responseData)
            ? ($responseData[0] ?? [])
            : [];

        $reply = data_get($responseData, 'reply')
            ?? data_get($responseData, 'output')
            ?? data_get($responseData, 'text')
            ?? data_get($responseData, 'answer')
            ?? data_get($responseData, 'message')
            ?? data_get($firstItem, 'reply')
            ?? data_get($firstItem, 'output')
            ?? data_get($firstItem, 'text')
            ?? data_get($firstItem, 'answer')
            ?? data_get($firstItem, 'message');

        if ($reply === 'Workflow was started') {
            $reply = 'n8n workflow start ho gaya, lekin AI reply wapas return nahi kar raha. Webhook node ka Response Mode "When Last Node Finishes" ya "Using Respond to Webhook Node" set karein.';
        }

        return response()->json([
            'reply' => $reply ?? 'Sorry, mujhe response nahi mila.',
        ]);
    }
}
