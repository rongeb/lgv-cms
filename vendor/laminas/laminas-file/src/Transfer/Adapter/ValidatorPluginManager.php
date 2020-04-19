<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\File\Transfer\Adapter;

use Laminas\Validator\File;
use Laminas\Validator\ValidatorPluginManager as BaseManager;

/**
 * @deprecated since 2.7.0, and scheduled for removal with 3.0.0
 */
class ValidatorPluginManager extends BaseManager
{
    protected $defaultFileValidationAliases = [
        'count'            => File\Count::class,
        'Count'            => File\Count::class,
        'crc32'            => File\Crc32::class,
        'Crc32'            => File\Crc32::class,
        'CRC32'            => File\Crc32::class,
        'excludeextension' => File\ExcludeExtension::class,
        'excludeExtension' => File\ExcludeExtension::class,
        'ExcludeExtension' => File\ExcludeExtension::class,
        'excludemimetype'  => File\ExcludeMimeType::class,
        'excludeMimeType'  => File\ExcludeMimeType::class,
        'ExcludeMimeType'  => File\ExcludeMimeType::class,
        'exists'           => File\Exists::class,
        'Exists'           => File\Exists::class,
        'extension'        => File\Extension::class,
        'Extension'        => File\Extension::class,
        'filessize'        => File\FilesSize::class,
        'filesSize'        => File\FilesSize::class,
        'FilesSize'        => File\FilesSize::class,
        'hash'             => File\Hash::class,
        'Hash'             => File\Hash::class,
        'imagesize'        => File\ImageSize::class,
        'imageSize'        => File\ImageSize::class,
        'ImageSize'        => File\ImageSize::class,
        'iscompressed'     => File\IsCompressed::class,
        'isCompressed'     => File\IsCompressed::class,
        'IsCompressed'     => File\IsCompressed::class,
        'isimage'          => File\IsImage::class,
        'isImage'          => File\IsImage::class,
        'IsImage'          => File\IsImage::class,
        'md5'              => File\Md5::class,
        'Md5'              => File\Md5::class,
        'MD5'              => File\Md5::class,
        'mimetype'         => File\MimeType::class,
        'mimeType'         => File\MimeType::class,
        'MimeType'         => File\MimeType::class,
        'notexists'        => File\NotExists::class,
        'notExists'        => File\NotExists::class,
        'NotExists'        => File\NotExists::class,
        'sha1'             => File\Sha1::class,
        'Sha1'             => File\Sha1::class,
        'SHA1'             => File\Sha1::class,
        'size'             => File\Size::class,
        'Size'             => File\Size::class,
        'upload'           => File\Upload::class,
        'Upload'           => File\Upload::class,
        'wordcount'        => File\WordCount::class,
        'wordCount'        => File\WordCount::class,
        'WordCount'        => File\WordCount::class,
    ];

    /**
     * Constructor
     *
     * Merges default aliases pertinent to this plugin manager with those
     * defined in the parent filter plugin manager.
     *
     * @param null|\Laminas\ServiceManager\ConfigInterface|\Interop\Container\ContainerInterface $configOrContainerInstance
     * @param array $v3config If $configOrContainerInstance is a container, this
     *     value will be passed to the parent constructor.
     */
    public function __construct($configOrContainerInstance = null, array $v3config = [])
    {
        $this->aliases = array_merge($this->defaultFileValidationAliases, $this->aliases);
        parent::__construct($configOrContainerInstance, $v3config);
    }
}
