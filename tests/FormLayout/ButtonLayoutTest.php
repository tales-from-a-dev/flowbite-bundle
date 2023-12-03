<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class ButtonLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testButton(): void
    {
        $form = $this->factory->createNamed('name', ButtonType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="button"]
            [@name="name"]
            [@class="text-gray-900 bg-white font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 border border-gray-200 hover:text-blue-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }
}
