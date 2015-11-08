<?php
/**
 * Created by PhpStorm.
 * User: Najam.Haque
 * Date: 11/7/2015
 * Time: 9:08 AM
 */

namespace Hotel\Controller;

/**
 * Use in alphabetical order.
 */
use Hotel\Model\HotelRestClient;
use Hotel\Proxy\AjaxProxy;

use Zend\Config\Config;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HotelController extends AbstractActionController
{

    /** @var Config $_config */
    protected $_config;

    /** @var RestClient $_zendRest */
    protected $_zendRest;

    public function __construct( )
    {
        $this->_config = new Config(include ROOT_PATH . '/module/Hotel/config/hotel.config.php');

    }

    /**
     * Just Display the Home Page, with a list of hotels
         * @return ViewModel
     */
    public function indexAction()
    {
        /**
         * Assume success, as we throw Exceptions in case of errors
         * Note that majority of our response are similar and have defaults
         */
        $response = [
            'success' => true,
            'hotels' => [],
            'minPriceDefault' => $this->_config->minPriceDefault,
            'maxPriceDefault' => $this->_config->maxPriceDefault
        ];

        try {
            $this->_zendRest = $this->getServiceLocator()->get('ZendRestClient');
            $_hotel = new HotelRestClient($this->_config, $this->_zendRest);

            $response['hotels'] = $_hotel->findAll();

        } catch (\Exception $exception) {
            /**
             * We don't pass $exception->getMessage() to the view.
             * User most likely will not understand what myriad of messages might mean.
             *
             * However it is important to log these messages
             * logging for custom exception is already happening
             * just before we throw . However, if some other exception is
             * caught here .. we must log it
             */
            error_log($exception->getMessage());
            $response['success'] = false;
        }
        return new ViewModel($response);
    }

    /**
     * Filter the result based on supplied price range
     * @return ViewModel
     */
    public function filterAction()
    {
        $response = [
            'success' => true,
            'hotels' => [],
        ];

        try {
            $minPrice = (int)$this->params()->fromQuery('minPrice', $this->_config->minPriceDefault);
            $maxPrice = (int)$this->params()->fromQuery('maxPrice', $this->_config->maxPriceDefault);

            $_zendRest = $this->getServiceLocator()->get('ZendRestClient');
            $_hotel = new HotelRestClient($this->_config, $_zendRest);

            $response['hotels'] = $_hotel->findBy(['min'=>$minPrice, 'max'=>$maxPrice]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            $response['success'] = false;
        }

        $viewModel = new ViewModel($response);
        /**
         * ensure no layout is used. We are in AJAX call
         */
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * The action only sets ua view for task 3. Task 3 is ajax driven so main action is in js
     * @return ViewModel
     */
    public function task3Action()
    {
        $viewModel = new ViewModel([]);
        return $viewModel;
    }

    /**
     * Makes the Proxy Ajax Call
     * @return ViewModel
     */
    public function ajaxAction()
    {
        try {
            $_ajaxProxy = new AjaxProxy($this->_config);
            $ajaxResponse = $_ajaxProxy->ajaxCall();
        } catch (\Exception $exception) {
            $ajaxResponse = $exception->getMessage();
        }

        $viewModel = new ViewModel(['response' => $ajaxResponse]);
        /**
         * ensure no layout is used. We are in AJAX call
         */
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}