<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\RadioType;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class RadioLayoutTest extends FormLayoutTestCase
{
    public function testRadio(): void
    {
        $form = $this->factory->createNamed('name', RadioType::class, false);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/div
                [@class="flex items-center mr-4"]
                [
                    ./input
                        [@type="radio"]
                        [@name="name"]
                        [@id="name"]
                        [@class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"]
                        [@value="1"]
                    /following-sibling::label
                        [@class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"]
                        [.="[trans]Name[/trans]"]
                ]
            '
        );
    }
}
