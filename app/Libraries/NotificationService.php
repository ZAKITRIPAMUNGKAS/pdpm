<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;
use App\Models\UserModel;

class NotificationService
{
    protected $email;
    protected $userModel;
    protected $cache;

    public function __construct()
    {
        $this->email = \Config\Services::email();
        $this->userModel = new UserModel();
        $this->cache = \Config\Services::cache();
        helper(['cache', 'security']);
    }

    /**
     * Send email notification
     *
     * @param string|array $to Recipient email(s)
     * @param string $subject Email subject
     * @param string $message Email message
     * @param array $data Additional data for template
     * @param string $template Email template name
     * @return bool Success status
     */
    public function sendEmail($to, string $subject, string $message, array $data = [], string $template = null): bool
    {
        try {
            // Configure email
            $config = [
                'protocol'    => 'smtp',
                'SMTPHost'    => env('email.SMTPHost', 'localhost'),
                'SMTPUser'    => env('email.SMTPUser', ''),
                'SMTPPass'    => env('email.SMTPPass', ''),
                'SMTPPort'    => env('email.SMTPPort', 587),
                'SMTPCrypto'  => env('email.SMTPCrypto', 'tls'),
                'mailType'    => 'html',
                'charset'     => 'utf-8',
                'wordWrap'    => true
            ];

            $this->email->initialize($config);

            // Set email details
            $this->email->setFrom(env('email.fromEmail', 'noreply@pdpmkaranganyar.org'), 'PDPM Karanganyar');
            $this->email->setTo($to);
            $this->email->setSubject($subject);

            // Use template if provided
            if ($template) {
                $emailContent = $this->renderEmailTemplate($template, array_merge($data, [
                    'subject' => $subject,
                    'message' => $message
                ]));
                $this->email->setMessage($emailContent);
            } else {
                $this->email->setMessage($message);
            }

            $result = $this->email->send();

            // Log email sending
            log_security_event('email_sent', 'Email notification sent', [
                'to' => is_array($to) ? implode(', ', $to) : $to,
                'subject' => $subject,
                'template' => $template,
                'success' => $result
            ]);

            return $result;

        } catch (\Exception $e) {
            log_message('error', 'Email sending failed: ' . $e->getMessage());
            log_security_event('email_failed', 'Email notification failed', [
                'to' => is_array($to) ? implode(', ', $to) : $to,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send notification to user by ID
     *
     * @param int $userId User ID
     * @param string $type Notification type
     * @param string $title Notification title
     * @param string $message Notification message
     * @param array $data Additional data
     * @return bool Success status
     */
    public function notifyUser(int $userId, string $type, string $title, string $message, array $data = []): bool
    {
        $user = $this->userModel->find($userId);
        if (!$user) {
            return false;
        }

        // Store in-app notification
        $this->storeNotification($userId, $type, $title, $message, $data);

        // Send email if user has email notifications enabled
        if ($user['email_notifications'] ?? true) {
            return $this->sendEmail(
                $user['email'],
                $title,
                $message,
                array_merge($data, ['user' => $user]),
                $this->getEmailTemplate($type)
            );
        }

        return true;
    }

    /**
     * Send bulk notifications
     *
     * @param array $userIds Array of user IDs
     * @param string $type Notification type
     * @param string $title Notification title
     * @param string $message Notification message
     * @param array $data Additional data
     * @return array Results array
     */
    public function notifyUsers(array $userIds, string $type, string $title, string $message, array $data = []): array
    {
        $results = [];
        
        foreach ($userIds as $userId) {
            $results[$userId] = $this->notifyUser($userId, $type, $title, $message, $data);
        }

        return $results;
    }

    /**
     * Send notification to all users with specific role
     *
     * @param string $role User role
     * @param string $type Notification type
     * @param string $title Notification title
     * @param string $message Notification message
     * @param array $data Additional data
     * @return array Results array
     */
    public function notifyByRole(string $role, string $type, string $title, string $message, array $data = []): array
    {
        $users = $this->userModel->where('role', $role)->where('status', 'Aktif')->findAll();
        $userIds = array_column($users, 'id');
        
        return $this->notifyUsers($userIds, $type, $title, $message, $data);
    }

    /**
     * Send notification about new berita
     *
     * @param array $berita Berita data
     * @return array Results
     */
    public function notifyNewBerita(array $berita): array
    {
        $title = 'Berita Baru: ' . $berita['judul'];
        $message = 'Berita baru telah dipublikasikan. Klik untuk membaca selengkapnya.';
        
        $data = [
            'berita_id' => $berita['id'],
            'berita_slug' => $berita['slug'],
            'berita_url' => base_url('berita/' . $berita['slug']),
            'action_text' => 'Baca Berita',
            'action_url' => base_url('berita/' . $berita['slug'])
        ];

        // Notify all active members
        $users = $this->userModel->where('status', 'Aktif')->whereNotIn('id_role', [1, 2])->findAll();
        $userIds = array_column($users, 'id');

        return $this->notifyUsers($userIds, 'new_berita', $title, $message, $data);
    }

    /**
     * Send notification about new agenda
     *
     * @param array $agenda Agenda data
     * @return array Results
     */
    public function notifyNewAgenda(array $agenda): array
    {
        $title = 'Agenda Baru: ' . $agenda['nama_kegiatan'];
        $message = 'Agenda kegiatan baru telah dijadwalkan. Daftarkan diri Anda sekarang.';
        
        $data = [
            'agenda_id' => $agenda['id'],
            'agenda_url' => base_url('absensi/agenda/' . $agenda['id']),
            'tanggal' => date('d F Y', strtotime($agenda['tanggal_mulai'])),
            'waktu' => date('H:i', strtotime($agenda['tanggal_mulai'])),
            'action_text' => 'Lihat Agenda',
            'action_url' => base_url('absensi/agenda/' . $agenda['id'])
        ];

        // Notify all active members
        $users = $this->userModel->where('status', 'Aktif')->whereNotIn('id_role', [1, 2])->findAll();
        $userIds = array_column($users, 'id');

        return $this->notifyUsers($userIds, 'new_agenda', $title, $message, $data);
    }

    /**
     * Send agenda reminder notification
     *
     * @param array $agenda Agenda data
     * @param int $hoursBefore Hours before event
     * @return array Results
     */
    public function sendAgendaReminder(array $agenda, int $hoursBefore = 24): array
    {
        $title = 'Pengingat: ' . $agenda['nama_kegiatan'];
        $message = "Kegiatan akan dimulai dalam {$hoursBefore} jam. Jangan lupa untuk hadir tepat waktu.";
        
        $data = [
            'agenda_id' => $agenda['id'],
            'agenda_url' => base_url('absensi/agenda/' . $agenda['id']),
            'tanggal' => date('d F Y', strtotime($agenda['tanggal_mulai'])),
            'waktu' => date('H:i', strtotime($agenda['tanggal_mulai'])),
            'lokasi' => $agenda['lokasi'] ?? 'Lokasi akan diinformasikan',
            'action_text' => 'Lihat Detail',
            'action_url' => base_url('absensi/agenda/' . $agenda['id'])
        ];

        // Get registered participants
        $db = \Config\Database::connect();
        $participants = $db->table('agenda_peserta')
                          ->select('user_id')
                          ->where('agenda_id', $agenda['id'])
                          ->where('status', 'terdaftar')
                          ->get()
                          ->getResultArray();

        $userIds = array_column($participants, 'user_id');

        return $this->notifyUsers($userIds, 'agenda_reminder', $title, $message, $data);
    }

    /**
     * Store in-app notification
     *
     * @param int $userId User ID
     * @param string $type Notification type
     * @param string $title Notification title
     * @param string $message Notification message
     * @param array $data Additional data
     * @return bool Success status
     */
    protected function storeNotification(int $userId, string $type, string $title, string $message, array $data = []): bool
    {
        $db = \Config\Database::connect();
        
        // Create notifications table if not exists
        $this->createNotificationsTable();

        $notificationData = [
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => json_encode($data),
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $db->table('notifications')->insert($notificationData);
    }

    /**
     * Get email template for notification type
     *
     * @param string $type Notification type
     * @return string Template name
     */
    protected function getEmailTemplate(string $type): string
    {
        $templates = [
            'new_berita' => 'email_new_berita',
            'new_agenda' => 'email_new_agenda',
            'agenda_reminder' => 'email_agenda_reminder',
            'registration_approved' => 'email_registration_approved',
            'password_reset' => 'email_password_reset'
        ];

        return $templates[$type] ?? 'email_default';
    }

    /**
     * Render email template
     *
     * @param string $template Template name
     * @param array $data Template data
     * @return string Rendered HTML
     */
    protected function renderEmailTemplate(string $template, array $data): string
    {
        // Cache template for performance
        $cacheKey = "email_template_{$template}";
        
        $templateContent = cache_remember(
            $cacheKey,
            3600, // 1 hour
            function() use ($template) {
                $templatePath = APPPATH . "Views/emails/{$template}.php";
                
                if (file_exists($templatePath)) {
                    return file_get_contents($templatePath);
                }
                
                // Return default template if specific template not found
                return $this->getDefaultEmailTemplate();
            }
        );

        // Replace placeholders with actual data
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $templateContent = str_replace("{{$key}}", $value, $templateContent);
            }
        }

        return $templateContent;
    }

    /**
     * Get default email template
     *
     * @return string Default template HTML
     */
    protected function getDefaultEmailTemplate(): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{subject}</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #dc3545, #000000); color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
                .btn { display: inline-block; padding: 12px 24px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>PDPM Karanganyar</h1>
                </div>
                <div class="content">
                    <h2>{subject}</h2>
                    <p>{message}</p>
                    {action_url ? <p><a href="{action_url}" class="btn">{action_text}</a></p> : ""}
                </div>
                <div class="footer">
                    <p>&copy; ' . date('Y') . ' Pimpinan Daerah Pemuda Muhammadiyah Karanganyar</p>
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
                </div>
            </div>
        </body>
        </html>';
    }

    /**
     * Create notifications table if not exists
     */
    protected function createNotificationsTable(): void
    {
        $db = \Config\Database::connect();
        
        if (!$db->tableExists('notifications')) {
            $forge = \Config\Database::forge();
            
            $forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true
                ],
                'type' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'message' => [
                    'type' => 'TEXT'
                ],
                'data' => [
                    'type' => 'JSON',
                    'null' => true
                ],
                'is_read' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0
                ],
                'created_at' => [
                    'type' => 'DATETIME'
                ],
                'read_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ]
            ]);
            
            $forge->addKey('id', true);
            $forge->addKey('user_id');
            $forge->addKey(['type', 'created_at']);
            
            $forge->createTable('notifications');
        }
    }

    /**
     * Get user notifications
     *
     * @param int $userId User ID
     * @param bool $unreadOnly Get only unread notifications
     * @param int $limit Limit results
     * @return array Notifications
     */
    public function getUserNotifications(int $userId, bool $unreadOnly = false, int $limit = 50): array
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('notifications')
                     ->where('user_id', $userId)
                     ->orderBy('created_at', 'DESC')
                     ->limit($limit);
        
        if ($unreadOnly) {
            $builder->where('is_read', 0);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Mark notification as read
     *
     * @param int $notificationId Notification ID
     * @param int $userId User ID
     * @return bool Success status
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        $db = \Config\Database::connect();
        
        return $db->table('notifications')
                 ->where('id', $notificationId)
                 ->where('user_id', $userId)
                 ->update([
                     'is_read' => 1,
                     'read_at' => date('Y-m-d H:i:s')
                 ]);
    }

    /**
     * Mark all notifications as read for user
     *
     * @param int $userId User ID
     * @return bool Success status
     */
    public function markAllAsRead(int $userId): bool
    {
        $db = \Config\Database::connect();
        
        return $db->table('notifications')
                 ->where('user_id', $userId)
                 ->where('is_read', 0)
                 ->update([
                     'is_read' => 1,
                     'read_at' => date('Y-m-d H:i:s')
                 ]);
    }

    /**
     * Get unread notification count for user
     *
     * @param int $userId User ID
     * @return int Unread count
     */
    public function getUnreadCount(int $userId): int
    {
        $db = \Config\Database::connect();
        
        return $db->table('notifications')
                 ->where('user_id', $userId)
                 ->where('is_read', 0)
                 ->countAllResults();
    }
}
