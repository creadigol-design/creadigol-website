# Brand fonts

Place the licensed webfont files here, named exactly:

- `Druk-Web-Bold.woff2` (Druk Bold, Commercial Type web licence)
- `Supply-Regular.woff2`

They are git-ignored so the public repository never carries licensed font binaries.
Until they are present the theme falls back to Impact / Arial Narrow for headlines and a
system monospace for labels, which is legible but not the brand.

`Poppins-*.woff2` (Open Font Licence) is the body face and is committed with the theme.

`VulfSans-Regular.woff2`, `VulfSans-Italic.woff2`, `VulfSans-Medium.woff2`, `VulfSans-Bold.woff2` (OH no Type Co, web licence required) are the intended body face. Git-ignored. When present the theme uses them; when absent it falls back to Poppins.
