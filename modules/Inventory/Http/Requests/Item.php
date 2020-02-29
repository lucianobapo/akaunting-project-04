<?php

namespace Modules\Inventory\Http\Requests;

use App\Http\Requests\Request;

class Item extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get company id
        $company_id = $this->request->get('company_id');

        // Check if store or update
        if ($this->getMethod() == 'PATCH') {
            $id = $this->item->getAttribute('id');
        } else {
            $id = null;
        }

        return [

        ];
    }
}
