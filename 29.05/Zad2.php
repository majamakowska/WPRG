<?php
interface Employee {
    public function getSalary();
    public function setSalary($salary);
    public function getRole();
}
class Manager implements Employee {
    private $salary;
    private $employees = [];

    public function getSalary() {
        return $this->salary;
    }
    public function setSalary($salary) {
        $this->salary = $salary;
    }
    public function getRole() {
        return get_class($this);
    }
    public function addEmployee(Employee $employee) {
        $this->employees[] = $employee;
    }
    public function getEmployees() {
        return $this->employees;
    }
}
class Developer implements Employee {
    private $salary;
    private $programmingLanguage;

    public function getSalary() {
        return $this->salary;
    }
    public function setSalary($salary) {
        $this->salary = $salary;
    }
    public function getRole() {
        return get_class($this);
    }
    public function setProgrammingLanguage($programmingLanguage) {
        $this->programmingLanguage = $programmingLanguage;
    }
    public function getProgrammingLanguage() {
        return $this->programmingLanguage;
    }
}
class Designer implements Employee
{
    private $salary;
    private $designingTool;

    public function getSalary()
    {
        return $this->salary;
    }
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }
    public function getRole()
    {
        return get_class($this);
    }
    public function setDesigningTool($designingTool)
    {
        $this->designingTool = $designingTool;
    }
    public function getDesigningTool()
    {
        return $this->designingTool;
    }
}

$developer1 = new Developer();
$developer1->setSalary(8500);
$developer1->setProgrammingLanguage("C");

$developer2 = new Developer();
$developer2->setSalary(8900);
$developer2->setProgrammingLanguage("Python");

$designer1 = new Designer();
$designer1->setSalary(7400);
$designer1->setDesigningTool("Photoshop");

$manager = new Manager();
$manager->setSalary(12300);
$manager->addEmployee($developer1);
$manager->addEmployee($developer2);
$manager->addEmployee($designer1);

foreach ($manager->getEmployees() as $employee) {
    echo "Rola: " . $employee->getRole();
    if ($employee->getRole() == "Developer") {
        echo ", Jezyk programowania: " . $employee->getProgrammingLanguage();
    }
    if ($employee->getRole() == "Designer") {
        echo ", Narzędzie: " . $employee->getDesigningTool();
    }
    echo ", Pensja: " . $employee->getSalary() . "\n";
}
?>