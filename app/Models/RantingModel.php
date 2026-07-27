<?php

namespace App\Models;

use CodeIgniter\Model;

class RantingModel extends Model
{
    protected $table            = 'ranting';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_ranting', 'id_cabang'];
}
