<?php 

class Person{

    public function __construct($name,$tel,$car_model,$man_num,$date_time) {
        $this->name = $name;
        $this->tel = $tel;
        $this->car_model = $car_model;
        $this->man_num = $man_num;
        $this->date_time = $date_time;
    }

    public function SetName($name)
	{
		$this->values['name'] = $name;
    }
    public function GetName()
    {
        return $this->values['name'];
    }


    public function SetTel($tel)
    {
        $this->values['tel'] = $tel;
    }
    public function GetTel()
    {
        return $this->values['tel'];
    }

    public function SetCarModel($car_model)
    {
        $this->values['car_model'] = $car_model;
    }
    public function GetCarModel()
    {
        return $this->values['car_model'];
    }

    public function SetManNum($man_num)
    {
        $this->values["man_num"] = $man_num;
    }
    public function GetManNum()
    {
        return $this->values['man_num'];
    }

    public function SetDateTime($date_time)
    {
        $this->values['date_time'] = $date_time;
    }
    public function GetDateTime()
    {
        return $this->values['date_time'];
    }
}

?>