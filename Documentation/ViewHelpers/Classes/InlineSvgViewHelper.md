# InlineSvgViewHelper

This ViewHelper renders an inline svg image from a given svg resource.

Usages:
```html
<xt3:inlineSvg
    src="{pathToSource}"
    aria-hidden="true"
    class="myclass"
    width="600"
    height="300"
/>
```

Params:

- `src`* (string) - Path to the svg file
- `id` (string) - Id to set in the svg
- `aria-hidden` (string) - Sets the visibility of the svg for screen readers
- `class` (string) - Css class(es) for the svg
- `width` (string) - Width of the svg
- `height` (string) - Height of the svg
- `viewBox` (string) - Specifies the view box for the svg
- `title` (string) - Title of the svg
- `data` (array) - Array of data-attributes

(*) required
