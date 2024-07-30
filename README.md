<div align="center">

![Extension icon](Resources/Public/Icons/Extension.svg)

# TYPO3 extension `xima_typo3_toolbox`

[![Supported TYPO3 versions](https://badgen.net/badge/TYPO3/v12/orange)]()

</div>

This extension provides several tools for TYPO3 integrators and developers.

Features:
- Backend toolbar item for project version and application context
- Frontend hint for technical context information
- Last updated information within system information toolbar
- Application context endpoint
- Frontend editing link within content elements for editors

# Installation

``` bash
composer require xima/xima-typo3-toolbox
```

# Configuration

Include the static TypoScript template "TYPO3 Toolbox" or directly import it in your sitepackage:

``` typoscript
@import 'EXT:xima_typo3_toolbox/Configuration/TypoScript/setup.typoscript'
```

See `ext_localconf.php` for additional configuration options.

# Features

The backend toolbar will show the current project version and application context.

![Toolbar](./Documentation/Images/toolbar.png)

The frontend hint will show the current technical context information within dedicated contexts.

![Frontend](./Documentation/Images/frontend.png)

The "frontend editing" shows links (for logged-in users) in the frontend to easily edit content elements.
![Frontend Editing](./Documentation/Images/frontendEditing.png)
