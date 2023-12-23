# Getting started

## Prerequisites

This bundle requires **PHP 8.2+**, **Symfony 6.4+** and **Flowbite 1.6+**.

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

Update your Tailwind configuration file to include the `templates` folder of the bundle:

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

## Run the watcher

Finally, run the following command to compile the front-end assets via Webpack:

```bash
# With npm
npm run watch

# With yarn
yarn watch
```
