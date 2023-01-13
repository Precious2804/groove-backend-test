<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenInvestment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function token()
    {
        return $this->belongsTo(ProjectToken::class, 'token_id');
    }
}
