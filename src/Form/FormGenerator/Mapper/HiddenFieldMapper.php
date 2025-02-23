<?php

declare(strict_types=1);

namespace Netzmacht\ContaoFormBundle\Form\FormGenerator\Mapper;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class HiddenFieldMapper extends AbstractFieldMapper
{
    /**
     * The form field type.
     *
     * @var string
     */
    protected $fieldType = 'hidden';

    /**
     * The type class.
     *
     * @var string
     */
    protected $typeClass = HiddenType::class;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->options['label']     = false;
        $this->options['maxlength'] = false;
        $this->options['minlength'] = false;
    }
}
