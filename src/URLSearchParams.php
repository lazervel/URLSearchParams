<?php

declare(strict_types=1);

/**
 * A PHP implementation of URLSearchParams for handling query parameters easily.
 * 
 * The (URLSearchParams) Github repository
 * @see       https://github.com/lazervel/URLSearchParams
 * 
 * @author    Shahzada Modassir <shahzadamodassir@gmail.com>
 * @author    Shahzadi Afsara   <shahzadiafsara@gmail.com>
 * 
 * @copyright (c) Shahzada Modassir
 * @copyright (c) Shahzadi Afsara
 * 
 * @license   MIT License
 * @see       https://github.com/lazervel/URLSearchParams/blob/main/LICENSE
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Web\URLSearchParams;

class URLSearchParams
{
  /**
   * $init instance
   * 
   * @var string|string[][]|array<string,string>|\Web\URLSearchParams\URLSearchParams
   */
  private $params;

  /**
   * Stored all real param data in tupples.
   * 
   * @var array<string,array|string>
   */
  private $tupples;

  /**
   * Stored modified param data in entries.
   * 
   * @var array<array<string,string>>
   */
  private $entries;

  /**
   * Creates a new URLSearchParams constructor
   * Initializes a new instance of URLSearchParams with the given value.
   * 
   * @param string|string[][]|array<string,string>|\Web\URLSearchParams\URLSearchParams $init
   * @return void
   */
  public function __construct($init = null)
  {
    $this->params = $init;
    if ($init instanceof URLSearchParams) {
      $this->tupples = $init->tupples();
      $this->entries = $init->entries();
    }
  }

  /**
   * Returns an array of key, value pairs for every entry in the search params.
   * 
   * @return array<array<string,string>> All URLSearchParams entries.
   */
  public function entries() : array
  {
    return $this->entries ?? $this->makeEntries($this->params);
  }

  /**
   * Check Assoc array, Returns true for Assoc, Otherwise false
   * 
   * @param array $array [required]
   * @return bool Array assoc for true, Otherwise false
   * 
   * @example Example usage:
   * isAssoc([1,2,3,4,5,9,8,7,6])           // Outputs: false
   * isAssoc(['foo'=> 'bar', 'baz'=> true]) // Outputs: true
   */
  private function isAssoc(array $array) : bool
  {
    if (!\count($array)) return false;
    return \range(0, \count($array) - 1) !== \array_keys($array);
  }

  /**
   * Converts a given value to its string representation.
   * 
   * This method takes an input of any data type and returns its string representation.
   * It can handle integers, floats, arrays, objects, etc.
   * 
   * @param mixed $value [required]
   * @return string The string representation of the input value.
   * 
   * @example Example usage:
   * valueToString(123);       // Outputs: '123'
   * valueToString(3.14);      // Outputs: '3.14'
   * valueToString([1, 2, 3]); // Outputs: '[1, 2, 3]'
   */
  private function valueToString($value) : string
  {
    return \is_array($value) ? \implode(',', $value) : (string) $value;
  }

  /**
   * Creates a tupples
   * 
   * @param string|string[][]|array<string,string> $params [optional]
   * @return array<string,array|string>
   */
  private function makeTupples($params) : array
  {
    $tupples = [];

    // Handle: If params is query string (e.g., 'user=abcd&id=12345')
    if (\is_string($params)) {
      \parse_str($params, $tupples);
      return $tupples;
    }

    if (\is_array($params) && !$this->isAssoc($params)) {
      foreach($params as $i=> $tuple) {
        if (!\is_array($tuple) ||
          ($this->isAssoc($params) && \count($tuple) > 1) || (\count($tuple) > 2 || \count($tuple) <= 1)) {
          $this->throwTypeError($i);
        }
      }
    }

    return (array) $params;
  }

  /**
   * Creates a real entries.
   * 
   * @param string|string[][]|array<string,string> $params [optional]
   * @return array<array<string,string>>
   */
  private function makeEntries($params) : array
  {
    $entries = [];
    foreach($this->tupples() as $key => $value) {
      $this->setRecursive((string)$key, $value, $entries);
    }
    return $entries;
  }

  /**
   * Returns array param to query string.
   * 
   * @return string
   */
  public function toString() : string
  {
    $queries = [];
    foreach($this->entries() as $entries) {
      // $entries[0] for key representation, $entries[1] for val representation.
      $queries[] = \sprintf('%s=%s', \urlencode($entries[0]), \urlencode($entries[1]));
    }

    return \join('&', $queries);
  }

  /**
   * binding param with '[]' bracket paire
   * 
   * @param string $prefix   [required]
   * @param mixed  $mixed    [required]
   * @param array  &$entries [required]
   * 
   * @return void
   */
  private function setRecursive(string $prefix, $mixed, array &$entries) {
    if (\is_array($mixed)) {
      $isAssoc = $this->isAssoc($mixed);
      foreach($mixed as $key => $value) {
        $this->setRecursive(\sprintf('%s[%s]', $prefix, $isAssoc ? $key : ''), $value, $entries);
      }
    } else {
      \array_push($entries, [$prefix, (string)$mixed]);
    }
  }

  /**
   * Creates a tupples
   * 
   * @return array<string,array|string>
   */
  public function tupples() : array
  {
    return $this->tupples ?? $this->makeTupples($this->params);
  }

  /**
   * throwTypeError - method will throw TypeError,
   * It's used to be if query paire not be iterable [name, value] tuple.
   * 
   * @param int $i [required]
   * 
   * @throws \TypeError Used to throw, if query paire not be iterable [name, value] tuple.
   * @return void
   */
  private function throwTypeError(int $i) : void
  {
    throw new \TypeError(\sprintf(
      '[ERR_INVALID_TUPLE]: Each query pair must be an iterable [name, value] tuple on index [%d]', $i)
    );
  }
}
?>