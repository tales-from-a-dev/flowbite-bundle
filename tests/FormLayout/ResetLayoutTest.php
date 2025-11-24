<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\ResetType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class ResetLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testReset(): void
    {
        $form = $this->factory->createNamed('name', ResetType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/button
            [@type="reset"]
            [@id="name"]
            [@name="name"]
            [@class="text-body bg-neutral-secondary-medium box-border border border-default-medium shadow-xs font-medium text-sm leading-5 rounded-base px-4 py-2.5 hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary focus:outline-none"]
            [
                .="[trans]Name[/trans]"
            ]'
        );
    }
}
