<?php
// File: app/Http/Controllers/Api/FcmController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Log;

class FcmController extends Controller
{
    public function saveToken(Request $request)
    {
        try {
            Log::info('Request diterima di saveToken', $request->all());

            // Validasi input
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'fcm_token' => 'required|string',
            ]);

            // Ambil user
            $user = User::find($validated['user_id']);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.'
                ], 404);
            }

            // Simpan token
            $fcmToken = $user->fcmTokens()->updateOrCreate(
                ['token' => $validated['fcm_token']],
                ['token' => $validated['fcm_token']]
            );

            Log::info('FCM Token berhasil disimpan', [
                'user_id' => $validated['user_id'],
                'token_id' => $fcmToken->id,
                'token_preview' => substr($validated['fcm_token'], 0, 30) . '...'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Token berhasil disimpan.',
                'data' => [
                    'token_id' => $fcmToken->id,
                    'user_id' => $user->id
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error saving FCM token', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan token: ' . $e->getMessage()
            ], 500);
        }
    }
}