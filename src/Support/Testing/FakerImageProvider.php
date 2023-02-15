<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        if (!Storage::exists($fixturesDir)) {
            Storage::makeDirectory($storageDir);
        }

        $file = $this->generator->file(
            base_path("/tests/Fixtures/images/$fixturesDir"),
            storage_path($storageDir),
            false
        );

        return '/storage/' . trim($storageDir, '/') . '/' . $file;
    }
}
