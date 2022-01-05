<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Request helpers methods for the Router
 */

namespace App\Core;

class Request
{
  /**
   * Fetch the request URI.
   *
   * @return string
   */
  public static function uri()
  {
    return trim(
      parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
      '/'
    );
  }

  /**
   * Fetch the request method.
   *
   * @return string
   */
  public static function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }
}
