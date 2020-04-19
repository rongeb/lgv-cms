# Component Installer for Laminas Applications
[![Build Status](https://travis-ci.org/laminas/laminas-component-installer.svg?branch=master)](https://travis-ci.org/laminas/laminas-component-installer)
[![Coverage Status](https://coveralls.io/repos/github/laminas/laminas-component-installer/badge.svg?branch=master)](https://coveralls.io/github/laminas/laminas-component-installer?branch=master)

This repository contains the Composer plugin class `Laminas\ComponentInstaller\ComponentInstaller`,
which provides Composer event hooks for the events:

- post-package-install
- post-package-uninstall

## Via Composer global install

To install the utility for use with all projects you use:

```bash
$ composer global require laminas/laminas-component-installer
```

## Per project installation

To install the utility for use with a specific project already managed by
composer:

```bash
$ composer require laminas/laminas-component-installer
```

## Writing packages that utilize the installer

Packages can opt-in to the workflow from laminas-component-installer by defining
one or more of the following keys under the `extra.laminas` configuration in their
`composer.json` file:

```json
"extra": {
  "laminas": {
    "component": "Component\\Namespace",
    "config-provider": "Classname\\For\\ConfigProvider",
    "module": "Module\\Namespace"
  }
}
```

- A **component** is for use specifically with laminas-mvc + laminas-modulemanager;
  a `Module` class **must** be present in the namespace associated with it.
  The setting indicates a low-level component that should be injected to the top
  of the modules list of one of:
  - `config/application.config.php`
  - `config/modules.config.php`
  - `config/development.config.php`

- A **module** is for use specifically with laminas-mvc + laminas-modulemanager;
  a `Module` class **must** be present in the namespace associated with it.
  The setting indicates a userland or third-party module that should be injected
  to the bottom of the modules list of one of:
  - `config/application.config.php`
  - `config/modules.config.php`
  - `config/development.config.php`

- A **config-provider** is for use with applications that utilize
  [mezzio-config-manager](https://github.com/mtymek/mezzio-config-manager)
  or [laminas-config-aggregator](https://github.com/laminas/laminas-config-aggregator)
  (which may or may not be Mezzio applications). The class listed must be an
  invokable that returns an array of configuration, and will be injected at the
  top of:
  - `config/config.php`
