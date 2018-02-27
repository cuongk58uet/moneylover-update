<?php
class ToolComponent extends Component{
	public function generate_code(){
		$random_number = rand(1,90000000);
		$code = md5($random_number);
		return $code;
	}

}
?>