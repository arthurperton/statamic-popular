# Documentation

## Installation

## Templating

### Setting up the Pageview Tracker

Add the Popular Script Tag just before your `</body>` tag.

```antlers
    {{ popular_script }}
    </body>
```

### Using the Pageviews Computed Field

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

```antlers
{{ pageview_count }}
```

```antlers
{{ pageview_count id="home" }}
```

```antlers
{{ pageview_count :id="some_variable" }}
```

### Static Caching

```antlers
{{ nocache }} {{ pageview_count }} {{ /nocache }}
```

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

## Configuration

```
php artisan vendor:publish --tag=popular-config
```
