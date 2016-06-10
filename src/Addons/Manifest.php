<?php
namespace Codex\Addons;

use Codex\Support\Collection;
use Sebwite\Filesystem\Filesystem;

class Manifest extends Collection
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
    public function __construct($manifestPath, Filesystem $fs)
    {
        parent::__construct();
        $this->manifestPath = $manifestPath;
        $this->fs           = $fs;
    }

    public function load()
    {
        $manifest    = $this->fs->get($this->manifestPath);
        $this->items = json_decode($manifest, true);
        return $this;
    }

    public function save()
    {
        $manifest = json_encode($this->items);
        $this->fs->put($this->manifestPath, $manifest);
        return $this;
    }


    /**
     * @param array|string $manifestPath
     *
     * @return \Codex\Addons\Manifest
     */
    public static function make($manifestPath = [ ])
    {
        return app(static::class, compact('manifestPath'));
    }

    public function getPaths()
    {
        return $this->get('paths', [ ]);
    }

    public function addPath($path)
    {
        $this->set('paths', array_merge((array)$path, $this->get('paths', [ ])));
        return $this;
    }

    public function addFile($filePath)
    {
        $this->add($filePath);
    }

    public function get($key, $default = null)
    {
        return data_get($this->items, $key, $default);
    }

}
