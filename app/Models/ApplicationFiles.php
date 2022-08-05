<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationFiles
 *
 * @property int $id
 * @property int $application_id
 * @property string $type
 * @property string $path
 * @property string $sig_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereSigPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationFiles whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationFiles extends Model {
}