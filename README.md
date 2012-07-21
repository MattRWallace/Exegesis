Exegesis
========

Introduction
------------

Exegesis is a simple wrapper around the existing Reflection classes made available in PHP 5 which allows for the parsing of annotations from withing the documentation blocks which can then be used within your program.

Currently there are wrappers for all but **ReflectionZendExtension** and **ReflectionExtension**.  These annotation classes should respond as expected to any methods that you would call on the Reflection classes.


Usage
-----

There are four types of annotations supported at the current time:

* **Single annotation with a single value**

    *Example:* `@myAnnotation myValue`

    The annotation name is unique and the value is one string. 

* **Single annotation with an array value**

    *Example:* `@myAnnotation { array, of, values }

    As with the first example, the annotation name is unique.  The array can be enclosed with any of the standard brackets `{} [] ()` (The open and close bracket do not need to be the same type but it is good style) and elements within the array should be comma separated.

    It is important to note that commas cannot, at this point in time, be a value in an array (there is no trouble for a single value.) 
    
    For example `@myArray [ "Doe, John", "123 Road Way"]` would be parsed with elements `"Doe` `John"` and `"123 Road Way"`.  Note that any quotations within the annotation value are not used for grouping and are part of the value itself.

Blacklist
---------
There is a built in mechanism for ignoring annotations that are parsed by another framework or utility as well as a mechanism for adding any other items you may which to ignore for any reason.  At this point in time the only built in list available is the annotations for the phpdocumentor. However, in the future I intend to add lists for other tools (like Doctrine) which enjoy widespread use so that it is not necessary for you to manually add each individual annotation yourself.  For further information on blacklisting see the documentation for the parser.

Custom Parser
-------------
If the functionality of the parser does not meet your needs you can define your own parser (either from scratch or using the included parser as a template).  The details for doing so are also available in the documentation.

License
-------
Exegesis is released under the MIT license and is available on github (MattRWallace/Exegesis).  I encourage you to fork me and improve upon what I've started or to let me know what (hopefully) awesome things you've used my ode in.


Copyright (c) 2012 Matt Wallace `<matthew.wallace@ieee.org>`

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

