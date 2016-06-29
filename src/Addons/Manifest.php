<?php
namespace Codex\Addons;

use Sebwite\Filesystem\Filesystem;

class Manifest extends \Illuminate\Support\Collection
{
    /** @var string */
    protected $manifestPath;

    /** @var \Sebwite\Filesystem\Filesystem */
    protected $fs;

    /**
     * Manifest constructor.
     *
     * @param string                         $manifestPath
     * @param \Sebwite\Filesystem\Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        parent::__construct();
        $this->fs = $fs;
    }

    /**
     * @param array|string $manifestPath
     *
     * @return \Codex\Addons\Manifest
     */
    public static function make()
    {
        return app(static::class);
    }

    public function get($key, $default = null)
    {
        return data_get($this->items, $key, $default);
    }

    public function load()
    {
        $manifest    = $this->fs->get($this->getManifestPath());
        $this->items = json_decode($manifest, true);
        return $this;
    }

    public function getManifestPath()
    {
        return $this->manifestPath ?: config('codex.paths.manifest', storage_path('codex.json'));
    }

    /**
     * Set the manifestPath value
     *
     * @param string $manifestPath
     *
     * @return static
     */
    public function setManifestPath($manifestPath)
    {
        $this->manifestPath = $manifestPath;
        return $this;
    }

    /** @return static */
    public function add($value)
    {
        $this->items[] = $value;
        return $this;
    }

    public function save()
    {
        $manifest = json_encode($this->items);
        $this->fs->put($this->getManifestPath(), $manifest);
        return $this;
    }

    public function value()
    {
        return $this->items[ 0 ];
    }

    /** @return static */
    public function set($key, $value = null)
    {
        data_set($this->items, $key, $value);
        return $this;
    }

    public function whereHas($key, $value)
    {
        return $this->filter(function ($item) use ($key, $value)
        {
            return in_array($value, data_get($item, $key, [ ]), true);
        });
    }


}
