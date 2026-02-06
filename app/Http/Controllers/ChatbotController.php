<?php

namespace App\Http\Controllers;

use App\Models\Chatbot;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    /**
     * Handle chatbot message and return response
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        try {
            // Get message from request
            $message = $request->input('message', '');
            
            // Check if message is empty
            if (empty(trim($message))) {
                return response()->json([
                    'reply' => "I didn't receive a message. Please try again."
                ]);
            }
            
            // Create chatbot instance and get response
            $chatbot = new Chatbot();
            $response = $chatbot->getResponse($message);
            
            // Return JSON response
            return response()->json([
                'reply' => $response
            ]);
            
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error("Chatbot Error: " . $e->getMessage());
            
            return response()->json([
                'reply' => 'Sorry, I encountered an error. Please try again.'
            ], 500);
        }
    }
}
