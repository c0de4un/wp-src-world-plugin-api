<?php

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// CLASS
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

final class SRCWTimer
{

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                          FIELDS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    
    /** Start in seconds @var Integer */
    private $timeStart;

    /** Start in Microseconds @var Integer */
    private $microsecondsStart;

    /** Stop in Seconds @var Integer */
    private $time_stop;

    /** Stop in Microseconds @var Integer */
    private $microseconds_stop;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                        CONSTRUCTOR
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * @param Boolean $start = true
    */
    public function __construct( bool $start = true )
    {
        if ( $start ) {
            $this->Start();
        }
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                     GETTERS & SETTERS
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function getSecondsElapsed(): int
    {
        $time_end         = $this->time_stop;
        $microseconds_end = $this->microseconds_stop;
        if (!$time_end) {
            [$microseconds_end, $time_end] = explode( ' ', microtime() );
        }

        return $time_end - $this->time_start;
    }

    /**
     * Returns 6-digits precision microseconds float
    */
    public function getMicrosecondsElapsed(): float
    {
        $time_end         = $this->time_stop;
        $microseconds_end = $this->microseconds_stop;
        if (!$time_end) {
            [$microseconds_end, $time_end] = explode( ' ', microtime() );
        }

        $seconds      = $time_end - $this->time_start;
        $microseconds = $microseconds_end - $this->microseconds_start;

        // now the integer section ($seconds) should be small enough
        // to allow a float with 6 decimal digits
        return round( ($seconds + $microseconds), 6 );
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //                       METHODS.PUBLIC
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    public function Start(): void {
        [$this->microseconds_start, $this->time_start] = explode( ' ', microtime() );
        $time_stop         = null;
        $microseconds_stop = null;
    }

    public function Stop(): void
    {
        [$this->microseconds_stop, $this->time_stop] = explode( ' ', microtime() );
    }

    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

};

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
