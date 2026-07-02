<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'frontend_url',
        'template_key',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function default(): self
    {
        return static::firstOrCreate(
            ['slug' => 'default'],
            [
                'title' => 'Undangan Default',
                'template_key' => 'default',
                'is_active' => true,
            ]
        );
    }

    public function getPublicUrlAttribute(): string
    {
        if ($this->frontend_url) {
            $url = rtrim($this->frontend_url, '/');
            $path = parse_url($url, PHP_URL_PATH);

            if ($path === null || $path === '' || $path === '/') {
                return $url.'/'.$this->slug;
            }

            return $url;
        }

        return route('public.invitation.show', $this);
    }

    public function heroSections(): HasMany
    {
        return $this->hasMany(HeroSection::class);
    }

    public function couples(): HasMany
    {
        return $this->hasMany(Couple::class);
    }

    public function eventSchedules(): HasMany
    {
        return $this->hasMany(EventSchedule::class);
    }

    public function loveStories(): HasMany
    {
        return $this->hasMany(LoveStory::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
