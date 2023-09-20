<?php declare(strict_types=1);

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

        return array_map(static fn(string $action) => mb_strtoupper("{$action}_$modelName"), $actions);
    }

    private function getModels(): array
    {
        $path = app_path('Models/');
        $directoryRecursiveIterator = new RecursiveDirectoryIterator($path);
        $recursiveIteratorIterator = new RecursiveIteratorIterator($directoryRecursiveIterator);

        return array_map(
            static fn(SplFileInfo $file) => explode('.', $file->getBasename())[0],
            array_filter(
                iterator_to_array($recursiveIteratorIterator),
                static fn(SplFileInfo $file) => is_file($file),
            ),
        );
    }
}
