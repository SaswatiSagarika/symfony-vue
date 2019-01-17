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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use DOMDocument;

class ProductService
{

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     *  @var string
     */
    private $mailer;
    
    /**
     * @param Registry $doctrine
     * @param String $dataDir
     *
     * @return void
     */    
    public function __construct(Registry $doctrine, $dataDir)
    {
        $this->doctrine = $doctrine;
        $this->dataDir = $dataDir;
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

     /**
     * Private function to get products
     *
     * @param $sheet    obejct(PHPExcel_Worksheet)
     *
     * @return array
     */
    public function uploadProduct($sheet) {
        print_r($sheet);exit();
    }
}