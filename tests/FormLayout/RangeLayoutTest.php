<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\RangeType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class RangeLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testRange(): void
    {
        $form = $this->factory->createNamed('name', RangeType::class, 10);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="range"]
                [@name="name"]
                [@id="name"]
                [@class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"]
                [@value="10"]
            '
        );
    }
}
