<?php

/**
 * @package    contao-form-bundle
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved
 * @filesource
 *
 */

declare(strict_types=1);

namespace Netzmacht\ContaoFormBundle\Form\FormGenerator;

/**
 * Class CheckboxFieldMapper
 */
class RadioFieldMapper extends AbstractChoicesFieldMapper
{
    /**
     * The form field type.
     *
     * @var string
     */
    protected $fieldType = 'radio';

    /**
     * Multiple. If null, the value is read from the model.
     *
     * @var bool|null
     */
    protected $multiple = false;
}
