<?php

declare(strict_types=1);
use Moanasoft\SupportFlowCore\Models\SupportFlowEvent;
use Moanasoft\SupportFlowCore\Models\SupportFlowRequest;

return [
    'enabled' => env('SUPPORT_FLOW_ENABLED', true),

    'routes' => [
        'enabled' => env('SUPPORT_FLOW_ROUTES_ENABLED', true),

        'public' => [
            'enabled' => env('SUPPORT_FLOW_PUBLIC_ROUTES_ENABLED', env('SUPPORT_FLOW_ROUTES_ENABLED', true)),
            'domain' => env('SUPPORT_FLOW_PUBLIC_DOMAIN', env('MOANASOFT_PUBLIC_DOMAIN')),
            'prefix' => env('SUPPORT_FLOW_PUBLIC_PREFIX', env('MOANASOFT_PUBLIC_PREFIX', '')),
            'path' => env('SUPPORT_FLOW_PUBLIC_PATH', env('SUPPORT_FLOW_ROUTE_PREFIX', 'support-flow')),
            'name' => env('SUPPORT_FLOW_PUBLIC_ROUTE_NAME', env('SUPPORT_FLOW_ROUTE_NAME', 'moanasoft.support-flow.front.')),
            'middleware' => config('moanasoft.routes.public.middleware', ['web']),
            'where' => config('moanasoft.routes.public.where', []),
        ],

        'admin' => [
            'enabled' => env('SUPPORT_FLOW_ADMIN_ROUTES_ENABLED', env('SUPPORT_FLOW_ROUTES_ENABLED', true)),
            'domain' => env('SUPPORT_FLOW_ADMIN_DOMAIN', env('MOANASOFT_ADMIN_DOMAIN')),
            'prefix' => env('SUPPORT_FLOW_ADMIN_PREFIX', env('MOANASOFT_ADMIN_PREFIX', '')),
            'path' => env('SUPPORT_FLOW_ADMIN_PATH', env('SUPPORT_FLOW_BACKOFFICE_PREFIX', 'support-flow')),
            'name' => env('SUPPORT_FLOW_ADMIN_ROUTE_NAME', env('SUPPORT_FLOW_BACKOFFICE_ROUTE_NAME', 'moanasoft.support-flow.backoffice.')),
            'middleware' => config('moanasoft.routes.admin.middleware', ['web', 'auth']),
            'where' => config('moanasoft.routes.admin.where', []),
        ],

        // Legacy aliases kept during migration.
        'prefix' => env('SUPPORT_FLOW_ROUTE_PREFIX', 'support-flow'),
        'name' => env('SUPPORT_FLOW_ROUTE_NAME', 'moanasoft.support-flow.front.'),
        'middleware' => ['web'],

        'backoffice' => [
            'prefix' => env('SUPPORT_FLOW_BACKOFFICE_PREFIX', 'backoffice/support-flow'),
            'name' => env('SUPPORT_FLOW_BACKOFFICE_ROUTE_NAME', 'moanasoft.support-flow.backoffice.'),
            'middleware' => ['web', 'auth'],
        ],
    ],

    'admin' => [
        'theme' => env('SUPPORT_FLOW_ADMIN_THEME', env('MOANASOFT_UI_PRESET', 'blade')),
        'layout' => [
            'classic' => 'support-flow::blade.admin.layout',
            'adminlte' => 'support-flow::adminlte.admin.layout',
        ],
    ],

    'tracking' => [
        'enabled' => true,
        'store_payload' => true,
        'store_context' => true,
    ],

    'requests' => [
        'model' => SupportFlowRequest::class,
        'table' => 'support_flow_requests',
    ],

    'events' => [
        'model' => SupportFlowEvent::class,
        'table' => 'support_flow_events',
    ],

    'instances' => [
        'footer_contact' => [
            'label' => 'Besoin d’aide ?',
            'description' => 'SupportFlow qualifie la demande avant ouverture du formulaire.',
            'intents' => ['pickup_labels', 'empty_boxes', 'login_help', 'unknown_service_code', 'other_request'],
            'rules' => [],
        ],

        'order_page' => [
            'label' => 'Aide commande',
            'description' => 'Guide les utilisateurs vers les actions existantes.',
            'intents' => ['empty_boxes', 'pickup_labels', 'unknown_service_code', 'other_request'],
            'rules' => [],
        ],
    ],

    'intents' => [
        'pickup_labels' => [
            'label' => 'Obtenir mes étiquettes de collecte',
            'description' => 'Guide vers la connexion, la demande d’enlèvement, le nombre de cartons et la génération des étiquettes.',
            'workflow' => 'pickup_labels',
            'resolution' => 'guided_workflow',
        ],

        'empty_boxes' => [
            'label' => 'Recevoir des cartons vides',
            'description' => 'Redirige vers la commande de cartons vides.',
            'workflow' => 'empty_boxes',
            'resolution' => 'redirect',
        ],

        'login_help' => [
            'label' => 'Aide à la connexion',
            'description' => 'Affiche une aide de connexion guidée.',
            'workflow' => 'login_help',
            'resolution' => 'guided_help',
        ],

        'unknown_service_code' => [
            'label' => 'Code service non reconnu',
            'description' => 'Ouvre une demande support qualifiée.',
            'workflow' => 'unknown_service_code',
            'resolution' => 'qualified_support_request',
        ],

        'other_request' => [
            'label' => 'Autre demande',
            'description' => 'Ouvre le formulaire libre uniquement en dernier recours.',
            'workflow' => null,
            'resolution' => 'fallback_contact',
        ],
    ],

    'workflows' => [
        'pickup_labels' => [
            'title' => 'Obtenir mes étiquettes de collecte',
            'steps' => [
                ['title' => 'Connectez-vous avec votre code service', 'type' => 'instruction'],
                ['title' => 'Créez une demande d’enlèvement', 'type' => 'instruction'],
                ['title' => 'Saisissez le nombre de cartons', 'type' => 'instruction'],
                ['title' => 'Générez vos étiquettes', 'type' => 'instruction'],
            ],
            'actions' => [
                ['label' => 'Accéder aux demandes d’enlèvement', 'url' => env('SUPPORT_FLOW_PICKUP_URL', '/pickup')],
            ],
        ],

        'empty_boxes' => [
            'title' => 'Recevoir des cartons vides',
            'steps' => [
                ['title' => 'Ouvrez la page de commande de cartons', 'type' => 'instruction'],
                ['title' => 'Indiquez la quantité souhaitée', 'type' => 'instruction'],
                ['title' => 'Validez la demande', 'type' => 'instruction'],
            ],
            'actions' => [
                ['label' => 'Commander des cartons', 'url' => env('SUPPORT_FLOW_EMPTY_BOXES_URL', '/boxes/order')],
            ],
        ],

        'login_help' => [
            'title' => 'Aide à la connexion',
            'steps' => [
                ['title' => 'Vérifiez votre code service', 'type' => 'instruction'],
                ['title' => 'Contrôlez votre email de connexion', 'type' => 'instruction'],
                ['title' => 'Réinitialisez votre accès si nécessaire', 'type' => 'instruction'],
            ],
            'actions' => [
                ['label' => 'Réinitialiser mon accès', 'url' => env('SUPPORT_FLOW_LOGIN_HELP_URL', '/password/reset')],
            ],
        ],

        'unknown_service_code' => [
            'title' => 'Code service non reconnu',
            'steps' => [
                ['title' => 'Préparez votre code service', 'type' => 'instruction'],
                ['title' => 'Ajoutez le nom de votre société ou site', 'type' => 'instruction'],
                ['title' => 'Envoyez une demande qualifiée au support', 'type' => 'contact'],
            ],
            'actions' => [],
        ],
    ],
];
