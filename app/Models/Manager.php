<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Manager
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $password
 * @property string $tel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\ManagerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager newQuery()
 * @method static \Illuminate\Database\Query\Builder|Manager onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Manager withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Manager withoutTrashed()
 * @mixin \Eloquent
 */
class Manager extends Authenticatable {
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['fio', 'email', 'password', 'tel'];
}
