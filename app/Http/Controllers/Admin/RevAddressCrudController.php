<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RevAddressRequest;
use App\Common\CommonHelper;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\RevAddress;
use App\Models\InputAddress;
use App\Models\Zip;
use App\Models\InputError;

/**
 * Class RevAddressCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RevAddressCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RevAddress::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rev-address');
        CRUD::setEntityNameStrings('new revise address', 'revise address');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->denyAccess(['create', 'delete']);
        $this->crud->addFilter([ 
            'type'  => 'simple',
            'name'  => 'unmapped',
            'label' => 'Unmapped'
          ],
          false, 
          function() { 
              $revs = CommonHelper::getUnmappedRev();
              $sql = $revs->toSql();

              CRUD::setModel(\App\Models\Unmapped::class);

           


              
        



           


              
             
  
            }
        );
            

          


      //  CRUD::column('id');
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


        $this->crud->addButtonFromView('top', 'Truncate Revsion', 'truncRev', 'end');

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RevAddressRequest::class);

       // CRUD::field('id');
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
        //CRUD::field('created_at');
        //CRUD::field('updated_at');

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


    public function popRevise(){

        
        $ius = InputAddress::doesntHave('revAddress')->get();

        foreach($ius as $iu){
            
            $rev =  new RevAddress;

  




            
            
            $rev->cust_id = $iu->cust_id;
            $rev->addr_supp = $iu->addr_supp;
            $rev->street_addr = $iu->street_addr;
            $rev->d_street_addr_3 = $iu->d_street_addr_3;
            $rev->d_street_addr_4 = $iu->d_street_addr_4;
            $rev->zip = $iu->zip;
            $rev->city = $iu->city;
            $rev->d_state_name = $iu->d_state_name;
            $rev->country_code = $iu->country_code;
            //$rev->error_count = $iu->error_count;
            $rev->save();
     



        }

       

        return redirect(backpack_url('rev-address'));
        }

        public function truncateRev()
        {
            RevAddress::truncate();
            InputError::truncate();
            return redirect(backpack_url('rev-address'));
        }
       



     

    
    
}
