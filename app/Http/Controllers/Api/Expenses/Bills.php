<?php

namespace App\Http\Controllers\Api\Expenses;

use App\Events\BillCreated;
use App\Events\BillUpdated;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Expense\Bill as Request;
use App\Models\Expense\Bill;
use App\Models\Expense\BillHistory;
use App\Models\Expense\BillItem;
use App\Models\Expense\BillPayment;
use App\Models\Expense\BillStatus;
use App\Models\Common\Item;
use App\Models\Setting\Tax;
use App\Transformers\Expense\Bill as Transformer;
use Dingo\Api\Routing\Helpers;
use App\Jobs\Expense\CreateBill;

class Bills extends ApiController
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $bills = Bill::with(['vendor', 'status', 'items', 'payments', 'histories'])->collect();

        return $this->response->paginator($bills, new Transformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  Bill  $bill
     * @return \Dingo\Api\Http\Response
     */
    public function show(Bill $bill)
    {
        return $this->response->item($bill, new Transformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $bill = dispatch(new CreateBill($request));

        return $this->response->created(url('api/bills/'.$bill->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $bill
     * @param  $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Bill $bill, Request $request)
    {
        $bill_item = array();
        $bill_item['company_id'] = $request['company_id'];
        $bill_item['bill_id'] = $bill->id;

        if ($request['item']) {
            BillItem::where('bill_id', $bill->id)->delete();

            foreach ($request['item'] as $item) {
                $item_id = 0;
                $item_sku = '';

                if (!empty($item['item_id'])) {
                    $item_object = Item::find($item['item_id']);

                    $item_id = $item['item_id'];

                    $item['name'] = $item_object->name;
                    $item_sku = $item_object->sku;
                } elseif (!empty($item['sku'])) {
                    $item_sku = $item['sku'];
                }

                $tax = $tax_id = 0;

                if (!empty($item['tax_id'])) {
                    $tax_object = Tax::find($item['tax_id']);

                    $tax_id = $item['tax_id'];

                    $tax = (($item['price'] * $item['quantity']) / 100) * $tax_object->rate;
                } elseif (!empty($item['tax'])) {
                    $tax = $item['tax'];
                }

                $bill_item['item_id'] = $item_id;
                $bill_item['name'] = str_limit($item['name'], 180, '');
                $bill_item['sku'] = $item_sku;
                $bill_item['quantity'] = $item['quantity'];
                $bill_item['price'] = $item['price'];
                $bill_item['tax'] = $tax;
                $bill_item['tax_id'] = $tax_id;
                $bill_item['total'] = ($item['price'] + $bill_item['tax']) * $item['quantity'];

                $request['amount'] += $bill_item['total'];

                BillItem::create($bill_item);
            }
        }

        $bill->update($request->input());

        // Fire the event to make it extendible
        event(new BillUpdated($bill));

        return $this->response->item($bill->fresh(), new Transformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Bill  $bill
     * @return \Dingo\Api\Http\Response
     */
    public function destroy($bill)
    {
        $bill = Bill::findOrFail($bill);

        BillItem::where('bill_id', $bill->id)->delete();
        BillPayment::where('bill_id', $bill->id)->delete();
        BillHistory::where('bill_id', $bill->id)->delete();
        $bill->delete();

        return $this->response->noContent();
    }
}
