<?php

declare(strict_types=1);

namespace TalesFromADev\FlowbiteBundle\Tests\FormLayout;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormError;
use TalesFromADev\FlowbiteBundle\Tests\AbstractFlowbiteLayoutTestCase;

final class SelectLayoutTest extends AbstractFlowbiteLayoutTestCase
{
    #[DataProvider('selectProvider')]
    public function testSelect(string $classType): void
    {
        $form = $this->factory->createNamed('name', $classType, 'foo', [
            'multiple' => false,
            'expanded' => false,
        ]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body"]
            '
        );
    }

    #[DataProvider('selectProvider')]
    public function testSelectError(string $classType): void
    {
        $form = $this->factory->createNamed('name', $classType);
        $form->addError(new FormError('[trans]Error message[/trans]'));
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@class="border text-sm rounded-base block w-full px-3 py-2.5 shadow-xs bg-danger-soft border-danger-subtle text-fg-danger-strong focus:ring-danger focus:border-danger placeholder:text-fg-danger-strong"]
            '
        );
    }

    #[DataProvider('selectProvider')]
    public function testSelectDisabled(string $classType): void
    {
        $form = $this->factory->createNamed('name', $classType, 'foo', [
            'multiple' => false,
            'expanded' => false,
            'disabled' => true,
        ]);
        $form->submit([]);

        $this->assertWidgetMatchesXpath($form->createView(), [],
            '/select
                [@name="name"]
                [@id="name"]
                [@disabled="disabled"]
                [@class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs focus:ring-brand focus:border-brand placeholder:text-body disabled:text-fg-disabled disabled:cursor-not-allowed"]
            '
        );
    }

    public static function selectProvider(): \Generator
    {
        yield CountryType::class => [CountryType::class];
        yield LanguageType::class => [LanguageType::class];
        yield LocaleType::class => [LocaleType::class];
        yield TimezoneType::class => [TimezoneType::class];
        yield CurrencyType::class => [CurrencyType::class];
    }
}
