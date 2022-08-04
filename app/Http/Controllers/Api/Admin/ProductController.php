<?php

namespace App\Http\Controllers\Api\Admin;

use Throwable;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Service\ProductService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\EditProductRequest;
use App\Http\Requests\SaveProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allProducts = new ProductService;
        $products = $allProducts->getAllProducts();
        return $this->apiResponse->successWithData($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProductRequest $request)
    {
        //
        try {
            //code...
            $formData = $request->validated();
            $newProduct = new ProductService;
            // $formData['slug'] = Str::slug($request->brand. ' ' .$request->name, '-');
            $product = $newProduct->saveProduct($formData);
            return $this->apiResponse->successWithData($product, 'product successfully created');

        } 
        catch (ApiResponseException $e) {
            //throw $th;
            return $this->apiResponse->failure($e->getMessage());
        }
        catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::error($th->getLine());
            Log::error($th->getFile());
            return $this->apiResponse->failure('something went wrong. Try again!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            //code...
            $aProduct = new ProductService;
            $product = $aProduct->getAProduct($id);
            return $this->apiResponse->successWithData($product);
        }  catch (ApiResponseException $th) {
            //throw $th;
            return $this->apiResponse->failure($th->getMessage());
        }
        
        catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::error($th->getLine());
            Log::error($th->getFile());
            return $this->apiResponse->failure('something went wrong, try again.');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        //
        try {
            //code...
            $formData = $request->validated();
            $newProduct = new ProductService ;
            $product = $newProduct->editProduct($formData, $id);
            return $this->apiResponse->successWithData($product, 'product successfully created');
        } catch (ApiResponseException $e) {
            //throw $th;
            return $this->apiResponse->failure($e->getMessage());
        }
        catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::error($th->getLine());
            Log::error($th->getFile());
            return $this->apiResponse->failure('something went wrong, try again.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
