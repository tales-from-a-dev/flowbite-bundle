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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"]
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
                [@class="rounded-lg text-sm block w-full p-2.5 border bg-red-50 border-red-500 text-red-900 placeholder-red-700 dark:bg-red-100 dark:border-red-500 dark:text-red-500 dark:placeholder-red-500 focus:z-10 focus:ring-red-500 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-500"]
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
                [@class="text-gray-900 bg-gray-50 rounded-lg text-sm block w-full p-2.5 border border-gray-300 focus:z-10 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100 disabled:border-gray-300 disabled:cursor-not-allowed dark:disabled:text-gray-400"]
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
