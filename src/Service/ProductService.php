<?php

/**
 * Service for products Section. This service used for verifying the product details and process and provide product response for the searched data provided.
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use DOMDocument;

class ProductService
{

    /**
     * @var Registry
     */
    protected $doctrine;
    
    /**
     * @param Registry $doctrine
     *
     * @return void
     */
    
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }  
    
    /**
     * Private function to get products
     *
     * @return array
     */
    public function getProductResponse()
    {
        try {
            $returnData['status'] = false;
            //seraching the product based on params
            $products       = $this->doctrine->getRepository('App:Product')->findAll();
            
            $resultArray    = array();
            $productDetails = array();
            $i              = 0;
            foreach ($products as $product) {
                //the productDetails
                $productDetails['id']             = $product->getId();
                $productDetails['name']             = $product->getName();
                $productDetails['image']            = $product->getImageUrl();
                $productDetails['price']            = $product->getPrice();
                
                $resultArray['product'][$i] = $productDetails;
                $i++;
            }

            //In case no records found
            if (!$resultArray) {
                $returnData['message'] = 'api.empty';
                return $returnData;
            }
            $returnData['status']   = true;
            $returnData['response'] = $resultArray;
            
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $resultArray;
    }
}