<?php
namespace CheddarGetter\Http;

/**
 * CheddarGetter
 * @category CheddarGetter
 * @package CheddarGetter
 * @author Marc Guyer <marc@cheddargetter.com>
 */
/**
 * Adapter implementation using the ZF1 abstraction for getting and setting http related data
 * @category CheddarGetter
 * @package CheddarGetter
 * @author Christophe Coevoet <stof@notk.org>
 * @example example/example.php
 * @todo use the ZF abstraction for other methods
 */

use CheddarGetter\Http\NativeAdapter;

class ZendAdapter extends NativeAdapter {

	/**
	 * The request object
	 *
	 * @var Zend_Controller_Request_Abstract|null
	 */
	private $_request;

	/**
	 * Constructor
	 * @throws CheddarGetter_Client_Exception Throws an exception if Zend_Controller_Front is not available.
	 */
	public function __construct() {
		if (!class_exists('Zend_Controller_Front')) {
			throw new CheddarGetter_Client_Exception('The Zend front controller is not available.', CheddarGetter_Client_Exception::USAGE_INVALID);
		}
	}

	/**
	 * Get the reqeust object
	 * @return Zend_Controller_Request_Abstract
	 */
	private function _request() {
		if ($this->_request) {
			return $this->_request;
		}
		$this->_request = Zend_Controller_Front::getInstance()->getRequest();
		return $this->_request;
	}

	/**
	 * Get a request param
	 * @param string $key
	 * @return mixed
	 */
	public function getRequestValue($key) {
		return $this->_request() ? $this->_request()->getParam($key) : null;
	}

	/**
	 * Checks whether a cookie exists.
	 *
	 * @param string $name Cookie name
	 * @return boolean
	 */
	function hasCookie($name) {
		return (bool) $this->getCookie($name);
	}

	/**
	 * Gets the value of a cookie.
	 *
	 * @param string $name Cookie name
	 * @return mixed
	 */
	function getCookie($name) {
		return $this->_request() ? $this->_request()->getCookie($name) : null;
	}

	/**
	 * Check if the http referrer is set
	 * @return boolean
	 */
	function hasReferrer() {
		return $this->_request() ? (bool) $this->_request()->getServer('HTTP_REFERER') : false;
	}

	/**
	 * Get the http referrer
	 * @return string
	 */
	function getReferrer() {
		return $this->_request() ? $this->_request()->getServer('HTTP_REFERER') : null;
	}

	/**
	 * Check if the remote ip is known
	 * @return boolean
	 */
	public function hasIp() {
		return $this->_request() ? (bool) $this->_request()->getClientIp() : false;
	}

	/**
	 * Get the remote ip
	 * @return string
	 */
	public function getIp() {
		return $this->hasIp() ? $this->_request()->getClientIp() : '';
	}

}
