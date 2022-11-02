<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_notification';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_user', 'judul', 'pesan', 'link', 'is_read'
    ];

    // Dates
    protected $useTimestamps = true;
}
