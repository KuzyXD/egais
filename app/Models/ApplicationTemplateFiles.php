<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationTemplateFiles
 *
 * @property int $id
 * @property int $application_template_id
 * @property string $type
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereApplicationTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationTemplateFiles whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationTemplateFiles extends Model {
}