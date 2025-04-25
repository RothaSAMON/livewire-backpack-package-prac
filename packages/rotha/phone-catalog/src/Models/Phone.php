<?php

namespace Rotha\PhoneCatalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Phone extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'image',
        'specifications',
    ];
}