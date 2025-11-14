<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class CheckboxLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testCheckbox(): void
    {
        $form = $this->factory->createNamed('name', CheckboxType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex items-center"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="size-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="select-none ms-2 text-sm font-medium text-heading"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    public function testCheckboxLabelError(): void
    {
        $form = $this->factory->createNamed('name', CheckboxType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [
                    ./label
                        [@for="name"]
                        [@class="select-none ms-2 text-sm font-medium text-fg-danger-strong"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }
}
