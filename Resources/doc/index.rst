SubdomainTranslationBundle
**************************

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

Keys (en, cs) are used for subdomain name (en.example.com) and locale names.
Values (Česky, English) are currently not needed. You can use them i.e. for generating links for switching.

The first defined locale is **fallback locale**. If user specify invalid subdomain (i.e. fr.example.com) he is
redirected to this fallback locale (cs.example.com)

If you don't specify ``allowed_locales``, all possible values from file ``Resources/config/locales.xml`` are used.

Enable kernel request listener in services
------------------------------------------

::

    // services.yml
    services:
        zapik_subdomain_translation.kernel_request_listener:
            class: Zapik\SubdomainTranslationBundle\KernelRequestListener
            arguments: ["@zapik_subdomain_translation.switcher"]
            tags:
               - { name: kernel.event_listener, event: kernel.request, method: onDomainParse, priority: 0 }




Defined services and parameters
================================

**DI parameters**

* zapik_subdomain_translation.locales - all valid/enabled locales defined through ``allowed_locales`` option in config.yml


**Services**

* zapik_subdomain_translation.manager
* zapik_subdomain_translation.switcher

Plans ToDo
===========

* possible make tool for translation administration like in lichess. Symfony2 is now able to get all translation strings by
  console command, so this feature should not be needed.
