# Getting started

## Prerequisites

This bundle requires **PHP 8.1+**, **Symfony 6.4+** and **Flowbite 4.0+**.

## Installation

First, you need to [install Flowbite](https://flowbite.com/docs/getting-started/symfony/) in your Symfony project.

Then, add [tales-from-a-dev/flowbite-bundle](https://packagist.org/packages/tales-from-a-dev/flowbite-bundle) 
to your ``composer.json`` file:

```bash
composer require tales-from-a-dev/flowbite-bundle
```

## Register and configure the bundle

If you are using Symfony Flex, the following steps should be done automatically. Otherwise, follow the instructions.

### Register the bundle

Inside `config/bundles.php`, add the following line:

```php
// config/bundles.php
    
return [
    // ...
    TalesFromADev\FlowbiteBundle\TalesFromADevFlowbiteBundle::class => ['all' => true],
];
```

### Configuring Tailwind CSS

Update your Tailwind configuration to include the `templates` folder of the bundle:

```css
/* assets/styles/app.css */

@source "../../vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig";
```

#### Legacy Tailwind CSS configuration

If you are using the legacy Tailwind CSS configuration, add the following line to your `tailwind.config.js` file:

```js
// tailwind.config.js

module.exports = {
    content: [
        //...
        "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig"
    ],
}
```

### Configuring Twig

Update your Twig configuration located in `config/packages/twig.yaml` to use the form theme:

```yaml
# config/packages/twig.yaml

twig:
    # ...
    form_themes: 
        - '@TalesFromADevFlowbite/form/default.html.twig'
```

### Compiling assets

Finally, run one of the following commands to build your front-end assets:

#### With [Tailwind bundle](https://symfony.com/bundles/TailwindBundle/current/index.html)

```bash
php bin/console tailwind:build 
```

#### With Webpack Encore

```bash
# With npm
npm run watch

# With yarn
yarn watch
```
