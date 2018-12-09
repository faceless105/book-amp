<?php

/*
Chapter 7 - Object Scope
Goal: Demonstrate visibility and non/static
*/

class parentClass{

	public $scopePublic = "Public";
	protected $scopeProtected = "Protected";
	private $scopePrivate = "Private";
	
	public static $name = 'Jay';
	public $age = 33;
	
	public function testScopeParent(){
		
		echo $this->scopePublic ."<br>\n";
		echo $this->scopeProtected ."<br>\n";
		echo $this->scopePrivate ."<br>\n";
		
	}
	
	public function getName(){
		echo "Static Name: ". self::$name.'<br>';
	}
	
	public function setName($name){
		self::$name = $name;
	}
	
	public function getAge(){
		echo "Non-Static Age: ". $this->age.'<br>';
	}
	
	public function setAge($age){
		$this->age = $age;
	}
	
}

class child extends parentClass{
	
	public function testScopeChild(){
		
		echo $this->scopePublic ."<br>\n";
		echo $this->scopeProtected ."<br>\n";
		echo @$this->scopePrivate ."<br>\n";
		
	}
	
}

//Start by demonstrating visibility in regards to scope

echo "Visibility Testing";
echo "<br>\n<br>\n";

$child = new child();

//Lets take a look at public protected and private
echo "Calling the variables globally outside of the object.<br>\n";
echo $child->scopePublic."<br>\n";
//echo $child->scopeProtected."<br>\n";
//echo $child->scopePrivate."<br>\n";

echo "<br>\n<br>\n";
echo "Calling the variables from the child class.<br>\n";
//only public and protected should work
$child->testScopeChild();

echo "<br>\n<br>\n";
echo "Calling the variables from the parent class.<br>\n";
$child->testScopeParent();

echo "<br>\n<br>\n";
echo "Static Testing";
echo "<br>\n<br>\n";

//now lets test static
$child2 = new child();

echo 'Get Child 1 Name: ';
$child->getName();
echo 'Get Child 2 Name: ';
$child2->getName();
echo 'Now we set the Static Child 1 name to Billy with the setName Object Function, and leave Child 2 alone<br>';
$child->setName('Billy');
echo 'Get Child 1 Name: ';
$child->getName();
echo 'Get Child 2 Name: ';
$child2->getName();
echo 'Now we set the Static Child name to Landon by accessing the static variable through the class, leaving both objects alone<br>';
child::$name = "Landon"; //also work with parentClass::$name, but since we set the visibility to public, it is inherited in the child class.
echo 'Get Child 1 Name: ';
$child->getName();
echo 'Get Child 2 Name: ';
$child2->name = 'Francis';
$child2->getName();

echo "<br>\n<br>\n";
echo "Non-Static Testing";
echo "<br>\n<br>\n";

//now lets test non-static
echo 'Get Child 1 age: ';
$child->getAge();
echo 'Get Child 2 age: ';
$child2->getAge();
echo 'Now we set the Non-Static Child 1 age to 57 with the setAge Object Function, and leave Child 2 alone<br>';
$child->setAge(57);
echo 'Get Child 1 age: ';
$child->getAge();
echo 'Get Child 2 age: ';
$child2->getAge();
echo 'Now we set the Non-Static Child 1 age to 41 by accessing the non-static variable through the Child 1 object, leaving Child 2 alone<br>';
$child->age = 41;
echo 'Get Child 1 age: ';
$child->getAge();
echo 'Get Child 2 age: ';
$child2->getAge();


?>
