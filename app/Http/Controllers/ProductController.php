<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Product;

class ProductController {

    /****************************************************************************************************
     *
     * Function: ProductController.view(int $id).
     * Purpose: Finds a Product model that has a matching $id.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID of the model that is being searched for.
     *
     ****************************************************************************************************/
    public function view(int $id) {
        $product = new Product();

        $searchedProduct = $product->find($id);

        if (is_null($searchedProduct)) {
            echo '404: NOT FOUND';
            exit(404);
        }

        print_r($product->find($id));
    }

    /****************************************************************************************************
     *
     * Function: ProductController.store().
     * Purpose: Takes in user input, and then uses it to attempt to create a new Product model.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function store() {
        $request = new Request();
        $product = new Product();

        $product->create($request->getData());

        return $product;
    }
}