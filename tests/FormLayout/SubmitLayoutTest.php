<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class SubmitLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testSubmit(): void
    {
        $form = $this->factory->createNamed('name', SubmitType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="submit"]
            [@name="name"]
            [@class="text-white bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }
}
