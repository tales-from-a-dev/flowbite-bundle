<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class FileLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    public function testFile(): void
    {
        $form = $this->factory->createNamed('name', FileType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="file"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full shadow-xs cursor-pointer focus:ring-brand focus:border-brand placeholder:text-body"]
            '
        );
    }
}
