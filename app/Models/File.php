<?php

namespace App\Models;

use App\Builders\FileBuilder;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\File
 *
 * @property string $id
 * @property string $name
 * @property string|null $mime_type
 * @property bool $is_published
 * @property int $size
 * @property string $disk
 * @property string $path
 * @property string|null $type
 * @property array|null $additional
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobTranslation[] $jobTranslations
 * @property-read int|null $job_translations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostTranslation[] $postTranslations
 * @property-read int|null $post_translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static FileBuilder|File filter(\App\Filters\Filter $filter)
 * @method static \App\Builders\FileBuilder|BaseModel isPublished()
 * @method static FileBuilder|File newModelQuery()
 * @method static FileBuilder|File newQuery()
 * @method static \Illuminate\Database\Query\Builder|File onlyTrashed()
 * @method static \App\Builders\FileBuilder|BaseModel permission($permissions)
 * @method static FileBuilder|File query()
 * @method static \App\Builders\FileBuilder|BaseModel role($roles, $guard = null)
 * @method static FileBuilder|File sortBy(\App\Sorts\Sort $sort)
 * @method static FileBuilder|File whereAdditional($value)
 * @method static FileBuilder|File whereCreatedAt($value)
 * @method static FileBuilder|File whereCreatedBy($value)
 * @method static FileBuilder|File whereDateRange(string $column, array $value = [])
 * @method static FileBuilder|File whereDateTime($column, $operator = null, $value = null)
 * @method static FileBuilder|File whereDeletedAt($value)
 * @method static FileBuilder|File whereDeletedBy($value)
 * @method static FileBuilder|File whereDisk($value)
 * @method static FileBuilder|File whereEndsWith($column, $value = null)
 * @method static FileBuilder|File whereEqual($column, $value = null)
 * @method static FileBuilder|File whereId($value)
 * @method static FileBuilder|File whereIsPublished($value)
 * @method static FileBuilder|File whereLike($column, $value = null)
 * @method static FileBuilder|File whereMimeType($value)
 * @method static FileBuilder|File whereName($value)
 * @method static FileBuilder|File whereNotEqual($column, $value = null)
 * @method static FileBuilder|File wherePath($value)
 * @method static FileBuilder|File whereSize($value)
 * @method static FileBuilder|File whereStartsWith($column, $value = null)
 * @method static FileBuilder|File whereType($value)
 * @method static FileBuilder|File whereUpdatedAt($value)
 * @method static FileBuilder|File whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|File withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BannerTranslation[] $bannerTranslations
 * @property-read int|null $banner_translations_count
 */
class File extends BaseModel
{
    protected $table = 'files';

    public function provideCustomBuilder()
    {
        return FileBuilder::class;
    }

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'mime_type',
        'is_published',
        'type',
        'size',
        'disk',
        'name_file',
        'path',
        'additional',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'additional'   => 'json',
        'is_published' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = ['url'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function postTranslations()
    {
        return $this->morphToMany(PostTranslation::class, 'model', 'model_has_files');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function bannerTranslations()
    {
        return $this->morphToMany(BannerTranslation::class, 'model', 'model_has_files');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function jobTranslations()
    {
        return $this->morphToMany(JobTranslation::class, 'model', 'model_has_files');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function contacts()
    {
        return $this->morphToMany(Contact::class, 'model', 'model_has_files');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function visitorFileSetting()
    {
        return $this->morphToMany(VisitorFileSetting::class, 'model', 'model_has_files');
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        $disk = $this->attributes['disk'];
        $path = $this->attributes['path'];
        switch ($disk) {
            case 's3':
                return (string) Storage::disk('s3')->url($path);
            case 'public':
                return route_ui('file.show', ['path' => $path.'?'.now()->timestamp]);
            default:
                return '';
        }
    }

    public function getNameFileAttribute() {
        if ($pos = mb_strpos($this->name, '_')) {
            return mb_substr($this->name, $pos + 1);
        }
        return $this->name;
    }
}
