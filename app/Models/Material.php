<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'created_by',
        'title',
        'slug',
        'content',
        'thumbnail',
        'order',
        'status',
        'view_count',
    ];

    protected $casts = [
        'order'      => 'integer',
        'view_count' => 'integer',
    ];

    protected $appends = ['is_new', 'thumbnail_url'];
 
    // ─────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────

    /** Materi dianggap "Baru" jika dibuat ≤ 5 hari yang lalu */
    public function getIsNewAttribute(): bool
    {
        return $this->created_at->diffInDays(now()) <= 5;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_new ? 'Baru' : 'Lama';
    }

    /** URL thumbnail, fallback ke placeholder */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        return asset('images/default-material.png');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    // ─────────────────────────────────────────
    // SCOPES
    // ─────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeNew($query)
    {
        return $query->where('created_at', '>=', now()->subDays(5));
    }
 
    // ─────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────

    /** Tambah view count +1 */
    public function incrementView(): void
    {
        $this->increment('view_count');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    // ─────────────────────────────────────────
    // RELATIONS
    // ─────────────────────────────────────────

    public function userProgress()
    {
        return $this->hasOne(MaterialProgress::class, 'material_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function videos()
    {
        return $this->hasMany(MaterialVideo::class)->orderBy('order');
    }

    public function progress()
    {
        return $this->hasMany(MaterialProgress::class);
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'material_progress')
            ->wherePivot('is_completed', true)
            ->withPivot('completed_at');
    }
}
