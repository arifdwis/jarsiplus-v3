<?php

namespace Novay\Nue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Novay\Nue\Traits\DefaultDatetimeFormat;

class ActivityLog extends Model
{
    use DefaultDatetimeFormat;

    protected $fillable = ['user_id', 'path', 'method', 'ip', 'input'];

    public static $methodColors = [
        'GET'    => 'success',
        'POST'   => 'warning',
        'PUT'    => 'info',
        'DELETE' => 'danger',
    ];

    public static $methods = [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH',
        'LINK', 'UNLINK', 'COPY', 'HEAD', 'PURGE',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('nue.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('nue.database.user_activities_table'));

        parent::__construct($attributes);
    }

    /**
     * Log belongs to users.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('nue.database.users_model'));
    }
}