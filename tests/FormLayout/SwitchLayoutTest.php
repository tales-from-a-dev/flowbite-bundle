<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Form\Type\SwitchType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class SwitchLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testSwitch(): void
    {
        $form = $this->factory->createNamed('name', SwitchType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/label
                [@class="inline-flex items-center cursor-pointer"]
                [@for="name"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="sr-only peer"]
                        [@value="1"]
                    /following-sibling::div
                        [@class="relative w-9 h-5 bg-neutral-quaternary rounded-full peer peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-soft peer-checked:bg-brand peer-checked:after:translate-x-full peer-checked:after:border-buffer after:content-[\'\'] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:size-4 after:transition-all rtl:peer-checked:after:-translate-x-full"]
                    /following-sibling::span
                        [@class="select-none ms-2 text-sm font-medium text-heading"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }

    public function testSwitchLabelContainerAttr(): void
    {
        $form = $this->factory->createNamed('name', SwitchType::class, false, [
            'label_container_attr' => [
                'class' => 'foo bar',
            ],
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/label
                [@class="inline-flex items-center cursor-pointer foo bar"]
                [@for="name"]
            '
        );
    }

    public function testSwitchLabelError(): void
    {
        $form = $this->factory->createNamed('name', SwitchType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/label
                [@class="inline-flex items-center cursor-pointer"]
                [@for="name"]
                [
                    ./span
                        [@class="select-none ms-2 text-sm font-medium text-fg-danger-strong"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }
}
