![GitHub release](https://flat.badgen.net/github/release/arthurperton/statamic-popularity)
![Statamic](https://flat.badgen.net/badge/Statamic/3.0+/FF269E)

# Popularity – addon for Statamic
**Popularity** tracks the popularity of your content. It registers all page views for individual pages and entries.

* Always know which content is the most popular with your visitors
* Create lists for popular items, for example top 5 most popular blog posts
* Show a read count for each article on your frontend

## Templating

List you top 5 most popular blog posts:
```antlers
<ol>
    {{ collection from="blog" limit="5" sort="has_pageviews|pageviews:desc" }}
        <li>{{ title }}</li>
    {{ /collection }}
</ol>
```

## Requirements

* Statamic v3

## License
Popularity is **commercial software** but has an open-source codebase. If you want to use it in production, you'll need to [buy a license from the Statamic Marketplace](https://statamic.com/addons/arthurperton/popularity).

>Popularity is **NOT** free software.

## Credits
Developed by [Arthur Perton](https://www.webenapp.nl)




