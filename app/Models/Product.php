<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price",
        "status",
        "type",
        "user_id",
        "product_id",
        "version",
        "created_at",
        "updated_at",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateAndCreateVersion(array $data)
    {
        $getLastVersion = self::when(
            $this->product_id,
            function ($q) {
                $q->where("id", $this->product_id);
            },
            function ($q) {
                $q->where("id", $this->id);
            }
        )
            ->whereNull("product_id")
            ->first();

        $newVersion = $this->create([...$data, "version" => ($getLastVersion->version ?? 0) + 1]);

        $getLastVersion->update([
            "product_id" => $newVersion->id,
        ]);

        return $newVersion;
    }
}
