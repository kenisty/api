<?php declare(strict_types=1);

namespace Database\Seeders\User;

use App\Enum\PermissionActions;
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

    private function getModels(): array
    {
        $path = app_path('Models/');
        $directoryRecursiveIterator = new RecursiveDirectoryIterator($path);
        $recursiveIteratorIterator = new RecursiveIteratorIterator($directoryRecursiveIterator);

        return array_map(
            static fn(SplFileInfo $file) => explode('.', $file->getBasename())[0],
            array_filter(
                iterator_to_array($recursiveIteratorIterator),
                static fn(SplFileInfo $file) => is_file($file->getPathname()) && !str_ends_with(explode('.php', $file->getFilename())[0], 'Trait'),
            ),
        );
    }

    private function generateCRUDPermissionsForModel(string $modelName): array
    {
        $actions = [
            PermissionActions::CREATE->value,
            PermissionActions::UPDATE->value,
            PermissionActions::DELETE->value,
            PermissionActions::FORCE_DELETE->value,
            PermissionActions::RESTORE->value,
        ];

        return array_map(static fn(string $action) => mb_strtoupper("{$action}_$modelName"), $actions);
    }
}
