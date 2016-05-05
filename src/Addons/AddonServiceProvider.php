<?php
namespace Codex\Core\Addons;

use Sebwite\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    protected $scanDirs = true;

    /**
     * @param string $assetsDestinationPath
     *
     * @return ServiceProvider
     */
    public function setAssetsDestinationPath($assetsDestinationPath)
    {
        $this->assetsDestinationPath = $assetsDestinationPath;
        return $this;
    }

    /**
     * @param string $assetsPath
     *
     * @return ServiceProvider
     */
    public function setAssetsPath($assetsPath)
    {
        $this->assetsPath = $assetsPath;
        return $this;
    }

    /**
     * @param array $assetDirs
     *
     * @return ServiceProvider
     */
    public function setAssetDirs($assetDirs)
    {
        $this->assetDirs = $assetDirs;
        return $this;
    }

    /**
     * @param array $configFiles
     *
     * @return ServiceProvider
     */
    public function setConfigFiles($configFiles)
    {
        $this->configFiles = $configFiles;
        return $this;
    }

    /**
     * @param string $configPath
     *
     * @return ServiceProvider
     */
    public function setConfigPath($configPath)
    {
        $this->configPath = $configPath;
        return $this;
    }

    /**
     * @param string $configStrategy
     *
     * @return ServiceProvider
     */
    public function setConfigStrategy($configStrategy)
    {
        $this->configStrategy = $configStrategy;
        return $this;
    }

    /**
     * @param array $providers
     *
     * @return ServiceProvider
     */
    public function setProviders($providers)
    {
        $this->providers = $providers;
        return $this;
    }

    /**
     * @param array $viewDirs
     *
     * @return ServiceProvider
     */
    public function setViewDirs($viewDirs)
    {
        $this->viewDirs = $viewDirs;
        return $this;
    }

    /**
     * @param string $viewsPath
     *
     * @return ServiceProvider
     */
    public function setViewsPath($viewsPath)
    {
        $this->viewsPath = $viewsPath;
        return $this;
    }

    /**
     * @param string $viewsDestinationPath
     *
     * @return ServiceProvider
     */
    public function setViewsDestinationPath($viewsDestinationPath)
    {
        $this->viewsDestinationPath = $viewsDestinationPath;
        return $this;
    }

    /**
     * @param string $resourcesPath
     *
     * @return ServiceProvider
     */
    public function setResourcesPath($resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
        return $this;
    }

    /**
     * @param string $resourcesDestinationPath
     *
     * @return ServiceProvider
     */
    public function setResourcesDestinationPath($resourcesDestinationPath)
    {
        $this->resourcesDestinationPath = $resourcesDestinationPath;
        return $this;
    }

    /**
     * @param mixed $rootDir
     *
     * @return ServiceProvider
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
        return $this;
    }

    /**
     * @param string $dir
     *
     * @return ServiceProvider
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }

}