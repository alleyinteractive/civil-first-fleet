# Entry Points Directory

This directory should contain a subdirectory for each entry point defined in webpack. Each entry point will output a separate compiled JavaScript file. You may require dependencies of several file types in JavaScript, and webpack will compile with the required sourcemaps, data urls, relative URIs. Compiled code and files are output to `/client/build/` where they will be accessible to your `enqueue` functions or template tags. ES6 syntax in your scripts will be transpiled by Babel.

Each entry subdirectory can contain files (JS or CSS) specific to that entry point. For example:
```txt
js
&lfloor; article // Article specific JS
&lfloor; &lfloor; article.js // Loads all article JS
&lfloor; &lfloor; bar.js // Some article-specific JS, loaded by article.js
&lfloor; home // Homepage JS
&lfloor; &lfloor; home.js // Loads all homepage JS
&lfloor; &lfloor; baz.js // Some homepage-specific JS, loaded by home.js
```
