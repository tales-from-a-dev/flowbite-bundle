<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\FormLayoutTestCase;

final class SupportLayoutTest extends FormLayoutTestCase
{
    public function testLabel(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"]
                [.="[trans]Name[/trans]"]
            '
        );
    }

    public function testLabelWithAttrClass(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'label_attr' => [
                'class' => 'my&class',
            ],
        ]);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-gray-900 dark:text-white my&class"]
                [.="[trans]Name[/trans]"]
            '
        );
    }

    public function testHelp(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'help' => 'Help text test!',
        ]);
        $html = $this->renderHelp($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@id="name_help"]
                [@class="mt-2 text-sm text-gray-500 dark:text-gray-400"]
                [.="[trans]Help text test![/trans]"]
            '
        );
    }

    public function testHelpWithAttrClass(): void
    {
        $form = $this->factory->createNamed('name', TextType::class, null, [
            'help' => 'Help text test!',
            'help_attr' => [
                'class' => 'my&class',
            ],
        ]);
        $html = $this->renderHelp($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@id="name_help"]
                [@class="mt-2 text-sm text-gray-500 dark:text-gray-400 my&class"]
                [.="[trans]Help text test![/trans]"]
            '
        );
    }

    public function testErrorLabel(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);
        $html = $this->renderLabel($form->createView());

        $this->assertMatchesXpath($html,
            '/label
                [@for="name"]
                [@class="block mb-2 text-sm font-medium text-red-600 dark:text-red-500"]
                [.="[trans]Name[/trans]"]
            '
        );
    }
}
