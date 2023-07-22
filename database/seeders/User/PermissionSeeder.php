<?php

namespace Database\Seeders\User;

use App\Models\User\Permission;
use Illuminate\Database\Seeder;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $models = $this->getModels();

        foreach ($models as $model) {
            $permissions = $this->generateCRUDPermissionsForModel($model);
            foreach ($permissions as $permission) {
                Permission::create(['permission' => $permission]);
            }
        }
    }

    private function generateCRUDPermissionsForModel(string $modelName): array
    {
        $actions = ['Create', 'Read', 'Update', 'Delete', 'Force_Delete', 'Restore'];
        return array_map(fn(string $action) => strtoupper("{$action}_$modelName"), $actions);
    }

    private function getModels(): array
    {
        $path = app_path('Models/');
        $directoryRecursiveIterator = new RecursiveDirectoryIterator($path);
        $recursiveIteratorIterator = new RecursiveIteratorIterator($directoryRecursiveIterator);

        return array_map(
            fn(SplFileInfo $file) => explode('.', $file->getBasename())[0],
            array_filter(
                iterator_to_array($recursiveIteratorIterator),
                fn(SplFileInfo $file) => is_file($file),
            )
        );
    }
}
