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
                [@class="flex items-center mr-4"]
                [
                    ./input
                        [@type="checkbox"]
                        [@name="name"]
                        [@id="name"]
                        [@class="rounded w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
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
                        [@class="ml-2 text-sm font-medium text-red-600 dark:text-red-500"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }
}
