<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class FileLayoutTest extends FormLayoutTestCase
{
    public function testFile(): void
    {
        $form = $this->factory->createNamed('name', FileType::class);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/input
                [@type="file"]
                [@name="name"]
                [@id="name"]
                [@class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"]
            '
        );
    }
}
