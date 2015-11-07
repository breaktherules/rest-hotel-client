<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 9:08 AM
 */

namespace Hotel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Hotel\Model\RestClient;

class HotelController extends AbstractActionController
{
    const MIN_DEFAULT_PRICE = 0;
    const MAX_DEFAULT_PRICE = 1000;

    public function indexAction()
    {
        $response = [
            'error' => false,
            'hotels' => [],
            'minPriceDefault' => self::MIN_DEFAULT_PRICE,
            'maxPriceDefault' => self::MAX_DEFAULT_PRICE
        ];

        try {
            /**
             * Assume success, as we throw Exceptions in case of errors
             */
            $_hotel = new RestClient();
            $response['hotels'] = $_hotel->findAll();

        } catch (\Exception $exception) {
            /**
             * We don't pass $exception->getMessage() to the view.
             * User most likely will not understand what myriad of messages might mean.
             *
             */
            $response['error'] = true;
        }
        return new ViewModel($response);
    }

    /**
     * @return ViewModel
     */
    public function filterAction()
    {
        $response = [
            'success' => true,
            'hotels' => [],
        ];

        try {
            $minPrice = (int)$this->params()->fromRoute('min', self::MIN_DEFAULT_PRICE);
            $maxPrice = (int)$this->params()->fromRoute('max', self::MAX_DEFAULT_PRICE);
            $_hotel = new RestClient();
            $response['hotels'] = $_hotel->filterByPrice($minPrice, $maxPrice);
        } catch (\Exception $exception) {
            $response['success'] = false;
        }

        $viewModel = new ViewModel($response);
        /**
         * ensure no layout is used. We are in AJAX call
         */
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}