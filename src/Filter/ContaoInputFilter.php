<?php

/**
 * Netzmacht Contao Form Bundle.
 *
 * @package    contao-form-bundle
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2019 netzmacht David Molineus. All rights reserved.
 * @license    LGPL-3.0-or-later https://github.com/netzmacht/contao-form-bundle/blob/master/LICENSE
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\ContaoFormBundle\Filter;

use Contao\Config;
use Contao\CoreBundle\Framework\Adapter;
use Contao\Input;
use Netzmacht\Contao\Toolkit\Routing\RequestScopeMatcher;

/**
 * Class ContaoInputFilter
 */
class ContaoInputFilter
{
    /**
     * Contao input adapter.
     *
     * @var Adapter|Input
     */
    private $inputAdapter;

    /**
     * Config adapter.
     *
     * @var Adapter|Config
     */
    private $configAdapter;

    /**
     * Request scope matcher.
     *
     * @var RequestScopeMatcher
     */
    private $scopeMatcher;

    /**
     * ContaoInputFilter constructor.
     *
     * @param Adapter|Input       $inputAdapter  The input adapter.
     * @param Adapter|Config      $configAdapter The config adapter.
     * @param RequestScopeMatcher $scopeMatcher  Scope matcher.
     */
    public function __construct($inputAdapter, $configAdapter, RequestScopeMatcher $scopeMatcher)
    {
        $this->inputAdapter  = $inputAdapter;
        $this->scopeMatcher  = $scopeMatcher;
        $this->configAdapter = $configAdapter;
    }

    /**
     * Filter to get raw data.
     *
     * @param mixed $data Given data.
     *
     * @return mixed
     */
    public function filterRaw($data)
    {
        $data = $this->inputAdapter->preserveBasicEntities($data);
        $data = $this->inputAdapter->xssClean($data, true);

        if (!$this->scopeMatcher->isBackendRequest()) {
            $data = $this->inputAdapter->encodeInsertTags($data);
        }

        return $data;
    }

    /**
     * Filter the given data.
     *
     * @param mixed $data           The data.
     * @param bool  $decodeEntities If true entities will be encoded.
     * @param bool  $allowHtml      Allow html.
     *
     * @return mixed
     */
    public function filter($data, bool $decodeEntities = false, bool $allowHtml = false)
    {
        $data = $this->inputAdapter->decodeEntities($data);
        $data = $this->inputAdapter->xssClean($data, true);
        $data = $this->inputAdapter->stripTags($data, $this->getAllowedTags($allowHtml));

        if (!$decodeEntities) {
            $data = $this->inputAdapter->encodeSpecialChars($data);
        }

        if (!$this->scopeMatcher->isBackendRequest()) {
            $data = $this->inputAdapter->encodeInsertTags($data);
        }

        return $data;
    }

    /**
     * Get all allowed tags as string.
     *
     * @param bool $allowHtml Allowed html.
     *
     * @return string
     */
    private function getAllowedTags(bool $allowHtml): string
    {
        if ($allowHtml) {
            return (string) $this->configAdapter->get('allowedTags');
        }

        return '';
    }
}
