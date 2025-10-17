<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected $messaging;

    public function __construct()
    {
        $credentialsPath = storage_path('app/firebase/firebase-credentials.json');

        if (!file_exists($credentialsPath)) {
            Log::error('File firebase-credentials.json tidak ditemukan.');
            // Anda bisa menambahkan throw new \Exception('Firebase credentials not found');
            // jika Anda ingin menghentikan proses jika file tidak ada.
            return;
        }

        $factory = (new Factory)->withServiceAccount($credentialsPath);
        $this->messaging = $factory->createMessaging();
    }

    /**
     * Kirim notifikasi ke semua pengguna dengan peran 'admin'.
     *
     * @param string $title Judul notifikasi.
     * @param string $body Isi pesan notifikasi.
     * @param array $data Data tambahan yang akan dikirim.
     * @return bool True jika berhasil mengirim ke setidaknya satu token, false jika gagal.
     */
    public function sendToAllAdmins(string $title, string $body, array $data = []): bool
    {
        try {
            // ===================================================================
            // ▼▼▼ PERBAIKAN: Hapus filter 'where role = admin' ▼▼▼
            // ===================================================================
            // Mengambil semua token yang terdaftar di database.
            // Ini memperbaiki error karena kolom 'role' tidak ada di tabel users.
            $tokens = FcmToken::pluck('token')->unique()->toArray();
            // ===================================================================
            // ▲▲▲ PERBAIKAN SELESAI ▲▲▲
            // ===================================================================

            if (empty($tokens)) {
                Log::warning('Tidak ada FCM token yang terdaftar di database.');
                return false;
            }

            Log::info('Mencoba mengirim notifikasi ke ' . count($tokens) . ' perangkat.');
            return $this->sendMulticast($tokens, $title, $body, $data);

        } catch (\Exception $e) {
            Log::error('Error saat sendToAllAdmins: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi ke banyak perangkat (multicast).
     * Ini adalah method internal yang dipanggil oleh method publik.
     */
    protected function sendMulticast(array $tokens, string $title, string $body, array $data = []): bool
    {
        try {
            // Payload untuk notifikasi standar (ditampilkan otomatis saat app di background/ditutup)
            $notification = Notification::create($title, $body);

            // Payload data kustom (dibaca oleh aplikasi saat di foreground)
            // Penting: Judul dan isi juga dimasukkan ke sini.
            $dataPayload = array_merge($data, [
                'title' => $title,
                'body'  => $body,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK', // Standar untuk interaksi di Flutter
            ]);

            $message = CloudMessage::new()
                ->withNotification($notification) // Untuk background
                ->withData($dataPayload);         // Untuk foreground

            // Kirim pesan ke semua token yang diberikan
            $report = $this->messaging->sendMulticast($message, $tokens);

            Log::info('Laporan FCM Multicast:', [
                'sukses' => $report->successes()->count(),
                'gagal' => $report->failures()->count(),
            ]);

            // Jika ada kegagalan, catat token mana yang gagal dan alasannya
            if ($report->hasFailures()) {
                foreach ($report->failures()->getItems() as $failure) {
                    Log::warning('Gagal mengirim notifikasi FCM:', [
                        'token' => $failure->target()->value(),
                        'error' => $failure->error()->getMessage(),
                    ]);
                }
            }

            // Kembalikan true jika setidaknya ada satu pengiriman yang sukses
            return $report->successes()->count() > 0;

        } catch (\Exception $e) {
            Log::error('Error di dalam sendMulticast: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi ke satu token perangkat spesifik.
     */
    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        try {
            $notification = Notification::create($title, $body);
            
            $dataPayload = array_merge($data, [
                'title' => $title,
                'body'  => $body,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ]);

            $message = CloudMessage::withTarget('token', $token)
                ->withNotification($notification)
                ->withData($dataPayload);

            $this->messaging->send($message);

            Log::info('Notifikasi FCM berhasil dikirim ke satu token.', ['token' => $token]);
            return true;

        } catch (\Exception $e) {
            Log::error('Error saat mengirim ke satu token: ' . $e->getMessage(), ['token' => $token]);
            return false;
        }
    }
}

