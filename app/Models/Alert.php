<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $fillable = [
        'title',
        'message', 
        'level',
        'category',
        'is_read',
        'related_model',
        'related_id',
        'action_url',
        'metadata',
        'user_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the alert.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model.
     */
    public function related()
    {
        if ($this->related_model && $this->related_id) {
            return $this->related_model::find($this->related_id);
        }
        return null;
    }

    /**
     * Scope for unread alerts.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for specific level.
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope for specific category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for today's alerts.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for recent alerts (last 7 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Create a new alert.
     */
    public static function create(array $attributes = [])
    {
        // Set action URL if related model is provided
        if (isset($attributes['related_model']) && isset($attributes['related_id'])) {
            $model = $attributes['related_model'];
            $id = $attributes['related_id'];
            
            if ($model === 'App\Models\Property') {
                $attributes['action_url'] = route('properties.show', $id);
            } elseif ($model === 'App\Models\Partner') {
                $attributes['action_url'] = route('partners.show', $id);
            } elseif ($model === 'App\Models\User') {
                $attributes['action_url'] = route('users.show', $id);
            }
        }

        return parent::create($attributes);
    }

    /**
     * Mark alert as read.
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
        return $this;
    }

    /**
     * Create system alert.
     */
    public static function system($title, $message, $level = 'info', $metadata = [])
    {
        return static::create([
            'title' => $title,
            'message' => $message,
            'level' => $level,
            'category' => 'system',
            'metadata' => $metadata,
        ]);
    }

    /**
     * Create data quality alert.
     */
    public static function dataQuality($title, $message, $relatedModel = null, $relatedId = null, $level = 'warning')
    {
        return static::create([
            'title' => $title,
            'message' => $message,
            'level' => $level,
            'category' => 'data_quality',
            'related_model' => $relatedModel,
            'related_id' => $relatedId,
        ]);
    }

    /**
     * Create partner performance alert.
     */
    public static function partnerPerformance($title, $message, $partnerId = null, $level = 'info')
    {
        return static::create([
            'title' => $title,
            'message' => $message,
            'level' => $level,
            'category' => 'partner_performance',
            'related_model' => 'App\Models\Partner',
            'related_id' => $partnerId,
        ]);
    }
}
