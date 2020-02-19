<?PHP
class Activation{
	
	private $pdoObject;
	private $email;
	private $code;
	
	function __construct($userData){
		$this->pdoObject=new PDO("mysql:host=localhost;dbname=hanan_shop","hanan_shopuser","user@2020");
		$this->email=$userData["u_email"];
		$this->code=$userData["code"];

	}
	
	
	
	
	function activeUser(){
		$statement=$this->pdoObject->prepare("update members set u_status=1 where u_email=? and u_code=?");
		$statement->execute(array($this->email,$this->code));
		
		$this->sendEmail();
		
	}
	
	function sendEmail(){
		
		$activation_link="http://uni-be.net/members/activation.php?u_email=".$this->email."&code=".$this->code;
		$from="info@uni-be.net";
		$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
		
		$msg="<body>
		تم تفعيل اشتراكك في الموقع يمكنك الان المشاركة 
والاستفادة من خدمات الموقع بشكل متكامل</body>";		
		mail($this->email,"تفعيل الحساب",$msg,$headers);
		
	}
	
}



$activeUser=new Activation($_GET);
$activeUser->activeUser();













?>