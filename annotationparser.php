<?php

namespace Exegesis;

/**
 * Parses a documentation string and extracts annotations.  There are
 * blacklist for popular annotations currently in use so that, if desired, the
 * parser will only cache custom annotations.
 *
 * @uses AnnotationParserInterface
 * @package Exegesis
 * @version 0.7 (Beta 2)
 * @copyright Copyright (c) 2012 Matt Wallace All rights reserved.
 * @author Matt Wallace <matthew.wallace@ieee.org>
 * @license http://www.opensource.org/licenses/mit-license.html MIT Public License.
 */
class AnnotationParser implements AnnotationParserInterface {

    // statics to identify blacklist
    const PHPDOC = 8;

	/**
	 * Holds the class name of the optional custom parser that a user might
	 * wish to use.
	 *
	 * @var string
	 * @access private
	 * @static
	 */
    private static $parser=null;

	/**
	 * Contains the documentation string passed to the parser
	 *
	 * @var string
	 * @access private
	 */
	private $docs;

	/**
	 * Array of the processed and accepted annotations
	 *
	 * @var array
	 * @access private
	 */
	private $annotations = [];

	/**
	 * phpdoc blacklist
	 *
	 * @var array
	 * @access private
	 */
	private static $phpdoc = [
			'@api',
			'@access',
			'@author',
			'@category',
			'@copyright',
			'@deprecated',
			'@example',
			'@filesource',
			'@global',
			'@ignore',
			'@inheritdoc',
			'@internal',
			'@license',
			'@link',
			'@method',
			'@package',
			'@param',
			'@property',
			'@property-read',
			'@property-write',
			'@return',
			'@see',
			'@since',
			'@subpackage',
			'@static',
			'@throws',
			'@throw',
			'@todo',
			'@uses',
			'@used-by',
			'@var',
			'@version',
         ];

    private static $blacklist = [];

	/**
	 * Constructor
	 *
	 * @param string $docs
	 * @access public
	 * @return void
	 */
	public function __construct($docs, $filter = 0) {
		$this->docs = $docs;
	}

    private function parse() {
		// Remove the comment markers
		$docs = str_replace(['/*', '*/', '*'], '', $this->docs);

		// remove blank lines
		$docs = trim($docs);
		$docs = preg_replace('/\n\s*\n+/', "\n", $docs);

		// break the documentation into lines
		$lines = explode("\n", $docs);

		// check each string
		foreach ($lines as &$line) {
			// remove excess white space
			$line = trim($line);

			// split off the first token
			$line = explode(' ', $line, 2);

			// skip if the line does not start with an annotation
			if (substr($line[0], 0, 1) !== '@')
				continue;

			// check for an array annotation
			if (substr($line[0], -2) === '[]') {
				$array = true;
				$line[0] = substr($line[0], 0, -2);
			}

			// skip if the annotation is on the blacklist
			if (self::$blacklist && in_array($line[0], self::$blacklist))
				continue;

			// check for case where there are no arguments (flag)
			if (count($line) == 1) {
				if(!array_key_exists($line[0], $this->annotations))
					$this->annotations[$line[0]] = null;
			}

			// process arguments
			else {
				// check for an array argument and parse if there is one
				if(preg_match('/[\[|\{|\(]\s*(\s*|\w+\s*(,\s*\w+\s*)*)[\]|\}|\)]/', $line[1])) {
					// remove all spaces and brackets so we have only words and commas
					$line[1] = preg_replace('/[\[|\]|\{|\}|\(|\)|\s+]/', '', $line[1]);

					// split on the commas
					$line[1] = explode(',', $line[1]);
					$line[1] = array_filter($line[1]);
				}

				// If no array and argument is a valid word
				else if (preg_match('/\s*\w+\s*/', $line[1])) {
					$line[1] = trim($line[1]);
				}

				// argument invalid so bail out
				else
					continue;

				// non array annotation
				if (is_array($line[1])) {
					// first occurence
					if(!array_key_exists($line[0], $this->annotations))
						$this->annotations[$line[0]] = [$line[1]];
					// second or greater occurence
					else
						array_push($this->annotations[$line[0]], $line[1]);
				} else
					if(!array_key_exists($line[0], $this->annotations))
						$this->annotations[$line[0]] = $line[1];
			}
		}
	}

	/**
	 * Returns an array of the parsed annotations
	 *
	 * @access public
	 * @return void
	 */
	public function getAnnotationArray() {
		// lazy instantiation of the annotations array
		if (empty($this->annotations)) {
			// custom parser?
			if (self::$parser) {
				$parser = new self::$parser($this->docs);
				$this->annotations = $parser->getAnnotationArray();
			}
			// use built in parser
			else
				$this->parse();
		}
		return $this->annotations;
	}

	/**
	 * Allows the user to specify a custom parser to be used.
	 *
	 * @param string $parser
	 * @static
	 * @access public
	 * @return void
	 */
	public static function setParser($parser) {
		$this->parser = $parser;
    }

    /**
     * Allows selection of builtin blacklists.  In order to select multiple
     * lists use the pipe ( '|' )  to merge them.
     *
     * Available lists are:
     *  * PHPDOC
     *
     * @param integer $filter
     * @static
     * @access public
     * @return void
     */
    public static function setBlacklist($filter) {
        if ($filter & self::PHPDOC)
            self::$blacklist = array_merge(self::$blacklist, self::$phpdoc);
    }

    /**
     * Add all items in the given array to the blacklist of annotations to
     * ignore.
     *
     * @param array $array
     * @static
     * @access public
     * @return void
     */
    public static function addBlacklistItems($array) {
        self::$blacklist = array_merge(self::$blacklist, $array);
    }

    /**
     * Remove all items in the given array from the blacklist of annotations to
     * ignore.
     *
     * @param array $array
     * @static
     * @access public
     * @return void
     */
    public static function removeBlacklistItems($array) {
        self::$blacklist = array_diff(self::$blacklist, $array);
    }
}
