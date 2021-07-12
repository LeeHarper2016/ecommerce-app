<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Product;

class ProductController {

    /****************************************************************************************************
     *
     * Function: ProductController.viewAll().
     * Purpose: Retrieves a list of all products found in the database.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function viewAll() {
        header('Content-type: application/json');

        $productModel = new Product();

        $products = $productModel->getAll();

        if (count($products) === 0) {
            return array();
        } else {
            print json_encode($products);
            return exit(200);
        }
    }

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

    /****************************************************************************************************
     *
     * Function: ProductController.store().
     * Purpose: Takes in user input, and then uses it to attempt to create a new Product model.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     ****************************************************************************************************/
    public function update(int $id) {
        $request = new Request();
        $product = new Product();

        $product->update($id, $request->getData());

        return $product;
    }
}