<?php declare(strict_types=1);

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'The main entry point for Kenisty project.',
    title: 'Kenisty API',
    contact: new OA\Contact(
        name: 'Kenisty IT Team',
        url: 'https://kenisty.com',
    ),
    license: new OA\License(
        name: 'MIT',
    ),
)]
#[OA\Server(
    url: 'http://localhost:8000/',
    description: 'Development Server',
)]
#[OA\Server(
    url: 'https://kenisty.com/',
    description: 'Production Server',
)]
#[OA\SecurityScheme(
    securityScheme: 'BasicAuth',
    type: 'http',
    name: 'BasicAuth',
    scheme: 'Basic',
)]
class OpenApiSpecs { }
