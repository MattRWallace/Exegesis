<?php

namespace MattRWallace\Exegesis;

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

    /**
     * Array containing all the arrays currently blacklisted
     *
     * @var
     * @access private
     * @statics
     */
    private static $blacklist = [];

	/**
	 * Constructor
	 *
	 * @param string $docs
	 * @access public
	 * @return void
	 */
	public function __construct($docs) {
		$this->docs = $docs;
	}

    private function parse() {
		// Remove the comment markers
        $docs = str_replace(['/*', '*/', '*'], '', $this->docs);

        // collapse all the lines down into a single line string
        $docs = preg_replace('/\s+/', ' ', $docs);

        // Split up the string y that annotations
        preg_match_all("/(@\w+)\s+((?:[^@]\S*?\s+)*)/", $docs, $annotations, \PREG_SET_ORDER);

        foreach($annotations as $annotation) {
            // Skip if the annotation is on the blacklist
            if (self::$blacklist && in_array($annotation[1], self::$blacklist))
                continue;

            // If annotation has no value (flag)
            if(empty($annotation[2])) {
                if(!array_key_exists($annotation[1], $this->annotations)) {
                    $this->annotations[$annotation[1]] = null;
                }
            }

            else {
                // attempt to decode the array as json
                $value = json_decode($annotation[2], true);

                // if decode failed treat as a single value
                if (!is_array($value))
                    $value = trim($annotation[2]);


                /* ============================
                 *  Add the value to the array
                 * ============================ */

                // First entry
                if(!array_key_exists($annotation[1], $this->annotations))
                    $this->annotations[$annotation[1]] = [$value];
                // Second or greater entry
                else
                    $this->annotations[$annotation[1]][] = $value;
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
