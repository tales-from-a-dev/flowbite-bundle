<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SwitchType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_replace($view->vars, [
            'label_container_attr' => $options['label_container_attr'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label_container_attr' => [],
        ]);

        $resolver->setAllowedTypes('label_container_attr', 'array');
    }

    public function getParent(): ?string
    {
        return CheckboxType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'switch';
    }
}
