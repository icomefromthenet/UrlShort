<?php
namespace UrlShort;

/**
  *  Implementation of ShortGeneratorInterface will convert database id into a unique shortcode
  *
  *  Inspired by the PHPMaster Article http://phpmaster.com/building-your-own-url-shortener/
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */  
class ShortCodeGenerator implements ShortGeneratorInterface
{
    
    
    /**
      *  @var array[string] characters to use in shortner 
      */
    protected $chars;
    
    /**
      *  @var integer the char length 
      */
    protected $charLength;
    
    /**
      *  Class Constructor
      *
      *  @param string $chars the characters to use in the shortcode generator
      */
    public function __construct($chars)
    {
        $this->charLength = strlen($chars);
        
        # make sure length of available characters is at least a reasonable minimum (10 chars).
	if ($this->charLength < 10) {
	    throw new UrlShortException("Length of chars is too small");
        }
        
        $this->chars = $chars;
        
    }
    
    
    /**
      *  Convert a database id into a unique short code
      *
      *  @access public
      *  @param  integer $id database id
      *  @return string a shortcode
      *
      * Inspired by Orignal work of BuildingYourOwnURLShortener
      * @link https://github.com/phpmasterdotcom/BuildingYourOwnURLShortener/blob/master/include/ShortUrl.php
      */
    public function convert($id)
    {
	if ($id < 1) {
	    throw new UrlShortException("The ID is not a valid integer");
	}
	 
	$length = $this->charLength;
	$code   = "";
        
	while ($id > ($length - 1)) {
	    // determine the value of the next higher character
	    // in the short code should be and prepend
	    $code = $this->chars[fmod($id, $length)] .
            $code;
            
            // reset $id to remaining value to be converted
	    $id = floor($id / $length);
	}
	 
	// remaining value of $id is less than the length of the chars
	$code = $this->chars[$id].$code;
	 
        return $code;
    }
    
    
    
    
}
/* End of File */