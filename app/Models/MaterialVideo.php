<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'title',
        'youtube_url',
        'youtube_id',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected $appends = ['embed_url'];
 
    // ─────────────────────────────────────────
    // MUTATOR — otomatis extract YouTube ID
    // ─────────────────────────────────────────

    /**
     * Saat set youtube_url, langsung extract & simpan youtube_id.
     * Support format:
     *   https://www.youtube.com/watch?v=dQw4w9WgXcQ
     *   https://youtu.be/dQw4w9WgXcQ
     *   https://www.youtube.com/embed/dQw4w9WgXcQ
     */
    public function setYoutubeUrlAttribute(string $url): void
    {
        $this->attributes['youtube_url'] = $url;

        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        $this->attributes['youtube_id'] = $matches[1] ?? null;
    }
 
    // ─────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────

    /** URL embed untuk ditampilkan di iframe */
    public function getEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_id) return null;

        return 'https://www.youtube.com/embed/' . $this->youtube_id;
    }

    /** URL thumbnail video dari YouTube */
    public function getThumbnailAttribute(): ?string
    {
        if (!$this->youtube_id) return null;

        return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
    }

    // ─────────────────────────────────────────
    // RELATIONS
    // ─────────────────────────────────────────

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
