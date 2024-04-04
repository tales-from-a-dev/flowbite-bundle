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
                [@class="relative inline-flex items-center cursor-pointer"]
                [@for="name"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="sr-only peer"]
                        [@value="1"]
                    /following-sibling::div
                        [@class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 dark:border-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"]
                    /following-sibling::span
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
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
                [@class="relative inline-flex items-center cursor-pointer foo bar"]
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
                [@class="relative inline-flex items-center cursor-pointer"]
                [@for="name"]
                [
                    ./span
                        [@class="ml-2 text-sm font-medium text-red-600 dark:text-red-500"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }
}
