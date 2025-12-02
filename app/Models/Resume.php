<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\JobApplication;
use App\Models\User;


class Resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "resumes";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'filename',
        'fileUri',
        'summary',
        'contactDetails',
        'education',
        'skills',
        'experience',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "userId", "id");
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, "resumeId", "id");
    }
}
