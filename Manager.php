<?php

/*
 * This file is part of the ZapikSubdomainTranslationBUndle package.
 *
 * (c) Alois Kužela <kuzela.alois@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zapik\SubdomainTranslationBundle;

use Symfony\Component\Yaml\Yaml;
use InvalidArgumentException;

/**
 * Manages translations/locales/languages/subdomains
 *
 * TODO add administration of translations?
 */
class Manager
{
    /**
     *
     * @var array all allowed languages
     * array(code => language name, 'en' => 'English')
     * first one is preferred if no suitable is found
     */
    protected $availableLanguages;

    public function __construct(array $available_languages)
    {
        $this->availableLanguages = $available_languages;
    }

    public function isAvailable($code)
    {
        return isset($this->availableLanguages[$code]);
    }

    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
    }

    public function getAvailableLanguageName($code)
    {
        return $this->availableLanguages[$code];
    }

    public function getAvailableLanguageCodes()
    {
        return array_keys($this->availableLanguages);
    }

    public function getLanguageName($code)
    {
        $languages = $this->getLanguages();

        return isset($languages[$code]) ? $languages[$code] : $code;
    }

}
