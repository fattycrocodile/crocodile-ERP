<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\SellpricesDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\SellPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellPriceController extends BaseController
{
    public function index(SellpricesDataTable $dataTable)
    {
        $this->setPageTitle('Products Price', 'List of Products price');
        return $dataTable->render('StoreInventory::sellprices.index');
    }

    public function create()
    {
        return 'Its work';
    }
    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $data = SellPrice::find($id);
        if ($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }
}
