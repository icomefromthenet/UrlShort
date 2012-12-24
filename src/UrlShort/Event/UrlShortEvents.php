<?php
namespace UrlShort\Event;

/**
  *  Maps events to string name
  *
  *  @access since 1.0.0
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  */
final class UrlShortEvents
{
    /**
     * The urlshort.lookup event is thrown each time a url is queried with shortcode.
     *
     * The event listener receives an
     * UrlShort\Event\UrlLookupEvent instance.
     *
     * @var string
     */
    const LOOKUP = 'urlshort.lookup';
    
    
    /**
     * The urlshort.create event is thrown each time new url is to be added.
     *
     * The event listener receives an
     * UrlShort\Event\UrlStoreEvent instance.
     *
     * @var string
     */
    const CREATE = 'urlshort.store';
    
    
    /**
     * The 'urlshort.query'event is thrown each time a query is to be run.
     *
     * The event listener receives an
     * UrlShort\Event\UrlQueryEvent instance.
     *
     * @var string
     */
    const QUERY = 'urlshort.query';
    
    
    /**
     * The urlshort.purge event is thrown each time old links to be purged
     *
     * The event listener receives an
     * UrlShort\Event\UrlPurgeEvent instance.
     *
     * @var string
     */
    const PURGE = 'urlshort.purge';
    
    
    /**
     * The 'urlshort.remove' event is thrown each time a url is to be removed
     *
     * The event listener receives an
     * UrlShort\Event\UrlRemoveEvent instance.
     *
     * @var string
     */
    const REMOVE = 'urlshort.remove';
    
    
     /**
     * The 'urlshort.spamcheck' event is thrown each time a url evaluated against spam check
     *
     * The event listener receives an
     * UrlShort\Event\UrlSpamCheckEvent instance.
     *
     * @var string
     */
    const SPAMCHECK = 'urlshort.spamcheck';
}

/* End of File */