<?php
namespace UrlShort;

/**
  *  Interface for Generators to implement
  *
  *  @since 1.0.1
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
interface ShortGeneratorInterface
{
    
    /**
      *  Convert a database id into a unique short code
      *
      *  @access public
      *  @param  integer $id database id
      *  @return string a shortcode
      */
    public function convert($id);
    
}
/* End of File */