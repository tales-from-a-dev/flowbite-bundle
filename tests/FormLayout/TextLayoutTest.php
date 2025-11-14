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

        $this->assertWidgetMatchesXpath($form->createView(), [], \sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
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

        $this->assertWidgetMatchesXpath($form->createView(), [], \sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
            ',
            $inputType,
        ));
    }

    #[DataProvider('inputProvider')]
    public function testInputDisabled(string $classType, mixed $data, string $inputType): void
    {
        $form = $this->factory->createNamed('name', $classType, $data, ['disabled' => true]);
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [], \sprintf(
            '/input
                [@type="%s"]
                [@name="name"]
                [@id="name"]
                [@disabled="disabled"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body disabled:text-fg-disabled disabled:cursor-not-allowed"]
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
                [@class="mt-2.5 text-sm text-fg-danger-strong"]
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
