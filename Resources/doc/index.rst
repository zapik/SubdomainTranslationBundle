SubdomainTranslationBundle
**************************

(For Symfony 2.0.x)

Provides easy locale/translations switching in dependence on subdomain (3rd level domain name).

Symfony2 can actually not define routes for subdomains, so you can't define pattern for switch
locale by using routing configuration file.


Installation
============

Add SubdomainTranslatioBundle to your /vendor/bundles/ dir
-----------------------------------------------------------

Using the vendors script
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the following lines in your ``deps`` file::

    [ZapikSubdomainTranslationBundle]
        git=git://github.com/zapik/SubdomainTranslationBundle.git
        target=bundles/Zapik/SubdomainTranslationBundle

Run the vendors script::

    ./bin/vendors install

Using git submodules
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

::

    $ git submodule add git://github.com/Zapik/SubdomainTranslationBundle.git vendor/bundles/Zapik/SubdomainTranslationBundle

Add the Zapik namespace to your autoloader
-------------------------------------------

::

    // app/autoload.php

    $loader->registerNamespaces(array(
        'Zapik' => __DIR__.'/../vendor/bundles',
        // your other namespaces
    );

Add SubdomainTranslationBundle to your application kernel
----------------------------------------------------------

::

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ... core bundles
            new Zapik\SubdomainTranslationBundle\ZapikSubdomainTranslationBundle(),
            // ... your custom bundles
        );
    }

Configure your project
=======================

You should define optional list of available locales in your project configuration:

::

    // app/config/config.yml
    zapik_subdomain_translation:
        allowed_locales:
            cs: Česky
            en: English
        validate_locales: false

Keys (en, cs) are used for subdomain name (en.example.com) and locale names.
Values (Česky, English) are currently not needed. You can use them i.e. for generating links for switching.

The first defined locale is **fallback locale**. If user specify invalid subdomain (i.e. fr.example.com) he is
redirected to this fallback locale (cs.example.com)

If you don't specify ``allowed_locales``, all possible values from file ``Resources/config/locales.xml`` are used.

If **validate_locales** is enabled (by default), locale codes will be verified against values in locales.xml. 
If you need some other subdomain names (i.e. *www* with framework default_locale), 
you have to set ``validate_locales: false``

Defined services and parameters
================================

**DI parameters**

* zapik_subdomain_translation.locales - all valid/enabled locales defined through ``allowed_locales`` option in config.yml


**Services**

* zapik_subdomain_translation.manager
* zapik_subdomain_translation.switcher

