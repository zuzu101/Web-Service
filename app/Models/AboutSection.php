<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/aboutUS.png'); // Default image
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Delete image when model is deleted
        static::deleting(function ($aboutSection) {
            if ($aboutSection->image && Storage::disk('public')->exists($aboutSection->image)) {
                Storage::disk('public')->delete($aboutSection->image);
            }
        });

        // Delete old image when updating
        static::updating(function ($aboutSection) {
            if ($aboutSection->isDirty('image') && $aboutSection->getOriginal('image')) {
                $oldImage = $aboutSection->getOriginal('image');
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });
    }

    /**
     * Handle image upload
     */
    public function uploadImage($file)
    {
        if ($file) {
            // Delete old image if exists
            if ($this->image && Storage::disk('public')->exists($this->image)) {
                Storage::disk('public')->delete($this->image);
            }

            // Store new image
            $path = $file->store('about-sections', 'public');
            $this->update(['image' => $path]);
            
            return $path;
        }
        
        return null;
    }

    /**
     * Scope for active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the active About Section (single active record)
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?: static::getDefault();
    }

    /**
     * Activate this About Section (deactivate all others)
     */
    public function activate()
    {
        // Deactivate all other About Sections
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this one
        $this->update(['is_active' => true]);
        
        return $this;
    }

    /**
     * Get first or create default record
     */
    public static function getDefault()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'Tentang Kami',
                'content' => '<p class="body-1 color-navy">Kami adalah tim teknisi laptop profesional yang berdedikasi untuk memberikan layanan terbaik sejak 2010. Dengan pengalaman bertahun-tahun dan ribuan laptop yang telah kami tangani, kami mengutamakan kejujuran, transparansi, dan kualitas.</p><p class="body-1 color-navy">Kami percaya bahwa laptop Anda bukan sekadar alat kerja, tapi aset penting yang harus dijaga. Setiap perangkat memiliki cerita dan memori berharga bagi pemiliknya. Itulah mengapa kami memperlakukan setiap perbaikan dengan penuh perhatian dan profesionalisme.</p><p class="body-1 color-navy">Tim kami terdiri dari teknisi bersertifikat yang terus mengikuti perkembangan teknologi terbaru. Kami menggunakan alat diagnostik mutakhir dan komponen berkualitas tinggi untuk memastikan laptop Anda kembali berfungsi optimal.</p><ul class="body-1-card color-navy mb-3"><li><b>Kejujuran - </b>Diagnosa masalah yang transparan tanpa biaya tersembunyi.</li><li><b>Profesionalisme - </b>Teknisi bersertifikasi dengan pelatihan berkala.</li><li><b>Garansi - </b>Jaminan 90 hari untuk setiap perbaikan.</li><li><b>Efisiensi - </b>Waktu perbaikan cepat tanpa mengorbankan kualitas.</li></ul>',
                'is_active' => true,
            ]
        );
    }
}
