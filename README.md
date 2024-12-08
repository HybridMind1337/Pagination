# Hybrid Pagination

Hybird Pagination is a modern, lightweight PHP library for generating paginated content. Designed with flexibility in mind, it supports AJAX-based pagination, Bootstrap styling, Font Awesome icons, and customizable configurations to suit your needs.

---

## Requirements
- **PHP 7.4 or higher**: The library leverages modern PHP features.
- **Composer**: For dependency management.
- **Bootstrap (optional)**: For styling the pagination output.
- Font Awesome (optional)**: If you prefer using Font Awesome icons.

---

## Features

- **AJAX Support**: Seamlessly integrates AJAX for smooth, page-less navigation.
- **Bootstrap Compatibility**: Fully compatible with Bootstrap's pagination styles.
- **Font Awesome Icons**: Includes beautiful icons for navigation.
- **Customizable**: Easily customize labels, tooltips, and display options.
- **Responsive Design**: Pagination adapts to different screen sizes.

---

## Usage
Here’s a basic example:

```php
require __DIR__ . '/vendor/autoload.php';

use HybridMind\Pagination;

$pagination = new Pagination([
    'showFirstLast' => true,
    'dots' => true,
    'useIcons' => true,
    'tooltip' => true,
    'useAjax' => true,
    'containerId' => 'content-container',
]);

echo $pagination->renderPagination($currentPage, $totalPages, '/example');
```

If you need to integrate AJAX with server-side content dynamically generated from a database, you can follow this pattern:
```php
use HybridMind\Pagination;

// Simulating database pagination
$currentPage = $_GET['page'] ?? 1;
$perPage = 10;
$totalItems = 100; // Replace with actual count from database
$totalPages = ceil($totalItems / $perPage);

$pagination = new Pagination([
    'showFirstLast' => true,
    'dots' => true,
    'useIcons' => true,
    'useAjax' => true,
    'containerId' => 'content-container',
]);

echo $pagination->renderPagination($currentPage, $totalPages, '/ajax-endpoint');
```

```javascript
function ajaxPagination(url, containerId) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.querySelector(`#${containerId}`).innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
}
```

---

## Options

You can customize the pagination by passing an array of options to the `Pagination` class. Below is the list of available options:

| Option            | Type    | Default                  | Description                                                               |
|--------------------|---------|--------------------------|---------------------------------------------------------------------------|
| `showFirstLast`    | boolean | `true`                   | Show buttons for the first and last pages.                               |
| `dots`             | boolean | `true`                   | Show "..." between page ranges when applicable.                          |
| `useIcons`         | boolean | `false`                   | Use text-based icons (e.g., `<<`, `>>`) for navigation.                  |
| `tooltip`          | boolean | `true`                   | Add tooltips to the navigation buttons (e.g., "Page 1").                 |
| `useAjax`          | boolean | `false`                  | Enable AJAX pagination (requires JavaScript).                            |
| `containerId`      | string  | `'pagination-container'` | The ID of the container to update when using AJAX.                       |

---

## Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require hybridmind/pagination
```

---

## License
This project is licensed under the MIT License - feel free to use it in your personal or commercial projects.

---

## Contributing
Contributions are welcome! If you have ideas or find bugs, feel free to open an issue or submit a pull request.


