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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Changes the user language
 */
class Switcher
{
    protected $manager;

    /**
     * Instanciates a new language switcher
     **/
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Chooses a language for a request
     *
     * @return $response or null
     **/
    public function switchLocaleForRequest(Request $request)
    {
        $session = $request->getSession();
        $parts = explode('.', $request->getHost());
        if (count($parts) === 3) {
            $locale = $parts[0];
            if ($locale == $session->getLocale()) {
                return;
            }
            if ($this->manager->isAvailable($locale)) {
                $session->setLocale($locale);
                $preferred = $request->getPreferredLanguage($this->manager->getAvailableLanguageCodes());
                if ($preferred != $locale) {
                    $session->setFlash('locale_change_adjust', $preferred);
                } else {
                    $session->setFlash('locale_change_contribute', $locale);
                }
                return;
            }
            $host = $parts[1].'.'.$parts[2];
        } else {
            $host = $parts[0].'.'.$parts[1];
        }

        $locale = $request->getPreferredLanguage($this->manager->getAvailableLanguageCodes());
        $url = sprintf('http://%s.%s%s', $locale, $host, $request->getRequestUri());
        $response = new RedirectResponse($url);

        $preferredLanguage = $this->getRequestPreferredLanguage($request);
        if ($preferredLanguage && $locale != $preferredLanguage) {
            $allLanguageCodes = array_keys($this->manager->getAvailableLanguageCodes());
            if (in_array($preferredLanguage, $allLanguageCodes)) {
                $session->setFlash('locale_missing', $preferredLanguage);
            }
        }

        return $response;
    }

    private function getRequestPreferredLanguage(Request $request)
    {
        foreach ($request->getLanguages() as $language) {
            if (preg_match('/^[a-z]{2,3}$/i', $language)) {
                return $language;
            }
        }
    }
}
