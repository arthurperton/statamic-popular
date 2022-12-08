![GitHub release](https://flat.badgen.net/github/release/arthurperton/statamic-popular)
![Statamic](https://flat.badgen.net/badge/Statamic/3.0+/FF269E)

# Popular – addon for Statamic

**Popular** tracks the popular of your content. It registers all page views for individual pages and entries.

- Always know which content is the most popular with your visitors
- Create lists for popular items, for example top 5 most popular blog posts
- Show a read count for each article on your frontend

## Documentation

Have a look at the full [documentation](https://statamic.com/addons/arthurperton/popular/docs) for more details.

## Templating Example

To show a top 5 of your most read blog posts, simply do this:

```antlers
<ol>
    {{ collection from="blog" limit="5" sort="pageviews:desc" }}
        <li>{{ title }} ({{ pageviews }})</li>
    {{ /collection }}
</ol>
```

## Requirements

- PHP 7.4+
- Statamic v3.3.48+

Popular uses the SQLite3 PHP extension, which is enabled by default.

## License

Popular is **commercial software** but has an open-source codebase. If you want to use it in production, you'll need to [buy a license from the Statamic Marketplace](https://statamic.com/addons/arthurperton/popular).

## Credits

Developed by [Arthur Perton](https://www.webenapp.nl)
