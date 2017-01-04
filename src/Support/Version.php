<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Support;

class Version extends \Herrera\Version\Version
{
    protected function createBuilder()
    {
        return \Herrera\Version\Builder::create()->importVersion($this);
    }

    /**
     * fromBase method
     *
     * @param \Herrera\Version\Version $version
     *
     * @return static
     */
    protected function fromBase(\Herrera\Version\Version $version)
    {
        $this->major      = $version->getMajor();
        $this->minor      = $version->getMinor();
        $this->patch      = $version->getPatch();
        $this->build      = $version->getBuild();
        $this->preRelease = $version->getPreRelease();
        return $this;
    }

    protected function set($type, $value)
    {
        $builder = $this->createBuilder();
        call_user_func_array([ $builder, 'set' . ucfirst($type) ], [ $value ]);
        return $this->fromBase($builder->getVersion());
    }

    protected function increment($type, $amount)
    {
        $builder = $this->createBuilder();
        call_user_func_array([ $builder, 'increment' . ucfirst($type) ], [ $amount ]);
        return $this->fromBase($builder->getVersion());
    }


    /**
     * Increments the major version number and resets the minor and patch
     * version numbers to zero.
     *
     * @param integer $amount Increment by what amount?
     *
     * @return static
     */
    public function incrementMajor($amount = 1)
    {
        return $this->increment('major', $amount);
    }

    /**
     * Increments the minor version number and resets the patch version number
     * to zero.
     *
     * @param integer $amount Increment by what amount?
     *
     * @return static
     */
    public function incrementMinor($amount = 1)
    {
        return $this->increment('minor', $amount);
    }

    /**
     * Increments the patch version number.
     *
     * @param integer $amount Increment by what amount?
     *
     * @return static
     */
    public function incrementPatch($amount = 1)
    {
        return $this->increment('patch', $amount);
    }

    /**
     * Sets the build metadata identifiers.
     *
     * @param array $identifiers The build metadata identifiers.
     *
     * @return Builder The Version builder.
     *
     * @throws InvalidIdentifierException If an identifier is invalid.
     */
    public function setBuild(array $identifiers)
    {
        return $this->set('build', $identifiers);
    }

    /**
     * Sets the major version number.
     *
     * @param integer $number The major version number.
     *
     * @return Builder The Version builder.
     *
     * @throws InvalidNumberException If the number is invalid.
     */
    public function setMajor($number)
    {
        return $this->set('major', $number);
    }

    /**
     * Sets the minor version number.
     *
     * @param integer $number The minor version number.
     *
     * @return Builder The Version builder.
     *
     * @throws InvalidNumberException If the number is invalid.
     */
    public function setMinor($number)
    {
        return $this->set('minor', $number);
    }

    /**
     * Sets the patch version number.
     *
     * @param integer $number The patch version number.
     *
     * @return Builder The Version builder.
     *
     * @throws InvalidNumberException If the number is invalid.
     */
    public function setPatch($number)
    {
        return $this->set('patch', $number);
    }

    /**
     * Sets the pre-release version identifiers.
     *
     * @param array $identifiers The pre-release version identifiers.
     *
     * @return Builder The Version builder.
     *
     * @throws InvalidIdentifierException If an identifier is invalid.
     */
    public function setPreRelease(array $identifiers)
    {
        return $this->set('preRelease', $identifiers);
    }

    public function isEqualTo(Version $version)
    {
        return \Herrera\Version\Comparator::isEqualTo($this, $version);
    }

    public function isNotEqualTo(Version $version)
    {
        return \Herrera\Version\Comparator::isEqualTo($this, $version) === false;
    }

    public function isGreaterThan(Version $version)
    {
        return \Herrera\Version\Comparator::isGreaterThan($this, $version);
    }

    public function isLessThan(Version $version)
    {
        return \Herrera\Version\Comparator::isLessThan($this, $version);
    }

    public function isGreaterThanOrEqualTo(Version $version)
    {
        return $this->isGreaterThan($version) || $this->isEqualTo($version);
    }

    public function isLessThanOrEqualTo(Version $version)
    {
        return $this->isLessThan($version) || $this->isEqualTo($version);
    }
}


$v = new Version;
