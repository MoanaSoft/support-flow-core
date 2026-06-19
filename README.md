# Moanasoft SupportFlow Core

SupportFlow Core is an embeddable Laravel package that qualifies support requests before displaying a fallback contact form.

It is intentionally not a generic contact form. Its role is to reduce avoidable support requests by guiding users to existing application actions.

## Requirements

- PHP 8.4+
- Laravel 13+
- `moanasoft/foundation` 0.2+

## Install

```bash
composer require moanasoft/support-flow-core
php artisan vendor:publish --tag=support-flow-config
php artisan vendor:publish --tag=support-flow-migrations
php artisan migrate
```

## Embed a widget

```blade
<x-support-flow::widget instance="footer_contact" />
```

With contextual data:

```blade
<x-support-flow::widget
    instance="order_page"
    :context="['order_id' => $order->id]"
/>
```

The package does not impose a public page. The widget is designed to be embedded in any Blade view.

## Core boundaries

Core contains:

- Blade widget
- PHP configuration
- Multi-instances
- Configured intents
- Guided workflows
- Fallback contact form
- Basic event tracking
- Simple dashboard
- Classic and AdminLTE admin views

Core does not contain:

- Graphical workflow builder
- Graphical instance builder
- Advanced analytics
- Exports
- Advanced tenant management
- Branding management

Those features belong to `moanasoft/support-flow-pro`.

## Multi-instances

Instances are defined in `config/support-flow.php`:

```php
'instances' => [
    'footer_contact' => [
        'label' => 'Besoin d’aide ?',
        'intents' => ['pickup_labels', 'empty_boxes', 'login_help', 'unknown_service_code', 'other_request'],
    ],

    'order_page' => [
        'label' => 'Aide commande',
        'intents' => ['empty_boxes', 'pickup_labels', 'other_request'],
    ],
],
```

Each instance has its own intents, workflows and rules.

## Admin routes

Default routes:

- `/backoffice/support-flow`
- `/backoffice/support-flow/stats`
- `/backoffice/support-flow/requests`
- `/backoffice/support-flow/requests/{id}`

## Admin theme

```php
'admin' => [
    'theme' => 'classic',
],
```

or:

```php
'admin' => [
    'theme' => 'adminlte',
],
```

AdminLTE is optional. The Core package ships both view trees:

- `resources/views/blade/admin/*`
- `resources/views/adminlte/admin/*`

## Events tracked

- `viewed`
- `intent_selected`
- `workflow_started`
- `workflow_completed`
- `contact_opened`
- `contact_sent`

## Design note

This package is deliberately configuration-first in Community edition. Database-backed workflow editing is a Pro concern.
