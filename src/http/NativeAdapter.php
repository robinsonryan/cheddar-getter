<?php
namespace CheddarGetter\Http;

/**
 * CheddarGetter
 * @category CheddarGetter
 * @package CheddarGetter
 * @author Marc Guyer <marc@cheddargetter.com>
 */
/**
 * Adapter implementation using PHP superglobals for getting and setting http related data
 * @category CheddarGetter
 * @package CheddarGetter
 * @author Christophe Coevoet <stof@notk.org>
 * @example example/example.php
 */

use CheddarGetter\Http\AdapterInterface;

class NativeAdapter implements AdapterInterface {

	/**
	 * Checks whether a cookie exists.
	 *
	 * @param string $name Cookie name
	 * @return boolean
	 */
	public function hasCookie($name) {
		return isset($_COOKIE[$name]);
	}

	/**
	 * Gets the value of a cookie.
	 *
	 * @param string $name Cookie name
	 * @return mixed
	 */
	public function getCookie($name) {
		return $_COOKIE[$name];
	}

	/**
	 * Sets the value of a cookie.
	 *
	 * @param string $name Cookie name
	 * @param string $data Value of the cookie
	 * @param int $expire
	 * @param string $path
	 * @param string $domain
	 * @param boolean $secure
	 * @param boolean $httpOnly
	 */
	public function setCookie($name, $data, $expire, $path, $domain, $secure = false, $httpOnly = false) {
		if (!headers_sent()) {
			// set the cookie
			setcookie($name, $data, $expire, $path, $domain, $secure, $httpOnly);
		}
	}

	/**
	 * Get a value from the request (get/post/cookie)
	 * @param string $key
	 * @return mixed
	 */
	public function getRequestValue($key) {
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
	}

	/**
	 * Check if the http referrer is set
	 * @return boolean
	 */
	public function hasReferrer() {
		return !empty($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Get the http referrer
	 * @return string
	 */
	public function getReferrer() {
		return $this->hasReferrer() ? $_SERVER['HTTP_REFERER'] : '';
	}

	/**
	 * Check if the remote IP is known
	 * @return boolean
	 */
	public function hasIp() {
		return (bool) $this->_getIp();
	}

  /**
   * Really get the IP
   */
  protected function _getIp() {
    $ip = null;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

	/**
	 * Get the remote ip
	 * @return string
	 */
	public function getIp() {
		return $this->hasIp() ? $this->_getIp() : '';
	}
}
