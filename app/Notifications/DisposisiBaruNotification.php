<?php

namespace App\Notifications;

use App\Models\Disposisi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisposisiBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Disposisi $disposisi;

    /**
     * Create a new notification instance.
     */
    public function __construct(Disposisi $disposisi)
    {
        $this->disposisi = $disposisi;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Kita akan mengirim notifikasi melalui database dan email
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('surat.lihat', $this->disposisi->surat_masuk_id);

        return (new MailMessage)
                    ->subject('Disposisi Tugas Baru')
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Anda telah menerima disposisi tugas baru dari ' . $this->disposisi->pengirim->name . '.')
                    ->line('Perihal Surat: ' . $this->disposisi->suratMasuk->perihal)
                    ->line('Isi Instruksi: "' . $this->disposisi->isi_disposisi . '"')
                    ->action('Lihat Detail Surat', $url)
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Data ini yang akan disimpan di tabel notifications (untuk notifikasi in-app)
        return [
            'surat_id' => $this->disposisi->surat_masuk_id,
            'pengirim_nama' => $this->disposisi->pengirim->name,
            'pesan' => 'Anda menerima disposisi baru dari ' . $this->disposisi->pengirim->name . '.',
        ];
    }
}
