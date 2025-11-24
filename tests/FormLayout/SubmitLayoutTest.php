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
            [@id="name"]
            [@name="name"]
            [@class="text-white bg-brand box-border border border-transparent shadow-xs font-medium text-sm leading-5 rounded-base px-4 py-2.5 hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium focus:outline-none"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }
}
