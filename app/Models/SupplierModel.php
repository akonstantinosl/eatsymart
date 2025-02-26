<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    protected $useAutoIncrement = false;
    protected $useSoftDeletes   = false;
    protected $allowedFields = [
        'supplier_id',
        'supplier_name',
        'supplier_phone',
        'supplier_email',
        'supplier_address',
        'supplier_status',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
