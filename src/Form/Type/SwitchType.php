<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class SwitchType extends AbstractType
{
    public function getParent(): ?string
    {
        return CheckboxType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'switch';
    }
}
