<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InputAddressRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InputAddressCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InputAddressCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\InputAddress::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/input-address');
        CRUD::setEntityNameStrings('input address', 'input addresses');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('cust_id');
        CRUD::column('addr_supp');
        CRUD::column('street_addr');
        CRUD::column('d_street_addr_3');
        CRUD::column('d_street_addr_4');
        CRUD::column('zip');
        CRUD::column('city');
        CRUD::column('d_state_name');
        CRUD::column('country_code');
        CRUD::column('error_count');
    //    CRUD::column('created_at');
    //    CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->addButtonFromView('top', 'Populate Zip Table', 'popZip', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(InputAddressRequest::class);

    //    CRUD::field('id');
        CRUD::field('cust_id');
        CRUD::field('addr_supp');
        CRUD::field('street_addr');
        CRUD::field('d_street_addr_3');
        CRUD::field('d_street_addr_4');
        CRUD::field('zip');
        CRUD::field('city');
        CRUD::field('d_state_name');
        CRUD::field('country_code');
        CRUD::field('error_count');
    //    CRUD::field('created_at');
    //    CRUD::field('updated_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
