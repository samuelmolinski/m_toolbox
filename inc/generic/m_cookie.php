<?php

	function m_setCookie($array) {
		setcookie("m_cookie_test", 'test-value');

		foreach ($array as $k => $v) {
			setcookie("m_cookie[$k]", $v);
		}
	}

	function m_removeCookie($array) {
		setcookie("m_cookie_test", 'test-value', 1);

		foreach ($array as $k => $v) {
			setcookie("m_cookie[$k]", '' , 1);
		}
	}
	
	function showCookie() {
		if (isset($_COOKIE['m_cookie_test'])) {
			d($_COOKIE['m_cookie_test']);
		}
		if (isset($_COOKIE)) {
			d($_COOKIE);
		}
	}

	function parseCookie() {
		$cookie = array();
		if (isset($_COOKIE['m_cookie' ])) {
			foreach ($_COOKIE['m_cookie'] as $k => $v){				
				$cookie[$k] = $v;
			}
		}
		return $cookie;
	}
	