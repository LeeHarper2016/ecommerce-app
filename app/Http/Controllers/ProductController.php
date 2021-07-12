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

        $products = new Product();

        $products->getAll();

        if (count($products->getResult()) === 0) {
            return array();
        } else {
            print json_encode($products->getResult());
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
        header('Content-type: application/json');

        $product = new Product();

        $product->find($id);

        if (is_null($product->getResult())) {
            echo '404: NOT FOUND';
            exit(404);
        } else {
            echo json_encode($product->getResult());
        }
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
        header('Content-type: application/json');

        $request = new Request();
        $product = new Product();

        $product->create($request->getData());

        echo json_encode($product->getResult());
    }

    /****************************************************************************************************
     *
     * Function: ProductController.update().
     * Purpose: Takes in user input, and then uses it to attempt to update a model with the associated ID.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID of the product being updated.
     *
     ****************************************************************************************************/
    public function update(int $id) {
        header('Content-type: application/json');

        $request = new Request();
        $product = new Product();

        $product->update($id, $request->getData());

        echo json_encode($product->getResult());
    }

    /****************************************************************************************************
     *
     * Function: ProductController.delete().
     * Purpose: Deletes a product with the associated ID.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID of the product being deleted.
     *
     ****************************************************************************************************/
    public function delete(int $id) {
        header('Content-type: application/json');

        $product = new Product();

        $product->delete($id);

        echo json_encode($product->getResult());
    }
}