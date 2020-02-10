<?php
class Registered_model extends MY_Model
{
	protected $table_name = 'users';
    public $email;
    public $username;
    public $lastname;
	public $password;
    
	function __construct($properties = [])
	{
		parent::__construct($properties);
	}

	public function auth()
    {
	    $new = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );

    	if($this->getRow($new) == true)
    	{
    		$_SESSION['userid'] = $this->getRow($new)->id;
    		return 1;
    	}
    	else
    	{
    		return 0;
    	}
    }  

    // public function forgotPassword($email)
    // {
    //     $new = array(
    //         'email' => $email
    //     );

    //     if($this->getRow($new) == true)
    //     {
    //         $password = $this->getRow($new)->password;
    //         return $password;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }  


}