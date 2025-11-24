<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class TextareaLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testTextarea(): void
    {
        $form = $this->factory->createNamed('name', TextareaType::class, 'foo');

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/textarea
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
                [.="foo"]
            '
        );
    }

    public function testTextareaError(): void
    {
        $form = $this->factory->createNamed('name', TextareaType::class, 'foo');
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/textarea
                [@name="name"]
                [@id="name"]
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
            '
        );
    }
}
