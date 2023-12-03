<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class TextLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    #[DataProvider('inputProvider')]
    public function testInput(string $classType, mixed $data, string $inputType): void
    {
        $form = $this->factory->createNamed('name', $classType, $data);

        $this->assertWidgetMatchesXpath($form->createView(), [], sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
                %s
            ',
            $inputType,
            null !== $data ? '[@value="'.$data.'"]' : '',
        ));
    }

    #[DataProvider('inputProvider')]
    public function testInputError(string $classType, mixed $data, string $inputType): void
    {
        $form = $this->factory->createNamed('name', $classType, $data);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [], sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="rounded-lg text-sm block w-full p-2.5 border dark:placeholder-gray-400 text-red-900 bg-red-50 border-red-500 placeholder-red-700 dark:bg-red-100 dark:border-red-400 dark:text-red-900 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
            ',
            $inputType,
        ));
    }

    public function testTextError(): void
    {
        $form = $this->factory->createNamed('name', TextType::class);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $html = $this->renderErrors($form->createView());

        $this->assertMatchesXpath($html,
            '/p
                [@id="name_error_0"]
                [@class="mt-2 text-sm text-red-600 dark:text-red-500"]
                [.="[trans]Error message[/trans]"]
            '
        );
    }

    public static function inputProvider(): \Generator
    {
        yield TextType::class => [TextType::class, 'foo', 'text'];
        yield EmailType::class => [EmailType::class, 'foo@example.com', 'email'];
        yield IntegerType::class => [IntegerType::class, 123456, 'number'];
        yield NumberType::class => [NumberType::class, 1234.56, 'text'];
        yield PasswordType::class => [PasswordType::class, null, 'password'];
        yield SearchType::class => [SearchType::class, '1', 'search'];
        yield UrlType::class => [UrlType::class, 'https://example.com', 'text'];
        yield TelType::class => [TelType::class, '0123456789', 'tel'];
        yield ColorType::class => [ColorType::class, '#ffffff', 'color'];
    }
}
