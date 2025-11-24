<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class RadioLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testRadio(): void
    {
        $form = $this->factory->createNamed('name', RadioType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex items-center"]
                [
                    ./input
                        [@type="radio"]
                        [@name="name"]
                        [@id="name"]
                        [@class="size-4 text-neutral-primary bg-neutral-secondary-medium rounded-full border border-default appearance-none checked:border-brand focus:ring-2 focus:outline-none focus:ring-brand-subtle"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="select-none ms-2 text-sm font-medium text-heading"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    public function testRadioLabelError(): void
    {
        $form = $this->factory->createNamed('name', RadioType::class);
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
