# Documentation

* [Installation](#installation)
* [Setup](#setup)
* [Templating](#templating)
* [Static Caching](#static-caching)
* [Control Panel](#control-panel)
* [Dashboard Widget](#dashboard-widget)
* [Permissions](#permissions)
* [Configuration](#configuration)
* [Commands](#commands)
* [Git](#git)
* [Testing](#testing)

<a name="installation"></a>
## Installation

You can install the addon using composer:

```
composer require arthurperton/popular
```

To publish the config (optional) use:

```
php artisan vendor:publish --tag=popular-config
```

<a name="setup"></a>
## Setup

Basic setup requires one step: add the Popular Script Tag just before your `</body>` tag.

```antlers
{{ popular_script }}
</body>
```

Popular will start tracking pageviews now. The total counts will be updated every minute.

You can optionally use the `unique` parameter to track unique pageviews only:
 
```antlers
{{ popular_script unique="true" }}
```

<a name="templating"></a>
## Templating

There are two ways of display pageview counts on the frontend. You can use the computed field on your entries or try the dedicated tag. 

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

### Using the Tag

Alternatively you can use the `{{ pageview_count }}` tag anywhere in your template. It will get the entry `id` from the context:

```antlers
{{ pageview_count }}
```

Or you can provide it using a parameter:

```antlers
{{ pageview_count id="home" }}
```

Using a variable:

```antlers
{{ pageview_count :id="some_variable" }}
```

### Shorten Modifier

Sometimes you want to display large numbers in a shortened format. So for example `25,314` becomes `25K`. The `shorten` modifier does that for you.

```antlers
{{ pageviews | shorten }}
```

Some examples:

```yaml
dozen: 12
lots: 25314
omg: 9245021
```

```antlers
{{ dozen | shorten }}
{{ lots | shorten }}
{{ omg | shorten }}
```

```html
12
25K
9.2M
```

<a name="static-caching"></a>
## Static Caching

Popular was designed with static caching in mind. By simply using the `{{ nocache }}` tag you can combine fast page loads with current pageview counts.

### Pageview Count Tag

Just wrap your `{{ pageview_count }}` tag in a `{{ nocache }}` tag:

```antlers
{{ nocache }} {{ pageview_count }} {{ /nocache }}
```

### Collection Tag

No need to wrap the entire collection tag pair. Instead just use the `{{ pageview_count }}` tag inside the loop and wrap that in a `{{ nocache }}` tag:

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
<a name="control-panel"></a>
## Control Panel

A `Pageviews` field will be shown in your blueprints automatically.

<a name="dashboard-widget"></a>
## Dashboard Widget

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

<a name="permissions"></a>
## Permissions

Two permissions are added:

* `view pageviews`
* `edit pageviews`


<a name="configuration"></a>
## Configuration

You can disable to pageview tracker if you want, for example in your local environment. Just put this in your `.env` file:

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

<a name="commands"></a>
## Commands

If you want to reset all your pageview counts to zero in one go, you can use the `php please popular:reset` command in your CLI. Use it with care.

<a name="git"></a>
## Git

You probably want your collected pageviews under version control. By default this file is at `storage\popular\pageviews` which is included normally.

<a name="testing"></a>
## Testing

You can try out Popular locally. A scheduled task runs every minute to update the total pageview counts, so make sure the scheduler is running. You can run it locally using `php artisan schedule:work`.

Popular does its best to count a pageview just once per user session (or ever less, when tracking unique pageviews). So during testing, be aware that slamming that refresh button won't increase your pageview counts :)

Enjoy the addon!
