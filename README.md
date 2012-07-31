Exegesis
========

Introduction
------------

Exegesis is a simple wrapper around the existing Reflection classes made available in PHP 5 which allows for the parsing of annotations from withing the documentation blocks which can then be used within your program.

Currently there are wrappers for all but **ReflectionZendExtension** and **ReflectionExtension**.  These annotation classes should respond as expected to any methods that you would call on the Reflection classes.


Usage
-----
Annotations can either be an unquoted string or a JSON object.  Just like any other annotation use the '@' symbol to denote the annotation name. 

The parser is smart enough to handle hard-coded line wraps and still return a single string or array. One side effect of this is that any comments you wish to not be parsed as part of an annotation should be written before the first annotation or they will be considered part of the preceding annotation.

TODO: Need helpful examples here.

Blacklist
---------
There is a built in mechanism for ignoring annotations that are parsed by another framework or utility as well as a mechanism for adding any other items you may which to ignore for any reason.  At this point in time the only built in list available is the annotations for the phpdocumentor. However, in the future I intend to add lists for other tools (like Doctrine) which enjoy widespread use so that it is not necessary for you to manually add each individual annotation yourself.  For further information on blacklisting see the documentation for the parser.

Custom Parser
-------------
If the functionality of the parser does not meet your needs you can define your own parser (either from scratch or using the included parser as a template).  The details for doing so are also available in the documentation.

License
-------
Exegesis is released under the MIT license and is available on github (MattRWallace/Exegesis).  I encourage you to fork me and improve upon what I've started or to let me know what (hopefully) awesome things you've used my ode in.


Copyright (c) 2012 Matt Wallace (<matthew.wallace@ieee.org>)

Permission is hereby granted, free of charge, to any person obtaining a 
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.

