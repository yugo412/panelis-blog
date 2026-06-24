# Panelis Blog

Manage blog articles directly from the Panelis admin panel.

## Features

* Article management
* Draft and published articles
* Rich text editor
* Featured image support
* Slug generation
* Automatic Panelis plugin discovery

## Requirements

* PHP 8.3+
* Laravel 13+
* Filament 5+

## Installation

Install the package via Composer:

```bash
composer require yugo/panelis-blog
```

Run migrations:

```bash
php artisan migrate
```

## Usage

After installation, a **Blog** menu will be available in the Panelis admin panel.

The Blog module provides a simple way to create and manage articles without requiring additional configuration.

Available fields include:

* Title
* Slug
* Content
* Featured image
* Publication status

Articles can be saved as drafts or published when ready.

## License

The MIT License (MIT).
