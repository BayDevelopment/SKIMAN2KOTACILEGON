<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    protected $appends = ['is_new'];
 
    // ─────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────

    /**
     * Kategori dianggap "Baru" jika dibuat ≤ 5 hari yang lalu.
     */
    public function getIsNewAttribute(): bool
    {
        return $this->created_at->diffInDays(now()) <= 5;
    }

    /**
     * Label teks: "Baru" atau "Lama"
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_new ? 'Baru' : 'Lama';
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
 
    // ─────────────────────────────────────────
    // SCOPES
    // ─────────────────────────────────────────

    /** Hanya kategori yang aktif */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Hanya kategori yang dibuat ≤ 5 hari */
    public function scopeNew($query)
    {
        return $query->where('created_at', '>=', now()->subDays(5));
    }

    /** Urutkan berdasarkan field order */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // ─────────────────────────────────────────
    // RELATIONS
    // ─────────────────────────────────────────

    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }

    public function publishedMaterials()
    {
        return $this->hasMany(Material::class)->where('status', 'published');
    }
}
