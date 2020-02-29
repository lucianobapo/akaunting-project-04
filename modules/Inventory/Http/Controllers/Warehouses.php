<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;

use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Http\Requests\Warehouse as Request;

class Warehouses extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $warehouses = Warehouse::collect();

        return view('inventory::warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show(Warehouse $warehouse)
    {
        return view('inventory::warehouses.show', compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('inventory::warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $warehouse = Warehouse::create($request->all());

        $message = trans('messages.success.added', ['type' => trans_choice('inventory::general.warehouses', 1)]);

        flash($message)->success();

        return redirect()->route('warehouses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Warehouse  $warehouse
     *
     * @return Response
     */
    public function edit(Warehouse $warehouse)
    {
        return view('inventory::warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Warehouse  $warehouse
     * @param  Request  $request
     *
     * @return Response
     */
    public function update(Warehouse $warehouse, Request $request)
    {
        /*$relationships = $this->countRelationships($tax, [
            'items' => 'items',
            'invoice_items' => 'invoices',
            'bill_items' => 'bills',
        ]);*/

        if (empty($relationships) || $request['enabled']) {
            $warehouse->update($request->all());

            // Set default account
            if ($request['default_warehouse']) {
                setting()->set('inventory.default_warehouse', $warehouse->id);
                setting()->save();
            }

            $message = trans('messages.success.updated', ['type' => trans_choice('inventory::general.warehouses', 1)]);

            flash($message)->success();

            return redirect()->route('warehouses.index');
        } else {
            $message = trans('messages.warning.disabled', ['name' => $warehouse->name, 'text' => implode(', ', $relationships)]);

            flash($message)->warning();

            return redirect()->route('warehouses.edit', $warehouse->id);
        }
    }

    /**
     * Enable the specified resource.
     *
     * @param  Warehouse  $warehouse
     *
     * @return Response
     */
    public function enable(Warehouse $warehouse)
    {
        $warehouse->enabled = 1;
        $warehouse->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('inventory::general.warehouses', 1)]);

        flash($message)->success();

        return redirect()->route('warehouses.index');
    }

    /**
     * Disable the specified resource.
     *
     * @param  Warehouse  $warehouse
     *
     * @return Response
     */
    public function disable(Warehouse $warehouse)
    {
        /*$relationships = $this->countRelationships($tax, [
            'items' => 'items',
            'invoice_items' => 'invoices',
            'bill_items' => 'bills',
        ]);*/
        if ($warehouse->id == setting('inventory.default_warehouse')) {
            $relationships[] = strtolower(trans_choice('general.companies', 1));
        }

        if (empty($relationships)) {
            $warehouse->enabled = 0;
            $warehouse->save();

            $message = trans('messages.success.disabled', ['type' => trans_choice('inventory::general.warehouses', 1)]);

            flash($message)->success();

            return redirect()->route('warehouses.index');
        } else {
            $message = trans('messages.warning.disabled', ['name' => $warehouse->name, 'text' => implode(', ', $relationships)]);

            flash($message)->warning();

            return redirect()->route('warehouses.edit', $warehouse->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Warehouse  $warehouse
     *
     * @return Response
     */
    public function destroy(Warehouse $warehouse)
    {
        /*$relationships = $this->countRelationships($warehouse, [
            'items' => 'items',
            'invoice_items' => 'invoices',
            'bill_items' => 'bills',
        ]);*/
        if ($warehouse->id == setting('inventory.default_warehouse')) {
            $relationships[] = strtolower(trans_choice('general.companies', 1));
        }

        if (empty($relationships)) {
            $warehouse->delete();

            $message = trans('messages.success.deleted', ['type' => trans_choice('inventory::general.warehouses', 1)]);

            flash($message)->success();
        } else {
            $message = trans('messages.warning.deleted', ['name' => $warehouse->name, 'text' => implode(', ', $relationships)]);

            flash($message)->warning();
        }

        return redirect()->route('warehouses.index');
    }
}
