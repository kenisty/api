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
#[OA\Schema(
    schema: 'ExceptionV1',
    title: 'ExceptionV1',
    description: 'Response schema for a generic validation error V1.',
    properties: [
        new OA\Property(property: 'code', title: 'Error code', type: 'string'),
        new OA\Property(property: 'message', title: 'Message', type: 'string'),
    ],
)]
class OpenApiSpecs { }
