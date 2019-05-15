<?php

/**
 * Fix
 *
 * @license  MIT
 * @author   Paweł Detka <pawel.detka@monogo.pl>
 */
class Monogo_Cache_Backend_Redis extends Cm_Cache_Backend_Redis
{

    static $excessiveCache = [];
    static $patterns = ['/Zend_Locale/'];

    /**
     * {@inheritDoc}
     */
    public function load($id, $doNotTestCacheValidity = false)
    {
        if (isset(self::$excessiveCache[$id])) {
            return self::$excessiveCache[$id];
        }
        $result = parent::load($id, $doNotTestCacheValidity);
        if ($result !== false) {
            foreach (self::$patterns as $pattern) {
                if (preg_match($pattern, $id)) {
                    self::$excessiveCache[$id] = $result;
                }
            }
        }
        return $result;
    }
}
