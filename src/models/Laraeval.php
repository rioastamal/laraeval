<?php 

class Laraeval {
	protected $code;
	protected $outputType;
	private $output;

	/**
	 * Constructor
	 *
	 * @param string $code - PHP's code that we want to evaluate
	 */
	public function __construct($code='') {
		$this->code = $code;
		$this->outputType = 'string';
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
		
		// start to buffer the output
		ob_start();
		
		// OK, this is the time...
		eval($this->code);
		
		// catch the output buffer that we getting from eval() above
		$this->output = ob_get_contents();
		
		// clear the output buffer
		ob_end_clean();
		
		return $this->render();
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
