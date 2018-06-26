<?php 
	class Message { 

		var $id;
		var $username;
		var $content;
		var $date;
		var $messgeid;

		function getid(){

			echo $this->id . PHP_EOL;
		}

		function setid($par){

			$this->id = $par;
		}

		function setContent($par){

			$this->content = $par;

		}

		function getContent(){
			echo $this->content . PHP_EOL;
		}

		function setUsername($par){

			$this->username = $par;
		}

		function getUserName(){

			echo $this->username;
		}



	}

?>