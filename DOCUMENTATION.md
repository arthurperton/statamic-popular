# Documentation

(WIP)

## Installation

Install using composer:

```
composer require arthurperton/popular
```

Publish config (optional):

```
php artisan vendor:publish --tag=popular-config
```

## Add the Pageview Tracker to Your Layout

Add the Popular Script Tag just before your `</body>` tag.

```antlers
    {{ popular_script }}
    </body>
```

## Templating

### Using the Computed Field

All entries have a computed field called `pageviews` containing the current pageview count for that entry.

```antlers
<ol>
    {{ collection:blog limit="5" sort="pageviews:desc" }}
    <li>
        <a href="{{ url }}">
            {{ title }} ({{ pageviews }})
        </a>
    </li>
    {{ /collection:blog }}
</ol>
```

### Using the Pageview Count Tag

Use the id from the current context:

```antlers
{{ pageview_count }}
```

Or specify the entry id:

```antlers
{{ pageview_count id="home" }}
```

Using a variable:

```antlers
{{ pageview_count :id="some_variable" }}
```

## Static Caching

### Pageview Count Tag

Just wrap your `{{ pageview_count }}` tag in a `{{ nocache }}` tag:

```antlers
{{ nocache }} {{ pageview_count }} {{ /nocache }}
```

### Collection Tag

No need to wrap the entire collection tag pair. Just use the `{{ pageview_count }}` tag instead inside the loop and wrap that in a `{{ nocache }}` tag:

```antlers
<ol>
    {{ collection:blog limit="5" sort="pageviews:desc" }}
    <li>
        <a href="{{ url }}">
            {{ title }} ({{ nocache }} {{ pageview_count }} {{ /nocache }})
        </a>
    </li>
    {{ /collection:blog }}
</ol>
```

## Control Panel

A `Pageviews` field will be shown in your blueprints automatically.

### Dashboard Widget

You can add the Popular widget to your dashboard, which is (almost) a drop-in replacement for the Collection widget:

```php
// config/statamic/cp.php
 
'widgets' => [
    'getting_started',
    [ 
      'type' => 'popular',
      'collection' => 'blog',
      'limit' => 5,
    ], 
],
```

## Configuration

You can disable to pageview tracker, for example in your local environment:

```env
POPULAR_TRACKER_ENABLED=false
```

You can also opt-out of automatically adding the `Pageviews` field:

```env
POPULAR_ADD_FIELD=false
```

All collections are tracked by default. To include or exclude certain collections, update the config file at `config/popular.php`:

```php
return [
    'include_collections' => ['*'],
    'exclude_collections' => [],
];
```
