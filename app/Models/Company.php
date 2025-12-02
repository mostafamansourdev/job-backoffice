<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;


    protected $table = "companies";

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "name",
        "address",
        "industry",
        "website",
        'ownerId', // user relation with the "company owner" role
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime'
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "ownerId", "id");
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, "companyId", "id");
    }

    public function jobApplications()
    {
        return $this->hasManyThrough(
            JobApplication::class,
            JobVacancy::class,
            'companyId', // Foreign key on JobVacancy table...
            'jobVacancyId', // Foreign key on JobApplication table...
            'id', // Local key on Company table...
            'id'  // Local key on JobVacancy table...
        );
    }
}
