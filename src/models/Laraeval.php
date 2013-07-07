<?php
use Illuminate\Support\Facades\Event as Event;
/**
 * Class model for evaluating the PHP's code
 *
 * @author Rio Astamal <me@rioastamal.net>
 */
class Laraeval {
    protected $code;
    protected $outputType;
    protected $output;
    protected $execTime;
    protected $memory;
    protected $queries;

    /**
     * Constructor
     *
     * @param string $code - PHP's code that we want to evaluate
     */
    public function __construct($code='') {
        $this->code = $code;
        $this->outputType = 'string';
        $this->execTime = array();
        $this->memory = array(
            'current' => 0.0,
            'peak' => 0.0
        );
        $this->queries = array();
    }
    
    /**
     * Method for evaluating the PHP's code. 
     *
     * @param string $code - PHP's code that we want to evaluate
     * @return string
     */
    public function execute($code='') {
        // if argument is given then we override code that has been set on the constructor.
        if (strlen($code) > 0) {
            $this->code = $code;
        }

        $me = $this;

        // listen to the laravel query event
        Event::listen('illuminate.query', function($query, $bindings, $time, $name) use ($me) {
            $me->addQuery($query, $bindings, $time, $name);
        });
        
        
        // start to buffer the output
        ob_start();
        
        // OK, this is the time...
        $start = microtime(TRUE);
        
        $retval = eval($this->code);
        
        $end = microtime(TRUE);
        $this->execTime = $end - $start;

        // if the eval() return FALSE then it could be syntax error.
        if ($retval === FALSE) {
            throw new Exception("I can not evaluate your code, it could be syntax error or " .
                                "you're drunk. Please check your code or make some coffee."
            );
        }

        // collect memory usage
        $this->memory = array(
            'current' => memory_get_usage(TRUE),
            'peak' => memory_get_peak_usage(TRUE),
        );
        
        // catch the output buffer that we getting from eval() above
        $this->output = ob_get_contents();
        
        // clear the output buffer
        ob_end_clean();
        
        return $this->render();
    }

    /**
     * Method for getting the execution time.
     *
     * @param string $format - One of micro|nano|mili|second.
     * @param int $precision - Number of precision digit
     * @return array
     */
    public function getExecTime($format='mili', $precision=4) {
        $result = array(
            'time' => 0.0,
            'format' => 'microseconds',
            'short_format' => '&#181;s'   //  µs
        );

        // validate the format
        $valid_format = array('micro', 'nano', 'mili', 'second');
        if (in_array($format, $valid_format) === FALSE) {
            throw new Exception (sprintf('Argument one for %s::%s is not valid.',
                                         get_class($this),  // vs __CLASS__ ?
                                         'getExecTime()'
            ));
        }

        switch ($format) {
            case 'nano':
                $result['time'] = number_format($this->execTime / 1000, $precision);
                $result['format'] = 'nanoseconds';
                $result['short_format'] = 'ns';
            break;

            case 'mili':
                $result['time'] = number_format($this->execTime * 1000, $precision);
                $result['format'] = 'miliseconds';
                $result['short_format'] = 'ms';
            break;

            case 'second':
                $result['time'] = number_format($this->execTime, $precision);
                $result['format'] = 'seconds';
                $result['short_format'] = 'sec';
            break;
            
            case 'micro':
            default:
                $result['time'] = number_format($this->execTime, $precision);
            break;
        }

        return $result;
    }

    /**
     * Method for getting memory usage used when evaluate the code.
     *
     * @param string $use - One of current|peak
     * @param string $size - One of MB|KB|BYTES
     */
    public function getMemoryUsage($use='current', $size='MB') {
        // check for valid use
        $valid_use = array('current', 'peak');
        if (in_array($use, $valid_use) === FALSE) {
            throw new Exception (sprintf('Argument one for %s::%s is not valid.',
                                         get_class($this),
                                         'getMemoryUsage()'
            ));
        }

        $memory = $this->memory[$use];

        $size = strtoupper($size);
        switch ($size) {
            case 'BYTES':
                return $memory;
            break;

            case 'KB':
                // two digit precision
                return number_format(($memory / 1000), 2);
            break;
            
            case 'MB':
            default:
                // two digit precision
                return number_format(($memory / 1000000), 2);
            break;
        }
    }

    /**
     * Method for accessing the $queries property.
     *
     * @return array
     */
    public function getQueries() {
        return $this->queries;
    }

    /**
     * Method for adding query that executed by Laravel query.
     *
     * @param string $param - First paramete
     * @param array $binding - number of bindings data
     * @param float $time - Time taken for executing the query
     * @param string $name - Name of the connection
     * @return void;
     */
    public function addQuery($query, $bindings, $time, $name) {
        // replace all the `?` bindings with the actual value
        foreach ($bindings as $value) {
            $value = DB::connection()->getPDO()->quote($value);
            $query = preg_replace('#\?#', $value, $query, 1);
        }
        $this->queries[] = array(
            'query' => $query,
            'time' => $time,
            'name' => $name
        );
    }
    
    /**
     * Method for setting the output type.
     *
     * @param string $type - Valid values are: 'string' | 'json'
     * @return string
     */
    protected function render() {
        if ($this->outputType == 'json') {
            $json = new stdClass();
            $json->code = $this->code;
            $json->output = $this->output;
            
            return json_encode($json);
        }
        
        return $this->output;	// string output (the default)
    }
}
