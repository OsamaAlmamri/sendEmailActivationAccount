<?PHP




class Register{
	
	private $pdoObject;
	private $full_name;
	private $email;
	private $pass;
	private $status;
	
	private $code;
	
	function __construct($userData){
		$this->pdoObject=new PDO("mysql:host=localhost;dbname=hanan_shop","hanan_shopuser","user@2020");
		$this->full_name=$userData["full_name"];
		$this->email=$userData["email"];
		$this->pass=$userData["pass"];
	}
	
	
	function generateCode(){
		$this->code= rand(1000,9999);
		return $this->code;
	}
	
	function createUser(){
		$statement=$this->pdoObject->prepare("insert into members values(null,?,?,?,?,0)");
		$statement->execute(array($this->full_name,$this->email,$this->pass,$this->generateCode()));
		
		$this->sendEmail();
		
	}
	
	function sendEmail(){
		
		$activation_link="http://uni-be.net/members/activation.php?u_email=".$this->email."&code=".$this->code;
		$from="info@uni-be.net";
		$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
		
		$msg="<body>
		شكرا لك لقد تم تسجيلك في الموقع <br>
		لتأكيد حسابك يرجى الضغط على الرابط التالي <p>".$activation_link."</p>
		</body>";
		
		mail($this->email,"تأكيد الاشتراك موقع اكاديمية البرمجة",$msg,$headers);
		
	}
	
}



$newUser=new Register($_POST);
$newUser->createUser();













?>