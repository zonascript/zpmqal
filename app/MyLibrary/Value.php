

<?php 
	namespace App\MyLibrary;

	/**
	* this class for data object use this class if you 
	* don't want any error while pulling key from any 
	* object or array 
	*/


	abstract class Creator {
	  public function __get($name) {
	      if (! isset ( $this->{$name} )) {
	          $this->{$name} = new Value ( $name, null );
	      }
	      return $this->{$name};
	  }

	  public function __set($name, $value) {
	      $this->{$name} = new Value ( $name, $value );
	  }
	}

	class Value extends Creator {
    private $name;
    private $value;
    function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }
	} 

	class MyData extends Value
	{
		protected $data  = [];

		function __construct(Array $data)
		{
			$this->data = $data;
		}
	}