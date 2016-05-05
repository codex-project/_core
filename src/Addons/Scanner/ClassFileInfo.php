<?php
/**
 * Copyright (c) 2012-2013 Maximilian Reichel <info@phramz.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Codex\Core\Addons\Scanner;

use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ClassFileInfo
 * @package Codex\Core\Addons\Tests\Scanner
 */
class ClassFileInfo extends SplFileInfo
{
    /**
     * @var SplFileInfo
     */
    private $fileInfo = null;

    /**
     * @var ClassInspector
     */
    private $classInspector = null;

    public function __construct(SplFileInfo $fileInfo, ClassInspector $classInspector)
    {
        $this->fileInfo       = $fileInfo;
        $this->classInspector = $classInspector;
    }

    public function getClassName()
    {
        return $this->classInspector->getClassName();
    }

    protected function filter($annotations, $filterEmpty = false, $filterAnnotations = null)
    {
        return array_filter($annotations, function ($b) use ($filterEmpty, $filterAnnotations) {
            if ( $filterEmpty && empty($b) ) {
                return false;
            }

            if ( $filterAnnotations !== null ) {
                if ( is_object($b) ) {
                    return in_array(get_class($b), (array)$filterAnnotations, true);
                } elseif ( is_array($b) ) {
                    $pass = false;
                    foreach ( $b as $name => $obj ) {
                        $class = get_class($obj);
                        foreach ( (array)$filterAnnotations as $annotation ) {
                            if ( $class === $annotation ) {
                                $pass = true;
                            }
                        }
                    }
                    return $pass;
                }
            }
            return true;
        });
    }

    public function getClassAnnotations($filterEmpty = false, $filterAnnotations = null)
    {
        return $this->filter($this->classInspector->getClassAnnotations(), $filterEmpty, $filterAnnotations);
    }

    public function getMethodAnnotations($filterEmpty = false, $filterAnnotations = null)
    {
        return $this->filter($this->classInspector->getMethodAnnotations(), $filterEmpty, $filterAnnotations);
        $a = $this->classInspector->getMethodAnnotations();
        return $filter === false ? $a : array_filter($a, create_function('$b', 'return ! empty($b);'));
    }

    public function getPropertyAnnotations($filterEmpty = false, $filterAnnotations = null)
    {
        return $this->filter($this->classInspector->getPropertyAnnotations(), $filterEmpty, $filterAnnotations);
        $a = $this->classInspector->getPropertyAnnotations();
        return $filter === false ? $a : array_filter($a, create_function('$b', 'return ! empty($b);'));
    }

    public function getPath()
    {
        return $this->fileInfo->getPath();
    }

    public function getFilename()
    {
        return $this->fileInfo->getFilename();
    }

    public function getExtension()
    {
        return $this->fileInfo->getExtension();
    }

    public function getBasename($suffix = null)
    {
        return $this->fileInfo->getBasename($suffix);
    }

    public function getPathname()
    {
        return $this->fileInfo->getPathname();
    }

    public function getPerms()
    {
        return $this->fileInfo->getPerms();
    }

    public function getInode()
    {
        return $this->fileInfo->getInode();
    }

    public function getSize()
    {
        return $this->fileInfo->getSize();
    }

    public function getOwner()
    {
        return $this->fileInfo->getOwner();
    }

    public function getGroup()
    {
        return $this->fileInfo->getGroup();
    }

    public function getATime()
    {
        return $this->fileInfo->getATime();
    }

    public function getMTime()
    {
        return $this->fileInfo->getMTime();
    }

    public function getCTime()
    {
        return $this->fileInfo->getCTime();
    }

    public function getType()
    {
        return $this->fileInfo->getType();
    }

    public function isWritable()
    {
        return $this->fileInfo->isWritable();
    }

    public function isReadable()
    {
        return $this->fileInfo->isReadable();
    }

    public function isExecutable()
    {
        return $this->fileInfo->isExecutable();
    }

    public function isFile()
    {
        return $this->fileInfo->isFile();
    }

    public function isDir()
    {
        return $this->fileInfo->isDir();
    }

    public function isLink()
    {
        return $this->fileInfo->isLink();
    }

    public function getLinkTarget()
    {
        return $this->fileInfo->getLinkTarget();
    }

    public function getRealPath()
    {
        return $this->fileInfo->getRealPath();
    }

    public function getFileInfo($class_name = null)
    {
        return $this->fileInfo->getFileInfo($class_name);
    }

    public function getPathInfo($class_name = null)
    {
        return $this->fileInfo->getPathInfo($class_name);
    }

    public function openFile($open_mode = 'r', $use_include_path = false, $context = null)
    {
        return $this->fileInfo->openFile($open_mode, $use_include_path, $context);
    }

    public function setFileClass($class_name = null)
    {
        $this->fileInfo->setFileClass($class_name);
    }

    public function setInfoClass($class_name = null)
    {
        $this->fileInfo->setInfoClass($class_name);
    }

    public function getRelativePath()
    {
        return $this->fileInfo->getRelativePath();
    }

    public function getRelativePathname()
    {
        return $this->fileInfo->getRelativePathname();
    }

    public function getContents()
    {
        return $this->fileInfo->getContents();
    }

    public function __toString()
    {
        return $this->fileInfo->__toString();
    }
}
