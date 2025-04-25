<?php

namespace Rotha\PhoneCatalog\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Rotha\PhoneCatalog\Models\Phone;

class PhoneCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Phone::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/phone');
        CRUD::setEntityNameStrings('phone', 'phones');
    }

    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('brand');
        CRUD::column('price');
        CRUD::column('image')->type('image');
        CRUD::column('description');
    }

    protected function setupCreateOperation()
    {
        CRUD::field('name');
        CRUD::field('brand');
        CRUD::field('description')->type('textarea');
        CRUD::field('price')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('image')->type('upload')->upload(true);
        CRUD::field('specifications')->type('textarea');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}