<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        $storage = Storage::disk('images');

        if (!$storage->exists($fixturesDir)) {
            $storage->makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("/tests/Fixtures/images/$fixturesDir"),
            $storage->path($storageDir),
            false
        );

        return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
    }
}
