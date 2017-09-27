Ok, here's how this works. You want to link to a file (e.g. a PDF or a JPG) but the browser is loading it instead of actually downloading it into the users Downloads folder.

Download File to the rescue!

We've created a plugin which works in 2 parts:

1. It creates a URL which points to a special template designed to serve files
2. It automatically converts a template into a file serving machine!

Other benefits.

1. Paths to your download files are hidden, with a BASE 64 string served instead
2. It's free - as in beer, so enjoy.
3. It will prevent hotlinking! To do this you must be serving your files from a consistent domain e.g. www.mysite.com

## FAQ

### Can I use this hotlinking preventing feature if I'm running a sub domain for my dev environment?

Yes, the restrict parameter is just looking for the existance of a string within the referring URL. For example
if you have:

dev.mysite.com
mysite.com
mysite.net

You can just use restrict="mysite." to allow all three.