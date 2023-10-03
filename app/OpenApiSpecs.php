<?php declare(strict_types=1);

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'The main entry point for Kenisty project.',
    title: 'Kenisty API',
    contact: new OA\Contact(
        name: 'Pola Eskandar',
        url: 'https://codingstreamer.com',
        email: 'eskandar.pola@codingstreamer.com',
    ),
)]
#[OA\License(name: 'MIT')]
class OpenApiSpecs {}
