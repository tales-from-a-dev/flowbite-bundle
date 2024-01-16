<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class HiddenLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testHidden(): void
    {
        $form = $this->factory->createNamed('name', HiddenType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
            [@type="hidden"]
            [@name="name"]
            [@id="name"]'
        );
    }

    public function testHiddenWithClass(): void
    {
        $form = $this->factory->createNamed('name', HiddenType::class, null, [
            'attr' => [
                'class' => 'foo bar',
            ],
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
            [@type="hidden"]
            [@name="name"]
            [@id="name"]
            [@class="foo bar"]'
        );
    }
}
