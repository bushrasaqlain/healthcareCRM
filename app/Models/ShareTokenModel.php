<?php

namespace App\Models;

use CodeIgniter\Model;

class ShareTokenModel extends Model
{
    protected $table = 'share_tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_id', 'token', 'created_at', 'expires_at', 'view_count'];
    protected $useTimestamps = false;
    
    public function getValidToken($bookingId, $token)
    {
        return $this->where('booking_id', $bookingId)
                    ->where('token', $token)
                    ->where('expires_at >', date('Y-m-d H:i:s'))
                    ->first();
    }
    
    public function cleanupExpired()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
    
    public function getTokensByBooking($bookingId)
    {
        return $this->where('booking_id', $bookingId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}